<?php

namespace App\Livewire\Payments;

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Translation;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Pagination\Cursor;
use Auth;
use App\Models\Payment;

class PaymentsReceiptView extends Component
{
    public $payments, $search, $lang, $name;
    public $nextCursor;
    protected $currentCursor;
    public $hasMorePages;

    /* called before render */
    public function mount()
    {
        if(!\Illuminate\Support\Facades\Gate::allows('payment_list')){
            abort(404);
        }
        $this->payments = new EloquentCollection();

        $this->loadPayments();

        if (session()->has('selected_language')) { /* if session has selected laugage*/
            $this->lang = Translation::where('id', session()->get('selected_language'))->first();
        } else {
            $this->lang = Translation::where('default', 1)->first();
        }
    }

    #[Title('Payment Receipts')]
    public function render()
    {
        return view('livewire.payments.payments-receipt-view');
    }

    public function loadPayments()
    {
        if ($this->hasMorePages !== null  && !$this->hasMorePages) {
            return;
        }
        $paymentlist = $this->filterdata();
        $this->payments->push(...$paymentlist->items());
        if ($this->hasMorePages = $paymentlist->hasMorePages()) {
            $this->nextCursor = $paymentlist->nextCursor()->encode();
        }
        $this->currentCursor = $paymentlist->cursor();
    }

    /* refresh the page */
    public function refresh()
    {
        /* if search query or order filter is empty */
        if ($this->search == '') {
            $this->payments = $this->payments->fresh();
        }
    }

    /* process while update */
    public function updated($name, $value)
    {
        if ($name == 'search' && $value != '') {

            $customer = \App\Models\Customer::where(function ($query) use ($value) {
                $query->where('name', 'like', '%' . $value . '%')->orWhere('phone', 'like', '%' . $value . '%');
            })->pluck('id')->toArray();

            $this->payments = Payment::whereIn('customer_id', $customer)->latest()->get();
            $this->reloadPayments();
        } elseif ($name == 'search' && $value == '') {

            $this->payments = new EloquentCollection();
            $this->reloadPayments();
        }
    }
    /* filter data on search */
    public function filterdata()
    {
        if ($this->search || $this->search != '') {
             $search = $this->search;
            $customer = \App\Models\Customer::where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')->orWhere('phone', 'like', '%' . $search . '%');
            })->pluck('id')->toArray();


            $payments = \App\Models\Payment::whereIn('customer_id', $customer)
                ->latest()
                ->cursorPaginate(10, ['*'], 'cursor', Cursor::fromEncoded($this->nextCursor));
            return $payments;
        } else {

            $payments = \App\Models\Payment::latest()
                ->cursorPaginate(10, ['*'], 'cursor', Cursor::fromEncoded($this->nextCursor));
            return $payments;
        }
    }
    /* reload payment data */
    public function reloadPayments()
    {
        $this->payments = new EloquentCollection();
        $this->nextCursor = null;
        $this->hasMorePages = null;
        if ($this->hasMorePages !== null  && !$this->hasMorePages) {
            return;
        }
        $payments = $this->filterdata();
        $this->payments->push(...$payments->items());
        if ($this->hasMorePages = $payments->hasMorePages()) {
            $this->nextCursor = $payments->nextCursor()->encode();
        }
        $this->currentCursor = $payments->cursor();
    }
}
