<?php

namespace App\Livewire\Inventory\Purchase;

use App\Models\MasterSettings;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnDetail;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

class PurchaseReturnManage extends Component
{
    #[Title('Manage Purchase Return')]
    public $search_suppliers = '', $filteredSuppliers = [], $selected_supplier = null;
    public $search_products = '', $cart = [],$cartData = [], $filteredProducts = [];
    public $amount, $payment_method, $note, $return_reason, $next_number, $current_date, $invoice_number, $invoice_date, $payment_status = 1;
    public $purchase_payment, $purchase, $purchase_details;
    public $name, $address, $phone, $opening_balance, $tax_number, $email, $is_active = 1, $supplierSelected = false;
    public $purchase_number, $purchase_return,$tax_rate,$lang;
    public function render()
    {
        return view('livewire.inventory.purchase.purchase-return-manage');
    }

    public function mount($id = null)
    {
        if(!\Illuminate\Support\Facades\Gate::allows('purchase_return_create')){
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
        if ($id) {
            if(!\Illuminate\Support\Facades\Gate::allows('purchase_return_edit')){
                abort(404);
            }
            $this->purchase_return = PurchaseReturn::whereId($id)->first();
            $this->search_suppliers = $this->purchase_return->supplier_name;
            $this->selected_supplier = Supplier::find($this->purchase_return->supplier_id);
            $this->purchase_number = $this->purchase_return->purchase_number;
            $this->invoice_number = $this->purchase_return->invoice_number;
            $this->invoice_date = $this->purchase_return->invoice_date;
            $this->return_reason = $this->purchase_return->reason;
            $this->note = $this->purchase_return->notes;
            $this->purchase_details = PurchaseReturnDetail::where('purchase_return_id', $id)->get();
            $this->cart = [];
            foreach ($this->purchase_details as $item) {
                $product = Product::find($item->product_id);
                $this->cart[] = [
                    'product' => $product,
                    'quantity' => $item->quantity,
                    'rate' => $item->rate,
                    'unit_price' => $item->rate,
                    'discount' => $item->discount ?? 0,
                    'tax_amount' => $item->tax_amount ?? 0,
                    'tax' => 0,
                    'total' => $item->total,
                ];
            }
            $this->next_number = $this->purchase_return->purchase_return_number;
            $this->current_date = Carbon::parse($this->purchase_return->purchase_date)->format("Y-m-d");
        } else {
            $this->next_number = $this->generatePurchaseReturnNumber();
            $this->current_date = Carbon::now()->format("Y-m-d");
            $this->invoice_date = Carbon::now()->format("Y-m-d");
        }
        $settings = new MasterSettings();
        $site = $settings->siteData();
        $this->tax_rate = (isset($site['default_tax_percentage']) && !empty($site['default_tax_percentage'])) ? (float)$site['default_tax_percentage'] : 0;
        $this->calculateTotal();

    }
    public function updatedSearchSuppliers()
    {
        $this->supplierSelected = false;
        $this->filteredSuppliers = Supplier::where('is_active', 1)->where('name', 'like', '%' . $this->search_suppliers . '%')
            ->limit(10)
            ->get();
    }
    public function selectSupplier($supplierId)
    {
        $this->supplierSelected = true;
        $this->selected_supplier = Supplier::find($supplierId);
        $this->search_suppliers = '';
        $this->filteredSuppliers = [];
    }
    public function updatedSearchProducts()
    {
        $this->filteredProducts = Product::where('is_active', 1)->where('name', 'like', '%' . $this->search_products . '%')
            ->limit(10)
            ->get();
    }
    

    public function calculateTotal(){
        $this->cartData = [];
        $this->cartData['sub_total'] = 0;
        $this->cartData['discount'] = 0;
        $this->cartData['tax_amount'] = 0;
        $this->cartData['taxable_amount'] = 0;
        $this->cartData['total'] = 0;
        $tax_type = getTaxType();
        foreach($this->cart as $index => $item){
            if ($tax_type == 2) {
                $grossPrice = ((float)$item['rate'] * (float)$item['quantity']) ;
                $unitPrice = $grossPrice  * (100 / (100 + $this->tax_rate ?? 0));
                $itemTax = $grossPrice - $unitPrice;
                $itemTotal = $grossPrice - (float)$item['discount'];


                $this->cartData['sub_total'] += $grossPrice;
                $this->cartData['tax_amount'] += $itemTax;
                $this->cartData['total'] += $itemTotal;
                $this->cartData['discount'] += (float)$item['discount'] ;
                
                $this->cart[$index]['total'] = $itemTotal;
                $this->cart[$index]['tax_amount'] = $itemTax;
                $this->cart[$index]['taxable_amount'] = $unitPrice ;
            }
            else{
                $unitPrice = $item['rate'];
                $itemLocalTotal = $unitPrice * $item['quantity'];
                $this->cartData['sub_total'] += $itemLocalTotal;
                $itemTax = $itemLocalTotal * ($this->tax_rate / 100);
                $itemTotal = $itemLocalTotal + $itemTax - (float)$item['discount'];

                $this->cartData['tax_amount'] += $itemTax;
                $this->cartData['total'] += $itemTotal;
                $this->cartData['discount'] += (float)$item['discount'] ;

                //
                $this->cart[$index]['total'] = $itemTotal;
                $this->cart[$index]['tax_amount'] = $itemTax;
                $this->cart[$index]['taxable_amount'] = $itemLocalTotal;
            }
        }
        $this->amount = $this->cartData['total'];
    }

    
    public function removeProduct($index)
    {
        unset($this->cart[$index]);
        $this->calculateTotal();
    }

    public function selectProduct($productId)
    {
        $product = Product::find($productId);
        $this->search_products = '';
        $this->filteredProducts = [];
        $purchasePrice = $product->purchase_price;
        $productIndex = null;
        foreach($this->cart as $index => $item){
            if($item['product']['id'] == $productId){
                $productIndex = $index;
            }
        }
        if($productIndex !== null){
            $this->cart[$productIndex]['quantity'] = $this->cart[$productIndex]['quantity'] + 1;
            $this->calculateTotal();
            return;
        }
        $item = [
            'product' => $product,
            'quantity' => 1,
            'rate' => $purchasePrice,
            'unit_price' => $purchasePrice,
            'discount' => 0,
            'tax' => 0,
            'tax_amount' => 0,
            'total' => $purchasePrice,
        ];
        $this->cart[] = $item;
        $this->calculateTotal();
    }


    public function generatePurchaseReturnNumber(){
        $lastPurchase = PurchaseReturn::orderBy('purchase_return_number', 'desc')->first();
        $purchase_number = $lastPurchase ? ((float)$lastPurchase->purchase_return_number) + 1 : 1;
        return $purchase_number;
    }


    public function resetAll()
    {
        $this->reset([
            'cart',
            'selected_supplier',
            'search_suppliers',
            'search_products',
            'amount',
            'payment_method',
            'note',

        ]);
    }

    public function savePurchaseReturn()
    {

        if (!$this->selected_supplier ) {
            $this->dispatch('alert', ['type' => 'error', 'message' => 'Please select a valid supplier']);
            return;
        }
        foreach ($this->cart as $index => $product) {
            if (($product['quantity'] ?? 0) <= 0) {
                $this->dispatch('alert', ['type' => 'error', 'message' => 'Product quantities must be greater than zero']);
                return;
            }

            if (($product['rate'] ?? 0) < 0) {
                $this->dispatch('alert', ['type' => 'error', 'message' => 'Product rates cannot be negative']);
                return;
            }

            if (($product['discount'] ?? 0) < 0) {
                $this->dispatch('alert', ['type' => 'error', 'message' => 'Discounts cannot be negative']);
                return;
            }
            $productModel = Product::find($product['id'] ?? null);

            if ($productModel) {
                $availableStock = $productModel->calculateStock();

                if (($product['quantity'] ?? 0) > $availableStock) {
                    $this->dispatch('alert', [
                        'type' => 'error',
                        'message' => "Return quantity for '{$productModel->name}' exceeds available stock ({$availableStock})"
                    ]);
                    return;
                }
            }
        }

        if (($this->amount ?? 0) < 0) {
            $this->dispatch('alert', ['type' => 'error', 'message' => 'Amount cannot be negative']);
            return;
        }
      
       

        $this->validate([
            "purchase_number" => "required",
            "invoice_number" => "required",
            "invoice_date" => "required",
        ]);



        if (empty($this->cart)) {
            $this->dispatch(
                'alert',
                ['type' => 'error',  'message' => 'You must add at least one product to the purchase.']
            );
            return;
        }

        if ($this->amount > $this->cartData['total']) {
            $this->dispatch('alert', ['type' => 'error', 'message' => 'Paid amount cannot be higher than total!']);
            return;
        }
        if ($this->purchase_return) {
            $purchase = $this->purchase_return;
        } else {
            $purchase = $this->purchase ?? new PurchaseReturn();
        }
        if ($this->purchase_return) {
            $purchase->purchase_return_number = $this->purchase_return->purchase_return_number;
        } else {
            $purchase->purchase_return_number = $this->generatePurchaseReturnNumber();
        }
        $totalQty = 0;
        foreach ($this->cart as $product) {
            $totalQty += $product['quantity'];
        }
        $purchase->supplier_name = $this->selected_supplier->name;
        $purchase->supplier_id = $this->selected_supplier->id;
        $purchase->purchase_number = $this->purchase_number;
        $purchase->invoice_number = $this->invoice_number;
        $purchase->invoice_date = $this->invoice_date ?? Carbon::now()->format('Y-m-d');
        $purchase->discount = $this->tax_rate ?? 0;
        $purchase->discount_total = $this->cartData['discount'];
        $purchase->invoice_date = $this->invoice_date;
        $purchase->sub_total = $this->cartData['sub_total'];
        $purchase->tax_amount =  $this->cartData['tax_amount'];
        $purchase->taxable_amount =  $this->cartData['taxable_amount'];
        $purchase->total =  $this->cartData['total'];
        $purchase->total_quantity = $totalQty;
        $purchase->notes = $this->note;
        $purchase->reason = $this->return_reason;
        $purchase->created_by = Auth::id();
        $purchase->financial_year_id = null;

        $purchase->save();

        if ($this->purchase_details) {
            PurchaseReturnDetail::where('purchase_return_id', $purchase->id)->delete();
        }
        foreach ($this->cart as $product) {
            $item = new PurchaseReturnDetail();

            $item->purchase_return_id = $purchase->id;
            $item->quantity = $product['quantity'] ?? 1;
            $item->product_id = $product['product']['id'];
            $item->product_name = $product['product']['name'];
            $item->rate = $product['rate'] ?? 0;
            $item->total = $product['total'] ?? 0;
            $item->discount = $product['discount'] ?? 0;
            $item->tax_percentage = $this->tax_rate;
            $item->type = 1;
            $item->tax_amount = $product['tax_amount'];
            $item->save();
        }
        $this->dispatch('alert', ['type' => 'success', 'message' => 'Purchase saved!']);

        $this->reset([
            'cart',
            'selected_supplier',
            'search_suppliers',
            'search_products',
            'amount',
            'payment_method',
            'note',
            'invoice_number',
            'invoice_date',
            'return_reason',
            'purchase_number'
        ]);
        return redirect()->route('inventory.purchase-return.list');
    }
}
