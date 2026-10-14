<?php
namespace App\Livewire\Reports\PrintReport;
use Livewire\Component;
use Livewire\Attributes\Layout;
class SalesReport extends Component
{
    public $from_date,$to_date,$orders;
    /* render the page */
    #[Layout('components.layouts.print-layout')]
    public function render()
    {
        return view('livewire.reports.print-report.sales-report');
    }
    /* process before render */
    public function mount($from_date = null,$to_date = null) {
        if(!\Illuminate\Support\Facades\Gate::allows('report_print')){
            abort(404);
        }
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->orders = \App\Models\Order::whereDate('order_date','>=',$this->from_date)->whereDate('order_date','<=',$this->to_date)->where('status',3)->latest()->get();
    }
}