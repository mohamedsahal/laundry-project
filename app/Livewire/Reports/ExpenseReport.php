<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Livewire\Attributes\Title;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Translation;

class ExpenseReport extends Component
{
    public $from_date, $to_date, $expenses, $lang;
    /* render the page */
    #[Title('Expense Report')]
    public function render()
    {
        return view('livewire.reports.expense-report');
    }
     /* processed before render */
     public function mount()
     {
        if(!\Illuminate\Support\Facades\Gate::allows('report_expense')){
            abort(404);
        }
         $this->from_date = \Carbon\Carbon::today()->toDateString();
         $this->to_date = \Carbon\Carbon::today()->toDateString();
         $this->report();
         if (session()->has('selected_language')) {
             $this->lang = Translation::where('id', session()->get('selected_language'))->first();
         } else {
             $this->lang = Translation::where('default', 1)->first();
         }
     }
     /*processed on update of the element */
     public function updated($name, $value)
     {
         $this->report();
     }
     /* report section */
     public function report()
     {
         $this->expenses = \App\Models\Expense::whereDate('expense_date', '>=', $this->from_date)->whereDate('expense_date', '<=', $this->to_date)->latest()->get();
     }
     /* download pdf file */
     public function downloadFile()
     {
         $from_date = $this->from_date;
         $to_date = $this->to_date;
         $pdfContent = Pdf::loadView('livewire.reports.download-report.expense-report', compact('from_date', 'to_date'))->output();
         return response()->streamDownload(fn () => print($pdfContent), "ExpenseReport_from_" . $from_date . ".pdf");
     }
}
