<?php

namespace App\Livewire\Components;

use App\Models\MasterSettings;
use Livewire\Component;

class CheckFinancialYearComponent extends Component
{
    public $no_financial_year = false;
    public function render()
    {
        return view('livewire.components.check-financial-year-component');
    }

    public function mount()
    {
        $settings = new MasterSettings();
        $site = $settings->siteData();
        if(!isset($site['default_financial_year']) || !$site['default_financial_year'] || $site['default_financial_year'] == '')
        {
            $this->no_financial_year = true;
        }
    }
}
