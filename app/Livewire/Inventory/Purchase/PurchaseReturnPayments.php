<?php

namespace App\Livewire\Inventory\Purchase;

use App\Models\PurchaseReturnPayment;
use Livewire\Attributes\Title;
use Livewire\Component;

class PurchaseReturnPayments extends Component
{
    #[Title('Purchase Return Payments')] 
    public $purchase_return_payments, $search='',$lang;

    public function mount(){
        if(!\Illuminate\Support\Facades\Gate::allows('purchase_return_payment_list')){
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
        $query = PurchaseReturnPayment::latest();
        if (!empty($this->search)) {
            $query->where(function ($q) {

                $q->orWhereHas('supplier', function ($supplierQuery) {
                    $supplierQuery->where('name', 'like', '%' . $this->search . '%');
                });
            });
        }

        $this->purchase_return_payments = $query->get();
        return view('livewire.inventory.purchase.purchase-return-payments');
    }
}
