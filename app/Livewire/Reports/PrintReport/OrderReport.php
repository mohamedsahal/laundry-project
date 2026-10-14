<?php
namespace App\Livewire\Reports\PrintReport;
use Livewire\Component;
use Livewire\Attributes\Layout;
class OrderReport extends Component
{
    public $from_date,$to_date,$orders,$status=-1;
    /* render the content */
    #[Layout('components.layouts.print-layout')]
    public function render()
    {
        return view('livewire.reports.print-report.order-report');
    }
    /* process before render */
    public function mount($from_date = null,$to_date = null, $status = null) {
        if(!\Illuminate\Support\Facades\Gate::allows('report_print')){
            abort(404);
        }
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->status = $status;
        if($this->status == -1) {
            $this->orders = \App\Models\Order::whereDate('order_date','>=',$this->from_date)->whereDate('order_date','<=',$this->to_date)->latest()->get();
       } else {
            $this->orders = \App\Models\Order::whereDate('order_date','>=',$this->from_date)->whereDate('order_date','<=',$this->to_date)->where('status',$this->status)->latest()->get();
       }
    }
}