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


        // Set STRICT session flags
        session()->put('login_via_form', true); //  this marks legit login

        // Redirect based on role
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
