<?php

namespace App\Livewire\GetAPI;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Promise;
use GuzzleHttp\Promise\Utils;

class Approved extends Component
{
    public $email = 'ammarzaxoli95@gmail.com';
    public $password = '12345678';
    public $token;
    public $allOrders = [];
    public $orders = [];
    public $loading = false;
    public $totalOrders = 0;
    public $perPage = 30;
    public $currentPage = 1;

    public $phoneNumber;
    public $from_date;
    public $to_date;

    public $selectedOrders = [];
    public $selectAll = false;

    public function mount()
    {
        $this->from_date = date('Y-m-d');
        $this->to_date = date('Y-m-d');
        $this->authenticateAndFetch();
    }

    public function updatedSelectAll($value)
    {
        $this->selectedOrders = $value ? array_column($this->orders, 'id') : [];
    }

    public function updatedSelectedOrders()
    {
        $this->selectAll = count($this->selectedOrders) === count($this->orders);
    }

    public function authenticateAndFetch()
    {
        $this->loading = true;
        $response = Http::post('https://laxe-backend-production.up.railway.app/api/v1/auth/signin', [
            'email' => $this->email,
            'password' => $this->password,
        ]);

        if ($response->successful()) {
            $this->token = $response->json('token');
            $this->fetchOrders();
        } else {
            session()->flash('error', 'Authentication failed!');
        }

        $this->loading = false;
    }

    public function fetchOrders()
    {
        if (!$this->token) return;

        $this->loading = true;

        $queryParams = [
            'status' => 'APPROVED',
            'limit' => 1000,
            'page' => 1,
        ];

        if ($this->phoneNumber) $queryParams['phoneNumber'] = $this->phoneNumber;
        if ($this->from_date) $queryParams['startDate'] = $this->from_date;
        if ($this->to_date) $queryParams['endDate'] = $this->to_date;

        $response = Http::withToken($this->token)
            ->get('https://laxe-backend-production.up.railway.app/api/v1/orders/all', $queryParams);

        if ($response->successful()) {
            $this->allOrders = $response->json('allOrders') ?? [];
            $this->totalOrders = count($this->allOrders);
            $this->setPage(1);
        } else {
            session()->flash('error', 'Failed to fetch orders!');
        }

        $this->loading = false;
    }

    public function setPage($page)
    {
        $this->currentPage = $page;
        $collection = collect($this->allOrders);
        $this->orders = $collection->slice(($page - 1) * $this->perPage, $this->perPage)->values()->all();
        $this->selectedOrders = [];
        $this->selectAll = false;
    }

    public function nextPage()
    {
        $totalPages = ceil($this->totalOrders / $this->perPage);
        if ($this->currentPage < $totalPages) $this->setPage($this->currentPage + 1);
    }

    public function previousPage()
    {
        if ($this->currentPage > 1) $this->setPage($this->currentPage - 1);
    }

    public function goToPage($page)
    {
        $this->setPage($page);
    }

    /**
     * Faster batch update to Delivered
     */


    public function markDelivered()
    {
        if (empty($this->selectedOrders)) {
            flash()->error('لم يتم تحديد أي صفوف!');
            return;
        }

        if (!$this->token) {
            flash()->error('لا يوجد توكن متاح. أعد تحميل الصفحة.');
            return;
        }

        $successIds = [];
        $orderIds = $this->selectedOrders;
        $concurrency = 50; // how many requests run in parallel

        while (!empty($orderIds)) {
            $batch = array_splice($orderIds, 0, $concurrency);
            $promises = [];

            foreach ($batch as $orderId) {
                $promises[$orderId] = Http::withToken($this->token)
                    ->acceptJson()
                    ->withHeaders(['Content-Type' => 'application/json'])
                    ->async()
                    ->patch('https://laxe-backend-production.up.railway.app/api/v1/orders/delivered', [
                        'orderId' => (int) $orderId,
                    ]);
            }

            $responses = Utils::settle($promises)->wait();

            foreach ($responses as $orderId => $res) {
                if ($res['state'] === 'fulfilled' && $res['value']->successful()) {
                    $successIds[] = $orderId;
                } else {
                    $message = $res['state'] === 'rejected'
                        ? $res['reason']->getMessage()
                        : $res['value']->body();
                    flash()->error("فشل تحديث Order #{$orderId}: {$message}");
                }
            }
        }

        // 🔹 Update local orders in one pass
        if (!empty($successIds)) {
            $this->orders = collect($this->orders)->map(function ($order) use ($successIds) {
                if (in_array($order['id'], $successIds)) {
                    $order['status'] = 'DELIVERED';
                }
                return $order;
            })->toArray();

            flash()->success("تم تغيير حالة " . count($successIds) . " order(s) إلى Delivered.");
        }

        $this->selectedOrders = [];
        $this->selectAll = false;

        return redirect()->route('getAPI.approved');
    }


    public function searchOrders()
    {
        $this->fetchOrders();
    }

    public function resetSearch()
    {
        $this->phoneNumber = '';
        $this->from_date = date('Y-m-d');
        $this->to_date = date('Y-m-d');
        $this->fetchOrders();
    }

    public function render()
    {
        $totalPages = ceil($this->totalOrders / $this->perPage);
        return view('livewire.getAPI.approved', compact('totalPages'));
    }
}
