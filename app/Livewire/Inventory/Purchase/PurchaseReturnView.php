<?php

namespace App\Livewire\Inventory\Purchase;

use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnPayment;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

class PurchaseReturnView extends Component
{
    #[Title('View Purchase Return')]
    public $sitename, $store_mail, $phone, $address, $zipcode, $taxnumber, $purchase_return_details, $sub_total, $discount_total, $tax_amount, $taxable_amount, $total, $purchase_return, $invoice_number, $invoice_date;
    public $purchase_return_number, $purchase_date, $paid_amount, $payment_method, $note;
    public $last_paid_amount, $supplier_name, $purchase_number, $total_amount, $created_at, $balance, $purchase_return_payments,$lang;
    public function render()
    {
        return view('livewire.inventory.purchase.purchase-return-view');
    }
    public function mount($id)
    {
        if(!\Illuminate\Support\Facades\Gate::allows('purchase_return_view')){
            abort(404);
        }
        if(session()->has('selected_language'))
        {   /* if session has selected language */
            $this->lang = \App\Models\Translation::where('id',session()->get('selected_language'))->first();
        }
        else{
            /* if session has no selected language */
            $this->lang = \App\Models\Translation::where('default',1)->first();
        }
        $this->purchase_return = PurchaseReturn::with('details')->whereId($id)->first();
        $this->purchase_return_number = $this->purchase_return->purchase_number;
        $this->purchase_date = $this->purchase_return->purchase_date;
        $this->sub_total = $this->purchase_return->sub_total;
        $this->discount_total = $this->purchase_return->discount_total;
        $this->tax_amount = $this->purchase_return->tax_amount;
        $this->taxable_amount = $this->purchase_return->taxable_amount;
        $this->total = $this->purchase_return->total;
        $this->invoice_number = $this->purchase_return->invoice_number;
        $this->invoice_date = $this->purchase_return->invoice_date;
        $this->purchase_return_details = $this->purchase_return->details;

        $this->purchase_return = PurchaseReturn::where('id', $id)->first();
        $this->last_paid_amount = $this->purchase_return->purchase_payments->sum('paid_amount');
        $this->total_amount = $this->purchase_return->total;
        $this->balance = $this->total_amount - $this->last_paid_amount;
        $this->paid_amount = $this->balance;

        $this->purchase_return_payments = PurchaseReturnPayment::where('purchase_return_id', $id)->get();
    }
    public function resetInputFields()
    {
        $this->paid_amount = '';
        $this->payment_method = '';
        $this->note = '';
    }
    public function addPayment()
    {
        $this->validate([
            'paid_amount' => 'required',
            'payment_method' => 'required',
        ]);

        if ($this->paid_amount > $this->purchase_return->total) {
            $this->addError('paid_amount', 'Paid amount cannot be greater than total amount.');
            return;
        }

        $payment = new PurchaseReturnPayment();
        $payment->purchase_return_id = $this->purchase_return->id;
        $payment->supplier_id = $this->purchase_return->supplier_id;
        $payment->total = $this->purchase_return->total;
        $payment->paid_amount = $this->paid_amount;
        $payment->payment_method = $this->payment_method;
        $payment->created_by = Auth::id();
        $payment->note = $this->note;
        $payment->save();
        $this->resetInputFields();
        $this->dispatch('closemodal');
        $this->dispatch('reloadpage');
        $this->dispatch(
            'alert',
            ['type' => 'success',  'message' => 'Payment has been created!']
        );
    }
}
