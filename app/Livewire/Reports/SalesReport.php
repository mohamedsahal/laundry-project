<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Livewire\Attributes\Title;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Translation;

class SalesReport extends Component
{
    public $from_date, $to_date, $orders, $lang;
    /* render the page */
    #[Title('Sales Report')]
    public function render()
    {
        return view('livewire.reports.sales-report');
    }
      /* processed before render */
      public function mount()
      {
        if(!\Illuminate\Support\Facades\Gate::allows('report_sales')){
            abort(404);
        }
          $this->from_date = \Carbon\Carbon::today()->toDateString();
          $this->to_date = \Carbon\Carbon::today()->toDateString();
          if (session()->has('selected_language')) {
              $this->lang = Translation::where('id', session()->get('selected_language'))->first();
          } else {
              $this->lang = Translation::where('default', 1)->first();
          }
          $this->report();
      }
      /*processed on update of the element */
      public function updated($name, $value)
      {
          $this->report();
      }
      /* report section */
      public function report()
      {
          $this->orders = \App\Models\Order::whereDate('order_date', '>=', $this->from_date)->whereDate('order_date', '<=', $this->to_date)->where('status', 3)->latest()->get();
      }
      /* download pdf file */
      public function downloadFile()
      {
          $from_date = $this->from_date;
          $to_date = $this->to_date;
          $pdfContent = Pdf::loadView('livewire.reports.download-report.sales-report', compact('from_date', 'to_date'))->output();
          return response()->streamDownload(fn () => print($pdfContent), "SalesReport_from_" . $from_date . ".pdf");
      }
}
