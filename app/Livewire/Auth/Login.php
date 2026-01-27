<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class Login extends Component
{
    public $name = '';
    public $password = '';
    public $error = '';

    public function mount()
    {
        // Prevent login if no accounts exist
        if (!Account::exists()) {
            session()->flash('error', 'No accounts exist. Contact the administrator.');
        }
    }
    public function login()
    {
        $this->validate([
            'name' => 'required',
            'password' => 'required'
        ]);

        $account = Account::where('name', $this->name)->first();

        if (!$account || $this->password !== $account->password) {
            $this->error = 'كلمة المرور غير صحيحة';
            return;
        }

        Auth::guard('account')->login($account);
        session()->put('login_via_form', true);

        // --- ل ڤێرێ داخوازا API بکە بۆ وەرگرتنا Token ---
        try {
            $response = Http::post('https://laxe-backend-production.up.railway.app/api/v1/auth/signin', [
                'email' => 'ammarzaxoli95@gmail.com', // ئیمێلێ API
                'password' => '12345678',             // پۆستوۆردێ API
            ]);

            if ($response->successful()) {
                // Token د ناڤ Session دا پاشکەفت بکە
                session()->put('api_token', $response->json('token'));
            }
        } catch (\Exception $e) {
            // ئەگەر ئاریشەیەک هەبیت د ئینتەرنێتێ دا
            
        }
        // ----------------------------------------------

        if ($account->role === 'admin') {
            return redirect()->route('dashboard');
        }
        return redirect()->route('selling.create');
    }
    public function render()
    {
        $accounts = Account::all();
        return view('livewire.auth.login', compact('accounts'));
    }
}
