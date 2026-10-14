<?php

namespace App\Livewire\Inventory\Purchase;

use App\Models\Payment;
use App\Models\Purchase;
use App\Models\PurchasePayment;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

class PurchasePayments extends Component
{
    #[Title('Purchase Payments')]
    public $purchase_payments, $search = '',$lang;
    public function render()
    {
        $query = PurchasePayment::latest();
        if (!empty($this->search)) {
            $query->where(function ($q) {

                $q->orWhereHas('supplier', function ($supplierQuery) {
                    $supplierQuery->where('name', 'like', '%' . $this->search . '%');
                });
            });
        }

        $this->purchase_payments = $query->get();
        return view('livewire.inventory.purchase.purchase-payments');
    }

    public function mount(){
        if(!\Illuminate\Support\Facades\Gate::allows('purchase_payment_list')){
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
}
