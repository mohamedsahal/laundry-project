<?php

namespace App\Livewire\Reports\PrintReport;

use Livewire\Attributes\Layout;
use Livewire\Component;

class PurchaseReport extends Component
{
    public $from_date, $to_date, $purchases;

    #[Layout('components.layouts.print-layout')]
    public function render()
    {
        return view('livewire.reports.print-report.purchase-report');
    }

    public function mount( $from_date = null, $to_date=null )
    {
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->purchases = \App\Models\Purchase::whereDate('purchase_date', '>=',$this->from_date)->whereDate('purchase_date', '<=', $this->to_date)->where('status',1)->latest()->get();
    }
}
