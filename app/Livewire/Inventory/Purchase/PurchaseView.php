<?php

namespace App\Livewire\Inventory\Purchase;

use App\Models\MasterSettings;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Livewire\Attributes\Title;
use Livewire\Component;

class PurchaseView extends Component
{
    #[Title('View Purchase')]
    public $sitename,$store_email,$phone,$address,$zipcode,$tax_number,$purchase_details,$sub_total,$discount_total,$tax_amount,$taxable_amount,$total,$purchase,$invoice_number,$invoice_date;
    public $purchase_number,$purchase_date,$lang;
    public function render()
    {
        return view('livewire.inventory.purchase.purchase-view');
    }
    public function mount($id)
    {
        if(!\Illuminate\Support\Facades\Gate::allows('purchase_view')){
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
        $this->purchase = Purchase::with('details')->whereId($id)->first();
        $this->purchase_number = $this->purchase->purchase_number;
        $this->purchase_date = $this->purchase->created_at;
        $this->sub_total = $this->purchase->sub_total;
        $this->discount_total = $this->purchase->discount_total;
        $this->tax_amount = $this->purchase->tax_amount;
        $this->taxable_amount = $this->purchase->taxable_amount;
        $this->total = $this->purchase->total;
        $this->invoice_number = $this->purchase->invoice_number;
        $this->invoice_date = $this->purchase->invoice_date;
        $this->purchase_details = $this->purchase->details;
    }
}
