<?php

namespace App\Livewire\Inventory\Purchase;

use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\PurchasePayment;
use Livewire\Attributes\Title;
use Livewire\Component;

class PurchaseList extends Component
{
    #[Title('Purchase List')]
    public $purchases, $search = '';
    public $lang;

    public function mount(){
        if(!\Illuminate\Support\Facades\Gate::allows('purchase_list')){
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
        $query = Purchase::latest();
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('purchase_number', 'like', '%' . $this->search . '%');

                if (is_numeric($this->search)) {
                    $q->orWhere('total', $this->search);
                }

                $q->orWhereHas('supplier', function ($supplierQuery) {
                    $supplierQuery->where('name', 'like', '%' . $this->search . '%');
                });
            });
        }
        $this->purchases = $query->get();
        return view('livewire.inventory.purchase.purchase-list');
    }
    public function delete($id)
    {
        $purchase = Purchase::where('id', $id)->first();
        if (!$purchase) {
            return;
        }

        PurchaseDetail::where('purchase_id', $id)->delete();

        $purchase_payment = PurchasePayment::where('purchase_id', $id)->first();
        if ($purchase_payment) {
            $purchase_payment->delete();
        }

        $purchase->delete();

        $this->dispatch(
            'alert',
            ['type' => 'success',  'message' => 'Purchase  has been deleted!']
        );
    }
}
