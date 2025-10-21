<?php

namespace App\Livewire\userpayment;

use App\Models\Account;
use App\Models\UserPayment;
use Livewire\Component;
use Livewire\Attributes\Validate;

class Show extends Component
{
    #[Validate('required')]
    public $usernames = '';
    public $userpayment = '';
    public $username = '';
    public $date_from;
    public $date_to;

    #[Validate('required|numeric|gt:0')]
    public $payment = 0;

    #[Validate('required|date')]
    public $date;


    public function filterPayments()
    {
        // Validate that both dates are filled
        $this->validate([
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
        ]);

        // Filter between two dates
        $this->userpayment = Userpayment::whereBetween('date', [$this->date_from, $this->date_to])
            ->orderBy('date', 'desc')
            ->get();
    }
    public function mount()
    {
        $this->usernames = Account::all();
        $this->userpayment = userpayment::orderBy('date', 'desc')->get();
        $this->date = now()->format('Y-m-d\TH:i');
        $this->date_from = now()->format('Y-m-d');
        $this->date_to = now()->format('Y-m-d');
    }

    public function save()
    {
        $validated = $this->validate();

        userpayment::create([
            'nameuser' => $this->username,
            'payment'  => $this->payment,
            'date'     => $this->date,
            'admin'    => auth('account')->user()->name ?? 'system',
        ]);


        $this->reset(['payment']);
        $this->date = now()->format('Y-m-d\TH:i');

        flash()->addSuccess(' تمت إضافة الدفع بنجاح.');
    }
    public function delete($id)
    {
        $payment = Userpayment::find($id);

        if ($payment) {
            $payment->delete();
            $this->userpayment = Userpayment::orderBy('date', 'desc')->get(); // Refresh list
            flash()->addSuccess('تم حذف السجل بنجاح.');
        } else {
            flash()->addError('لم يتم العثور على السجل.');
        }
    }

    public function render()
    {
        return view('livewire.userpayment.show');
    }
}
