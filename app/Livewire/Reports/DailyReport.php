<?php

namespace App\Livewire\Reports;
use App\Models\Translation;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Title;
class DailyReport extends Component
{
    public $today, $new_order, $delivered_orders, $total_payment, $total_expense, $total_material, $total_sales,$lang;
    /* render the page */
    #[Title('Daily Report')]
    public function render()
    {
        return view('livewire.reports.daily-report');
    }
    /* processed before render */
    public function mount() {
        if(!\Illuminate\Support\Facades\Gate::allows('report_daily')){
            abort(404);
        }
        $this->today =\Carbon\Carbon::today()->toDateString();
        if(session()->has('selected_language'))
        {
            $this->lang = Translation::where('id',session()->get('selected_language'))->first();
        }
        else{
            $this->lang = Translation::where('default',1)->first();
        }
        $this->report();
    }
    /*processed on update of the element */
    public function updated($name,$value) {
        /* any updated on $today model */
        if(($name="today") && ($value!=""))
         {
             $this->today = $value;
        }
        $this->report();
    }
    /* report section */ 
    public function report(){
             $this->new_order = \App\Models\Order::whereDate('order_date',$this->today)->count();
             $this->delivered_orders = \App\Models\Order::whereDate('order_date',$this->today)->where('status',3)->count();
             $this->total_payment = \App\Models\Payment::whereDate('payment_date',$this->today)->sum('received_amount');
             $this->total_expense = \App\Models\Expense::whereDate('expense_date',$this->today)->sum('expense_amount');
             $this->total_material = \App\Models\StockUsage::whereDate('usage_date',$this->today)->sum('total_cost');
             $this->total_sales = \App\Models\Order::whereDate('order_date',$this->today)->where('status',3)->sum('total');
    }

        /* download report */
        public function downloadFile()
        {
            $today = $this->today;
            $pdfContent = Pdf::loadView('livewire.reports.download-report.daily-report', compact('today'))->output();
            return response()->streamDownload(fn () => print($pdfContent), "dailyReport_" . $today . ".pdf");
        }
}
