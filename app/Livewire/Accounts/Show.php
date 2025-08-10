<?php

namespace App\Livewire\accounts;

use App\Models\Account;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $showResults = true;
    public $name = '';
    public $password = '';
    public $role = '';
    public $errorMessage = null;
    public $successMessage = null;

    protected $rules = [
      'name' => 'required|string|max:255',
        'password' => 'required',
        'role' => 'required|string|max:500',
    ];

    protected $messages = [
        'name.required' => 'حقل الاسم مطلوب',
        'password.required' => 'حقل رقم السر مطلوب',
        'role.required' => 'حقل وصف  مطلوب',
    ];







    public function loadaccounts()
    {


        $this->errorMessage = null;
        $this->showResults = true;
        $this->resetPage();
    }
    protected $listeners = ['delete' => 'deleteAccount'];

    public function deleteaccount($id)
    {
        if (! $account = Account::find($id)) {
            $this->errorMessage = 'المصروف غير موجود';
            return;
        }

        $account->delete();

        flash()->addSuccess('تم الحذف بنجاح.');
        $this->loadaccounts();
    }
    // In your Livewire component (e.g., Accounts.php)




    public function dismissAlert()
    {
        $this->reset(['errorMessage', 'successMessage']);
    }
    public function render()
    {
        $accounts = Account::orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.accounts.show', [
            'accounts' => $accounts,
        ]);
    }
}
