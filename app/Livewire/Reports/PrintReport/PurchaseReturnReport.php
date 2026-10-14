<?php

namespace App\Livewire\Reports\PrintReport;

use Livewire\Attributes\Layout;
use Livewire\Component;

class PurchaseReturnReport extends Component
{
    public $from_date, $to_date, $purchase_return;

    #[Layout('components.layouts.print-layout')]
    public function render()
    {
        return view('livewire.reports.print-report.purchase-return-report');
    }
    
    public function mount( $from_date = null, $to_date=null )
    {
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->purchase_return = \App\Models\PurchaseReturn::whereDate('invoice_date', '>=',$this->from_date)->whereDate('invoice_date', '<=', $this->to_date)->where('status',1)->latest()->get();
    }
}
