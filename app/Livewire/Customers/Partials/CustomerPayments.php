<?php

namespace App\Livewire\Customers\Partials;

use App\Models\Customer;
use App\Models\Payment;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Pagination\Cursor;
use App\Models\Translation;

class CustomerPayments extends Component
{
    public $nextCursor;
    protected $currentCursor;
    public $hasMorePages;   
    public $payments;
    public $customer, $lang;

    public function render()
    {
        return view('livewire.customers.partials.customer-payments');
    }

    public function mount(Customer $customer){
        $this->customer = $customer;
        $this->payments = new EloquentCollection();
        $this->loadPayments();
        if (session()->has('selected_language')) { /* if session has selected laugage*/
            $this->lang = Translation::where('id', session()->get('selected_language'))->first();
        } else {
            $this->lang = Translation::where('default', 1)->first();
        }
    }

    public function loadPayments()
    {
        if ($this->hasMorePages !== null  && !$this->hasMorePages) {
            return;
        }
        $myorder = $this->filterdata();
        $this->payments->push(...$myorder->items());
        if ($this->hasMorePages = $myorder->hasMorePages()) {
            $this->nextCursor = $myorder->nextCursor()->encode();
        }
        $this->currentCursor = $myorder->cursor();
    }

    public function filterdata(){
        $orders = Payment::where('customer_id',$this->customer->id)->latest()->cursorPaginate(10, ['*'], 'cursor', Cursor::fromEncoded($this->nextCursor));
        return $orders;
    }

    public function reloadOrders()
    {
        $this->payments = new EloquentCollection();
        $this->nextCursor = null;
        $this->hasMorePages = null;
        if ($this->hasMorePages !== null  && !$this->hasMorePages) {
            return;
        }
        $orders = $this->filterdata();
        $this->payments->push(...$orders->items());
        if ($this->hasMorePages = $orders->hasMorePages()) {
            $this->nextCursor = $orders->nextCursor()->encode();
        }
        $this->currentCursor = $orders->cursor();
    }
}