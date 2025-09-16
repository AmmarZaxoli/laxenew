<?php

namespace App\Livewire\GetAPI;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;

class Approved extends Component
{
    use WithPagination;

    public $email = 'ammarzaxoli95@gmail.com';
    public $password = '12345678';
    public $token;
    public $orders = [];
    public $loading = false;
    public $totalOrders = 0;
    public $perPage = 10;
    public $currentPage = 1;

    // Search filters
    public $phoneNumber;
    public $from_date;
    public $to_date;

    public function mount()
    {
        $this->authenticateAndFetch();
        $this->from_date = date('Y-m-d');
        $this->to_date = date('Y-m-d');
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
            $this->fetchOrders($this->currentPage);
        } else {
            session()->flash('error', 'Authentication failed! Please check your credentials.');
            $this->orders = [];
            $this->totalOrders = 0;
        }

        $this->loading = false;
    }

    public function fetchOrders($page = 1)
    {
        if (!$this->token) {
            session()->flash('error', 'No token available. Please try reloading the page.');
            return;
        }

        $this->loading = true;

        // Build query parameters
        $queryParams = [
            'page' => $page,
            'limit' => $this->perPage,
            'status' => 'APPROVED',
        ];

        // Add phone number filter if provided
        if (!empty($this->phoneNumber)) {
            $queryParams['phoneNumber'] = $this->phoneNumber;
        }

        // Add date filters if provided
        if (!empty($this->from_date)) {
            $queryParams['startDate'] = $this->from_date;
        }
        
        if (!empty($this->to_date)) {
            $queryParams['endDate'] = $this->to_date;
        }

        $response = Http::withToken($this->token)
            ->get('https://laxe-backend-production.up.railway.app/api/v1/orders/all', $queryParams);

        if ($response->successful()) {
            $this->orders = $response->json('allOrders') ?? [];
            $this->totalOrders = $response->json('totalOrders') ?? count($this->orders);
        } else {
            session()->flash('error', 'Failed to fetch orders! Status: ' . $response->status());
            $this->orders = [];
            $this->totalOrders = 0;
        }

        $this->loading = false;
    }

    public function searchOrders()
    {
        $this->currentPage = 1;
        $this->fetchOrders(1);
    }

    public function resetSearch()
    {
        $this->phoneNumber = '';
        $this->from_date = date('Y-m-d');
        $this->to_date = date('Y-m-d');
        $this->searchOrders();
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
        if ($this->currentPage < $this->totalPages) {
            $this->currentPage++;
            $this->fetchOrders($this->currentPage);
        }
    }

    // Use a computed property instead of a method to avoid the "not callable" error
    public function getTotalPagesProperty()
    {
        return $this->totalOrders > 0 ? ceil($this->totalOrders / $this->perPage) : 1;
    }

    public function render()
    {
        return view('livewire.getAPI.approved');
    }
}