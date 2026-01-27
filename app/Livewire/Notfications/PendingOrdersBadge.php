<?php

namespace App\Livewire\Notfications;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class PendingOrdersBadge extends Component
{
    public $count = 0;

    protected $listeners = ['updatePendingOrdersCount' => 'fetchCount'];

    public function mount()
    {
        $this->fetchCount();
    }

    public function fetchCount()
    {
        $token = session()->get('api_token');

        if (!$token) {
            $this->count = 0;
            return;
        }

        try {
            // مە page و limit زێدە کرن دا API ئاریشەیێ چێنەکەت
            $response = Http::withToken($token)
                ->get('https://laxe-backend-production.up.railway.app/api/v1/orders/all', [
                    'status' => 'PENDING',
                    'page'   => 1,   // ئەڤە یا پێدڤی بوو
                    'limit'  => 10   // ئەڤە ژی یا پێدڤی بوو
                ]);

            if ($response->successful()) {
                $this->count = $response->json('totalOrders') ?? 0;
            } else {
                // ئەگەر ئاریشەیەک هەبوو بلا بگەهیتە مە
                $this->count = 0;
            }
        } catch (\Exception $e) {
            $this->count = 0;
        }
    }

    private function getNewToken()
    {
        $response = Http::post('https://laxe-backend-production.up.railway.app/api/v1/auth/signin', [
            'email' => 'ammarzaxoli95@gmail.com',
            'password' => '12345678',
        ]);

        if ($response->successful()) {
            $token = $response->json('token');
            session()->put('api_token', $token);
            return $token;
        }
        return null;
    }

    public function render()
    {
        return <<<'HTML'
        <div wire:poll.5s="fetchCount" style="display: inline-block;">
            @if($count > 0)
                <span class="badge rounded-pill bg-danger animate__animated animate__pulse">
                    {{ $count }}
                </span>
            @endif
        </div>
    HTML;
    }
}
