<?php

namespace App\Livewire\Paymentinvoice;

use Livewire\Component;
use App\Models\Paymentinvoce;
use App\Models\Buy_invoice;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;

class Show extends Component
{
    public $invoiceId;
    #[Validate('required')]
    public $invoce_id;
    public $payments = [];
    #[Validate('required|date')]
    public $date_payment;
    #[Validate('required|numeric')]
    public $cashpayment;

    public function mount($invoiceId)
    {
        $this->invoce_id = $invoiceId;
        $this->date_payment=now()->format('Y-m-d');
        $this->loadPayments();
    }

    // Load payments for the invoice
    public function loadPayments()
    {

        $this->payments = Paymentinvoce::where('invoce_id', $this->invoiceId)
            ->orderBy('date_payment', 'desc')
            ->get();
    }

    // Submit a new payment
    public function submitPayment()
    {

        $validated = $this->validate();

        Paymentinvoce::create($validated);

        $invoice = Buy_invoice::find($this->invoiceId);
        if ($invoice) {
            $invoice->cash += $this->cashpayment;
            $invoice->residual -= $this->cashpayment;
            $invoice->save();
        }




        // Clear input fields
        $this->date_payment = null;
        $this->cashpayment = null;

        // Reload payments table
        $this->loadPayments();
    }

    public function paymentdelete($id)
    {

        $this->dispatch('confirmpayment', id: $id);
    }
    #[On('deletepayment')]
    public function deletepayment($id)
    {
        $Paymen = Paymentinvoce::find($id);

        if ($Paymen) {
            $invoice = Buy_invoice::find($this->invoiceId);
            if ($invoice) {
                $invoice->cash -= $Paymen->cashpayment;
                $invoice->residual += $Paymen->cashpayment;
                $invoice->save();
            }

            $Paymen->delete();
        }

        $this->loadPayments();
    }


    public function render()
    {
        return view('livewire.paymentinvoice.show');
    }
}
