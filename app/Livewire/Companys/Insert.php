<?php

namespace App\Livewire\Companys;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Company;

class Insert extends Component
{
     #[Validate('required|unique:companys,companyname')]
    public $companyname = '';

    public function store()
    {
        $validated = $this->validate();

        Company::create($validated);

        flash()->Success('تم الإضافة بنجاح.');


        return redirect()->route('companys.create');
    }


    public function render()
    {
        return view('livewire.companys.insert');
    }
}
