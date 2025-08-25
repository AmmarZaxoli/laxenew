<?php

namespace App\Livewire\GetAPI;

use App\Models\Definition;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;
use App\Models\Driver;

class Show extends Component
{
    use WithPagination;

    public $email = 'ammarzaxoli95@gmail.com';
    public $password = '12345678';
    public $responseMessage = '';
    public $orders = [];
    public $loading = false;
    public $totalOrders = 0;
    public $perPage = 10;
    public $currentPage = 1;
    public $token;
    public $drivers;

    public $showModal = false;
    public $modalProducts = [];
    public $selected_driver;

    public function mount()
    {
        $this->authenticateAndFetch();
        $this->drivers = Driver::all();
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
            $this->responseMessage = 'Successfully authenticated. Loading orders...';
            $this->fetchOrders($this->currentPage);
        } else {
            $this->responseMessage = 'Authentication failed! Please check your credentials.';
            $this->orders = [];
            $this->totalOrders = 0;
        }

        $this->loading = false;
    }

    public function fetchOrders($page = 1)
    {
        if (!$this->token) {
            $this->responseMessage = 'No token available. Please try reloading the page.';
            return;
        }

        $this->loading = true;

        $response = Http::withToken($this->token)
            ->get('https://laxe-backend-production.up.railway.app/api/v1/orders/all', [
                'page' => $page,
                'limit' => $this->perPage,
                'status' => 'PENDING',
            ]);

        if ($response->successful()) {
            $this->orders = $response->json('allOrders') ?? [];
            $this->totalOrders = $response->json('totalOrders') ?? count($this->orders);
            $this->responseMessage = count($this->orders) . ' pending orders found.';
        } else {
            $this->responseMessage = 'Failed to fetch orders!';
            $this->orders = [];
            $this->totalOrders = 0;
        }

        $this->loading = false;
    }

    public function gotoPage($page)
    {
        $this->currentPage = $page;
        $this->fetchOrders($page);
    }

    public function previousPage()
    {
        if ($this->currentPage > 1) {
            $this->currentPage--;
            $this->fetchOrders($this->currentPage);
        }
    }

    public function nextPage()
    {
        if ($this->currentPage < $this->totalPages()) {
            $this->currentPage++;
            $this->fetchOrders($this->currentPage);
        }
    }

    public function totalPages()
    {
        return $this->totalOrders > 0 ? ceil($this->totalOrders / $this->perPage) : 1;
    }

    public function view($id)
    {
        $order = collect($this->orders)->firstWhere('id', $id);

        if ($order) {
            $products = [];
            foreach ($order['items'] as $item) {
                $products[] = [
                    'productCode' => $item['product']['productCode'] ?? 'null',
                    'quantity'    => $item['quantity'],
                    'price'       => $item['price'],
                    'total_price' => $item['quantity'] * $item['price'],
                ];
            }

            $this->modalProducts = $products;

            // Dispatch browser event to open modal
            $this->dispatch('openOrderModal');
        } else {
            $this->modalProducts = [];
            session()->flash('error', "Order not found!");
        }
    }
    public function check($id)
    {
        dd($this->orders);
        $order = collect($this->orders)->firstWhere('id', $id);

        if (!$order) {
            flash()->error("Order with ID {$id} not found!");
            return false;
        }

        $missingProducts = [];

        foreach ($order['items'] as $item) {
            $productCode = $item['product']['productCode'] ?? 'null';
            $exists = Definition::where('code', $productCode)->exists();

            if (!$exists) {
                $missingProducts[] = $productCode;
            }
        }

        if (!empty($missingProducts)) {
            $codes = implode(', ', $missingProducts);
            flash()->warning("المنتجات التالية غير متوفرة في قاعدة البيانات المحلية: {$codes}");

            // Remove from selectedOrders to uncheck
            if (($key = array_search($id, $this->selectedOrders)) !== false) {
                unset($this->selectedOrders[$key]);
                $this->selectedOrders = array_values($this->selectedOrders); // reindex array
            }

            return false;
        }

        return true; // All products exist
    }

    public $selectedOrders = [];


    public function render()
    {
        return view('livewire.getAPI.show', [
            'totalPages' => $this->totalPages(),
        ]);
    }
}
