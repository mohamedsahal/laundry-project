<?php

namespace App\Livewire;

use App\Models\Expense;
use App\Models\Order;
use App\Models\Translation;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Payment;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class HomePage extends Component
{
    #[Title('Dashboard')]
    public $pending_count,$processing_count,$ready_count,$delivered_count,$orders,$array,$search_query,$order_filter,$lang, $payment_array,$payment_expense_chart=[],$payment_chart_labels = [];
    public function render()
    {
        $this->pending_count = Order::where('status',0)->count();
        $this->processing_count = Order::where('status',1)->count();
        $this->ready_count = Order::where('status',2)->count();
        $this->delivered_count = Order::where('status',3)->count();
        return view('livewire.home-page');
    }

    /* process before mount */
    public function mount()
    {
        $this->pending_count = Order::where('status',0)->count();
        $this->processing_count = Order::where('status',1)->count();
        $this->ready_count = Order::where('status',2)->count();
        $this->delivered_count = Order::where('status',3)->count();
        $returned_count =  Order::where('status',4)->count();
        $this->orders = Order::whereDate('delivery_date',\Carbon\Carbon::today()->toDateString())->get();
        if(session()->has('selected_language'))
        {
            /* if the session has selected language */
            $this->lang = Translation::where('id',session()->get('selected_language'))->first();
        }
        else{
            /* if the session has no selected language */
            $this->lang = Translation::where('default',1)->first();
        }
        $this->array = json_encode(array($this->pending_count,$this->processing_count,$this->ready_count,$this->delivered_count,$returned_count));

        // Payment Status Chart Data
        $fullyPaid = 0;
        $partiallyPaid = 0;
        $notPaid = 0;

        $orders = Order::all();

        foreach ($orders as $order) {
            $paidAmount = Payment::where('order_id', $order->id)->sum('received_amount');

            if ($paidAmount == 0) {
                $notPaid++;
            } elseif ($paidAmount < $order->total) {
                $partiallyPaid++;
            } else {
                $fullyPaid++;
            }
        }
        $monthlyPayment = [];
        $monthlyExpense = [];
        $monthlyMaterial = [];

        $startDate = Carbon::today()->startOfMonth();
        $endDate = Carbon::today()->endOfMonth();
        $interval = CarbonPeriod::dates($startDate,$endDate);

        foreach($interval as $date)
        {
            $totalPayment = Payment::whereDate('created_at',$date)->sum('received_amount');
            $totalExpense = Expense::whereDate('expense_date',$date)->sum('expense_amount');
            $totalMaterial = \App\Models\StockUsage::whereDate('usage_date',$date)->sum('total_cost');
            
            $monthlyPayment[] = $totalPayment;
            $monthlyExpense[] = $totalExpense;
            $monthlyMaterial[] = round($totalMaterial, 2);
            $this->payment_chart_labels[] = $date->format('d/m');
        }
        $this->payment_expense_chart = (array($monthlyPayment,$monthlyExpense,$monthlyMaterial));
        $this->payment_array = json_encode([
            $notPaid,
            $partiallyPaid,
            $fullyPaid
        ]);
    }
    /* process while update the element */
    public function updated($name,$value)
    {
        /*if the updated element is search_query and value is not empty */
        if($name == 'search_query' && $value != '')
        {
            if($this->order_filter == '')
            {
                $this->orders = \App\Models\Order::whereDate('delivery_date',\Carbon\Carbon::today()->toDateString())
                                            ->where(function($q) use ($value) {
                                                $q->where('order_number','like','%'.$value.'%')
                                                    ->orwhere('customer_name','like','%'.$value.'%');
                                                })
                                            ->latest()
                                            ->get();
            }
            else{
                $this->orders = \App\Models\Order::where('status',$this->order_filter)
                                            ->whereDate('delivery_date',\Carbon\Carbon::today()->toDateString())
                                            ->where(function($q) use ($value) {
                                                $q->where('order_number','like','%'.$value.'%')
                                                ->orwhere('customer_name','like','%'.$value.'%');
                                            })
                                            ->latest()
                                            ->get();
            }
        }
        elseif($name == 'search_query' && $value == '')
        {
            /* if the updated element is search_query and value is empty */
            if($this->order_filter == '')
            {  /* if the order filter value is empty */
                $this->orders = \App\Models\Order::whereDate('delivery_date',\Carbon\Carbon::today()->toDateString())->latest()->get();
            }
            else{
                /* if the order filter value is not empty */
                $this->orders = \App\Models\Order::whereDate('delivery_date',\Carbon\Carbon::today()->toDateString())->where('status',$value)->latest()->get();

            }
        }
        /* if the updated value is order filter */
        if($name == 'order_filter')
        {
            $this->search_query = '';
            if($value == '')
            {    /* if the order filter value is empty */
                $this->orders = \App\Models\Order::whereDate('delivery_date',\Carbon\Carbon::today()->toDateString())->latest()->get();
            }
            else{
                /* if the order filter value is empty */
                $this->orders = \App\Models\Order::whereDate('delivery_date',\Carbon\Carbon::today()->toDateString())->where('status',$value)->latest()->get();
            }
        }
    }
}
