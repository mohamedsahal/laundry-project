<?php

namespace App\Livewire\Reports\PrintReport;

use Livewire\Component;
use Livewire\Attributes\Layout;
class DailyReport extends Component
{
    public $today, $new_order, $delivered_orders, $total_payment, $total_expense, $total_material, $total_sales;

    /* render the page*/
    #[Layout('components.layouts.print-layout')]
    public function render()
    {
        return view('livewire.reports.print-report.daily-report');
    }
     /* process before render */
     public function mount($today = null) {
        if(!\Illuminate\Support\Facades\Gate::allows('report_print')){
            abort(404);
        }
         $this->today = $today;
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
}
