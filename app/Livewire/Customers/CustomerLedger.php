<?php

namespace App\Livewire\Customers;

use Livewire\Component;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Translation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;

class CustomerLedger extends Component
{
    public $data,$customer,$lang;

    #[Title('Customer Ledger')]
    public function render()
    {
        return view('livewire.customers.customer-ledger');
    }

    public function mount($id)
    {
        if(!\Illuminate\Support\Facades\Gate::allows('customer_view')){
            abort(404);
        }
        if(session()->has('selected_language'))
        { /* if session has selected laugage*/
            $this->lang = Translation::where('id',session()->get('selected_language'))->first();
        }
        else{
            $this->lang = Translation::where('default',1)->first();
        }
        $this->data = collect();
        $this->customer = Customer::find($id);
        if(!$this->customer)
        {
            return abort(404);
        }
        $debits = collect(Order::where('customer_id',$this->customer->id)->get());
        foreach($debits as $row)
        {
            $row['date'] = $row['order_date'];
            $row['type'] = 'debit';
        }  
        $credits = collect(Payment::where('customer_id',$this->customer->id)->get());
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
    }
}
