<?php

namespace App\Livewire\Customers;

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Customer;
use App\Models\Translation;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Pagination\Cursor;
use Auth;
use App\Exports\CustomersExport;
use App\Models\Payment;
use App\Models\Order;
use Excel;

class CustomersList extends Component
{
    #[Title('Customers')]
    public $customers, $name, $email, $tax_number, $is_active = 1, $phone, $address, $search, $lang, $customer;
    public $editMode = false;
    public $nextCursor;
    protected $currentCursor;
    public $hasMorePages;

    /* called before render */
    public function mount()
    {
        if(!\Illuminate\Support\Facades\Gate::allows('customer_list')){
            abort(404);
        }
        $this->customers = new EloquentCollection();
        $this->loadCustomers();

        if (session()->has('selected_language')) { /* if session has selected laugage*/
            $this->lang = Translation::where('id', session()->get('selected_language'))->first();
        } else {
            $this->lang = Translation::where('default', 1)->first();
        }
    }
    /* render the page */
    public function render()
    {
        return view('livewire.customers.customers-list');
    }
    /* reset input file */
    public function resetInputFields()
    {
        $this->customer = '';
        $this->phone = '';
        $this->email = '';
        $this->tax_number = '';
        $this->address = '';
        $this->name = '';
        $this->is_active = 1;
        $this->resetErrorBag();
    }
    /* store customer data */
    public function store()
    {
        /* if edit mode is false */

        /* rule settings */
        $this->validate([
            'name' => 'required',
            'phone' => 'required',
        ]);

        $customer = new Customer();
        $customer->name = $this->name;
        $customer->phone = $this->phone;
        $customer->email = $this->email ?: null;
        $customer->tax_number = $this->tax_number ?: null;
        $customer->address = ($this->address);
        $customer->created_by = Auth::user()->id;
        $customer->is_active = ($this->is_active) ? "1" : "0";
        $customer->save();
        $this->customers = Customer::latest()->get();
        $this->resetInputFields();
        $this->dispatch('closemodal');
        $this->dispatch(
            'alert',
            ['type' => 'success',  'message' => 'Customer  has been created!']
        );
    }
    /* process while update */
    public function updated($name, $value)
    {
        if ($name == 'search' && $value != '') {
            $this->customers = Customer::where('name', 'like', '%' . $value)->latest()->get();
            $this->reloadCustomers();
        } elseif ($name == 'search' && $value == '') {

            $this->customers = new EloquentCollection();
            $this->reloadCustomers();
        }
        /*if the updated element is address */
        if ($name == 'address' && $value != '') {
            $this->address = $value;
        }
    }
    /* view customer details to update */
    public function edit($id)
    {
        $this->resetErrorBag();
        $this->editMode = true;
        $this->customer = Customer::where('id', $id)->first();
        $this->phone = $this->customer->phone;
        $this->email = $this->customer->email;
        $this->tax_number = $this->customer->tax_number;
        $this->address = $this->customer->address;
        $this->name = $this->customer->name;
        $this->is_active = $this->customer->is_active;
    }
    /* update customer details */
    public function update()
    {

        /* rule validation */
        $this->validate([
            'name' => 'required',
            'phone' => 'required',
        ]);

        $this->customer->name = $this->name;
        $this->customer->phone = $this->phone;
        $this->customer->email = $this->email ?: null;
        $this->customer->tax_number = $this->tax_number ?: null;
        $this->customer->address = $this->address;
        $this->customer->is_active = ($this->is_active) ? "1" : "0";
        $this->customer->save();
        $this->refresh();
        $this->resetInputFields();
        $this->editMode = false;
        $this->dispatch('closemodal');
        $this->dispatch(
            'alert',
            ['type' => 'success',  'message' => 'Customer has been updated!']
        );
    }
    /* refresh the page */
    public function refresh()
    {
        /* if search query or order filter is empty */
        if ($this->search == '') {
            $this->customers = $this->customers->fresh();
        }
    }
    public function loadCustomers()
    {
        if ($this->hasMorePages !== null  && !$this->hasMorePages) {
            return;
        }
        $customerlist = $this->filterdata();
        $this->customers->push(...$customerlist->items());
        if ($this->hasMorePages = $customerlist->hasMorePages()) {
            $this->nextCursor = $customerlist->nextCursor()->encode();
        }
        $this->currentCursor = $customerlist->cursor();
    }
    public function filterdata()
    {
        if ($this->search || $this->search != '') {
            $customers = \App\Models\Customer::where('name', 'like', '%' . $this->search . '%')
                ->latest()
                ->cursorPaginate(10, ['*'], 'cursor', Cursor::fromEncoded($this->nextCursor));
            return $customers;
        } else {

            $customers = \App\Models\Customer::latest()
                ->cursorPaginate(10, ['*'], 'cursor', Cursor::fromEncoded($this->nextCursor));
            return $customers;
        }
    }
    public function reloadCustomers()
    {
        $this->customers = new EloquentCollection();
        $this->nextCursor = null;
        $this->hasMorePages = null;
        if ($this->hasMorePages !== null  && !$this->hasMorePages) {
            return;
        }
        $customers = $this->filterdata();
        $this->customers->push(...$customers->items());
        if ($this->hasMorePages = $customers->hasMorePages()) {
            $this->nextCursor = $customers->nextCursor()->encode();
        }
        $this->currentCursor = $customers->cursor();
    }
    /* export to excel */
    public function downloadFile()
    {
        return Excel::download(new CustomersExport, 'customers_list.xlsx');
    }
    /* delete the service */
    public function delete($id)
    {
        $order = Order::where('customer_id', $id)->first();
        $payment = Payment::where('customer_id', $id)->first();
        if ($order || $payment) {
            $this->dispatch(
                'alert',
                ['type' => 'error',  'message' => 'Cannot Delete Customer!']
            );
        } else {
        try {
            Customer::where('id', $id)->delete();
            $this->reloadCustomers();
            $this->dispatch(
                'alert',
                ['type' => 'success',  'message' => 'Customer has been deleted!']
            );
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent(
                'alert',
                ['type' => 'error',  'message' => 'Cannot Delete Customer!']
            );
        }
    }
    }
}
