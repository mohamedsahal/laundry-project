<?php

namespace App\Livewire\Reports;

use App\Models\Translation;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Title;
use Livewire\Component;

class PurchaseReturnReport extends Component
{
    public $from_date, $to_date, $purchase_return, $lang;

    #[Title('Purchase Return Report')]
    public function render()
    {
        return view('livewire.reports.purchase-return-report');
    }
    public function mount()
    {
        $this->from_date = \Carbon\Carbon::today()->toDateString();
        $this->to_date = \Carbon\Carbon::today()->toDateString();
        if(session()->has('selected_language'))
        {
            $this->lang = Translation::where('id',session()->get('selected_language'))->first();
        }
        else{
            $this->lang = Translation::where('default',1)->first();
        }
        $this->report();
    }

    public function updated($name,$value)
    {
        $this->report();
    }
    public function report()
    {
        $this->purchase_return = \App\Models\PurchaseReturn::whereDate('invoice_date', '>=', $this->from_date)->whereDate('invoice_date', '<=', $this->to_date)->latest()->get();
    }
    public function downloadFile()
    {
        $from_date = $this->from_date;
        $to_date = $this->to_date;
        $pdfContent = Pdf::loadView('livewire.reports.download-report.purchase-return-report', compact('from_date', 'to_date'))->output();
        return response()->streamDownload(fn ()=>print($pdfContent), "PurchaseReturnReport_from_" .$from_date . ".pdf");
    }
}
