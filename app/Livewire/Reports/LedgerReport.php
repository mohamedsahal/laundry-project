<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Translation;
use Carbon\Carbon;

class LedgerReport extends Component
{
    public $selected_customer,$customers,$customer_query,$start_date,$end_date,$first_data,$lang,$data;
    #[Title('Ledger Report')]
    public function render()
    {
        return view('livewire.reports.ledger-report');
    }
    public function mount()
    {
        if(!\Illuminate\Support\Facades\Gate::allows('report_ledger')){
            abort(404);
        }
        if(session()->has('selected_language'))
        { /* if session has selected laugage*/
            $this->lang = Translation::where('id',session()->get('selected_language'))->first();
        }
        else{
            $this->lang = Translation::where('default',1)->first();
        }
        $this->start_date = \Carbon\Carbon::today()->toDateString();
        $this->end_date = \Carbon\Carbon::today()->toDateString();
        $this->data = collect();
    }

    public function updated($name,$value)
    {
        if($name == 'customer_query' && $value != '')
        {
            $this->customers = Customer::where(function($query) use ($value) { 
                $query->where('name', 'like', '%' . $value . '%')->orWhere('phone', 'like', '%' . $value . '%');
            })->latest()->limit(5)->get();
        }
        elseif($name == 'customer_query' && $value == ''){
            $this->customers = collect();
        }
    }

    /* select customer */
    public function selectCustomer($id)
    {
        $this->selected_customer = Customer::where('id',$id)->first();
        $this->customer_query = '';
        $this->customers = collect();
    }

    /* get Data */
    public function getData()
    {
        if(!$this->selected_customer)
        {
            $this->dispatch(
                'alert', ['type' => 'error','title' => 'Fetching failed',  'message' => 'You have not selected a customer!']);
            return;
        }
        $this->data = collect();
        if(!$this->selected_customer)
        {
            return abort(404);
        }
        $debits = collect(Order::where('customer_id',$this->selected_customer->id)->whereDate('order_date','>=',Carbon::parse($this->start_date)->toDateString())->whereDate('order_date','<=',Carbon::parse($this->end_date)->toDateString())->get());
        foreach($debits as $row)
        {
            $row['date'] = $row['order_date'];
            $row['type'] = 'debit';
        }  
        $credits = collect(Payment::where('customer_id',$this->selected_customer->id)->whereDate('payment_date','>=',Carbon::parse($this->start_date)->toDateString())->whereDate('payment_date','<=',Carbon::parse($this->end_date)->toDateString())->get());
        foreach($credits as $row)
        {
            $row['date'] = $row['created_at'];
            $row['type'] = 'credit';
        }   
        $this->data = $debits->concat($credits);
      
        $this->data = $this->data->toArray();
        usort($this->data,function ($a,$b) {
            return Carbon::parse($a['date'])->greaterThan(Carbon::parse($b['date'])) ;
        });
        $this->first_data = [
            'debits'    => Order::where('customer_id',$this->selected_customer->id)->whereDate('order_date','<',Carbon::parse($this->start_date)->toDateString())->sum('total'),
            'credits'    => Payment::where('customer_id',$this->selected_customer->id)->whereDate('payment_date','<',Carbon::parse($this->start_date)->toDateString())->sum('received_amount'),
        ];
    }
}
