<?php

namespace App\Livewire\Companys;

use App\Models\Company;
use Livewire\Component;

class Show extends Component
{
    public $search = '';
  
    public function render()
    {
        $companys = Company::where('companyname', 'like', "%{$this->search}%")
            ->orderBy('id', 'desc')
            ->paginate(10);


        return view('livewire.companys.show', compact('companys'));
    }
}
