<?php

namespace App\Livewire\Companys;

use App\Models\Company;
use Livewire\Component;

class Edit extends Component
{
    public $companyId;
    public $companyname;

    public function mount($company_id)
    {
        $this->companyId = $company_id;
        $company = Company::findOrFail($company_id);
        $this->companyname = $company->companyname;
    }


    public function update()
    {
        $this->validate([
            'companyname' => 'required',
        ]);

        $company = Company::findOrFail($this->companyId);
        $company->update([
            'companyname' => $this->companyname,
        ]);

        flash()->addSuccess('تم التحديث بنجاح.');
        return redirect()->route('companys.create');
    }
    public function render()
    {
        return view('livewire.companys.edit');
    }
}
