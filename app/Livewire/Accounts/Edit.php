<?php

namespace App\Livewire\Accounts;

use App\Models\Account;
use Livewire\Component;
class Edit extends Component
{
    public $accountid;
    public $name;
    public $password;
    public $role;

    protected $rules = [
        'name' => 'required|string|max:255',
        'password' => 'required',
        'role' => 'required|string|max:500',
    ];

    protected $messages = [
        'name.required' => 'حقل الاسم مطلوب',
       
        'password.required' => 'حقل رقم السر مطلوب ',
        'role.required' => 'حقل الرول مطلوب',
    ];

    public function mount($accountid)
    {
        $this->accountid = $accountid;
        $this->loadaccount();
    }

    public function loadaccount()
    {
        $account = account::findOrFail($this->accountid);
        $this->name = $account->name;
        $this->password = $account->password;
        $this->role = $account->role;
    }

    public function update()
    {

       
          $this->validate([
            'name' => 'required',
            'password' => 'required',
            'role' => 'required',
          
        ]);

        $account = account::findOrFail($this->accountid);
        $account->update([
            'name' => $this->name,
            'password' => $this->password,
            'role' => $this->role,
            
        ]);

        flash()->addSuccess('تم التحديث بنجاح.');
        return redirect()->route('accounts.create'); // update to your actual route
    }

   



    public function render()
    {
        return view('livewire.accounts.edit');
    }

}