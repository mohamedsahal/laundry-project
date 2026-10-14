<?php

namespace App\Livewire\Inventory\Purchase;

use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnDetail;
use App\Models\PurchaseReturnPayment;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

class PurchaseReturnList extends Component
{
    #[Title('Purchase Return')]
    public $purchase_returns, $paid_amount, $payment_method, $note, $supplier_name, $purchase_number, $purchase_date, $total_amount, $purchase_return, $last_paid_amount = 0, $created_at,$balance, $search = '';
    public $lang;
    
    public function mount(){
        if(!\Illuminate\Support\Facades\Gate::allows('purchase_return_list')){
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
    }
    
    public function render()
    {
        $query = PurchaseReturn::latest();
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('purchase_number', 'like', '%' . $this->search . '%');

                if (is_numeric($this->search)) {
                    $q->orWhere('total', $this->search);
                }

                $q->orWhere('email', 'like', '%' . $this->search . '%');
                $q->orWhere('invoice_number', 'like', '%' . $this->search . '%');
            });
        }
        $this->purchase_returns = $query->get();
        return view('livewire.inventory.purchase.purchase-return-list');
    }
    public function delete($id)
    {
        $purchase_return = PurchaseReturn::where('id', $id)->first();
        if (!$purchase_return) {
            return;
        }
        PurchaseReturnDetail::where('purchase_id', $id)->delete();

        PurchaseReturnPayment::where('purchase_return_id', $id)->delete();
        
        $purchase_return->delete();
        $this->dispatch(
            'alert',
            ['type' => 'success', 'message' => 'Purchase return has been deleted']
        );
    }

    public function resetInputFields()
    {
        $this->paid_amount = '';
        $this->payment_method = '';
        $this->note = '';
    }

    public function payment($id)
    {
        $this->purchase_return = PurchaseReturn::where('id', $id)->first();
        $this->last_paid_amount = $this->purchase_return->purchase_payments->sum('paid_amount');

        $this->supplier_name = $this->purchase_return->supplier->name;
        $this->purchase_number = $this->purchase_return->purchase_number;
        $this->purchase_date = $this->purchase_return->purchase_date;
        $this->total_amount = $this->purchase_return->total;
        $this->created_at = $this->purchase_return->created_at->format('Y-m-d');
        $this->balance = $this->total_amount - $this->last_paid_amount;
        $this->paid_amount = $this->balance;
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
        $this->dispatch(
            'alert',
            ['type' => 'success',  'message' => 'Payment has been created!']
        );
    }
}
