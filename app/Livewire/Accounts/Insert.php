<?php

namespace App\Livewire\Accounts;

use App\Models\Account;
use Livewire\Component;
use Livewire\Attributes\Validate;

class Insert extends Component
{
    #[Validate('required|min:3')]
    public $name = '';

    #[Validate('required')]
    public $password = '';

    #[Validate('required')]
    public $role = '';

    public function store()
    {
        $validated = $this->validate();

        account::create([
            'name' => $validated['name'],
            'password' => $validated['password'],
            'role' => $validated['role'],

        ]);
        flash()->addSuccess('تم اضافة بنجاح');

        return redirect()->route('accounts.create');
    }
    public function resetForm()
    {
        $this->reset(['name', 'password', 'role']);
        $this->resetErrorBag(); // Clears validation errors
    }
    public function render()
    {
        return view('livewire.accounts.insert');
    }
}
