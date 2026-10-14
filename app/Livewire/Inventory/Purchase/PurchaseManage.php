<?php

namespace App\Livewire\Inventory\Purchase;

use App\Livewire\Settings\MasterSetting;
use App\Models\MasterSettings;
use App\Models\Product;
use App\Models\Supplier;
use Livewire\Component;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\PurchasePayment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Livewire\Attributes\Title;

class PurchaseManage extends Component
{
    #[Title('Manage Purchase')]
    public $search_suppliers = '', $filteredSuppliers = [], $selected_supplier = null,$lang;
    public $search_products = '', $cart = [], $filteredProducts = [];
    public $cartData=[],$tax_rate = 0;
    public $paid_amount, $payment_method, $note, $payment_remarks, $purchase_number, $current_date, $invoice_number, $invoice_date, $original_invoice_number;
    public $purchase_payment, $purchase, $purchase_details;
    public $name, $address, $phone, $opening_balance, $tax_number, $email, $is_active = 1;
    public function render()
    {
        return view('livewire.inventory.purchase.purchase-manage');
    }

    public function mount($id = null)
    {
        if(!\Illuminate\Support\Facades\Gate::allows('purchase_create')){
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
            if(!\Illuminate\Support\Facades\Gate::allows('purchase_edit')){
                abort(404);
            }
            $this->purchase_payment = PurchasePayment::where('purchase_id', $id)->first();
            $this->paid_amount = $this->purchase_payment->paid_amount ?? 0;
            $this->payment_method = $this->purchase_payment->payment_method ?? 1;
            $this->note = $this->purchase_payment->note ?? '';
            $this->payment_remarks = $this->purchase_payment->payment_remarks ?? '';

            $this->purchase = Purchase::whereId($id)->first();
            $this->selected_supplier = Supplier::find($this->purchase->supplier_id);
            $this->invoice_number = $this->purchase->invoice_number;
            $this->invoice_date = $this->purchase->invoice_date;

            $this->purchase_details = PurchaseDetail::where('purchase_id', $id)->get();
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
            $this->purchase_number = $this->purchase->purchase_number;
            $this->current_date = Carbon::parse($this->purchase->purchase_date)->format("Y-m-d");
        } else {
            $this->purchase_number = $this->generatePurchaseNumber();
            $this->current_date = Carbon::now()->format("d-m-Y");
            $this->original_invoice_number = null;
        }
        $this->invoice_date = Carbon::today()->toDateString();
        $settings = new MasterSettings();
        $site = $settings->siteData();
        $this->tax_rate = (isset($site['default_tax_percentage']) && !empty($site['default_tax_percentage'])) ? $site['default_tax_percentage'] : '';
        $this->calculateTotal();
    }

    public function updatedSearchSuppliers($value)
    {
        if($value == ''){
            $this->filteredSuppliers = [];
            return;
        }
        else{
            $this->filteredSuppliers = Supplier::where('is_active', 1)->where('name', 'like', '%' . $this->search_suppliers . '%')
            ->limit(10)
            ->get();
        }
    }
    public function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->address = '';
        $this->phone = '';
        $this->opening_balance = 0;
        $this->tax_number = '';
        $this->is_active = true;
        $this->resetErrorBag();
    }
    public function updatedInvoiceNumber($value)
    {
        if (!empty($value)) {
            if ($this->purchase && $value === $this->original_invoice_number) {
                return;
            }

            $exists = Purchase::where('invoice_number', $value)
                ->when($this->purchase, function ($query) {
                    return $query->where('id', '!=', $this->purchase->id);
                })
                ->exists();

            if ($exists) {
                $this->dispatch('alert', [
                    'type' => 'error',
                    'message' => 'This invoice number already exists. Please use a different one.'
                ]);
            }
        }
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'phone' => 'required',
        ]);
        $supplier = new Supplier();
        $supplier->name = $this->name;
        $supplier->address = $this->address;
        $supplier->phone = $this->phone;
        $supplier->opening_balance = $this->opening_balance;
        $supplier->tax_number = $this->tax_number;
        $supplier->email = $this->email;
        $supplier->is_active = $this->is_active;
        $supplier->save();
        $this->selectSupplier($supplier->id);
        $this->resetInputFields();
        $this->dispatch('closemodal');
    }
    public function selectSupplier($supplierId)
    {
        $this->selected_supplier = Supplier::find($supplierId);
        $this->search_suppliers = '';
        $this->filteredSuppliers = [];
    }

    public function updatedSearchProducts()
    {
        if($this->search_products == ''){
            $this->filteredProducts = [];
            return;
        }
        else{
            $this->filteredProducts = Product::where('is_active', 1)->where('name', 'like', '%' . $this->search_products . '%')
            ->limit(10)
            ->get();
        }
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
        $this->paid_amount = $this->cartData['total'];
    }

    
    public function removeProduct($index)
    {
        unset($this->cart[$index]);
        $this->calculateTotal();
    }

    public function resetAll()
    {
        $this->reset([
            'cart',
            'selected_supplier',
            'search_suppliers',
            'search_products',
            'paid_amount',
            'payment_method',
            'note',
            'payment_remarks',
            'invoice_number',
            'invoice_date',
        ]);
    }

    public function generatePurchaseNumber(){
        $lastPurchase = Purchase::orderBy('purchase_number', 'desc')->first();
        $purchase_number = $lastPurchase ? ((float)$lastPurchase->purchase_number) + 1 : 1;
        return $purchase_number;
    }

    public function savePurchase()
    {
        if (!$this->selected_supplier && empty($this->newly_added_supplier_id)) {
            $this->dispatch('alert', ['type' => 'error', 'message' => 'Please select a valid supplier']);
            return;
        }
        $invoiceExists = Purchase::where('invoice_number', $this->invoice_number)
            ->when($this->purchase, function ($query) {
                return $query->where('id', '!=', $this->purchase->id);
            })
            ->exists();

        if ($invoiceExists) {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'This invoice number already exists. Please use a different one.'
            ]);
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

            if (($product['total'] ?? 0) < 0) {
                $this->dispatch('alert', ['type' => 'error', 'message' => 'Item total cannot be less than 0']);
                return;
            }
        }

        if (($this->paid_amount ?? 0) < 0) {
            $this->dispatch('alert', ['type' => 'error', 'message' => 'Paid amount cannot be negative']);
            return;
        }



        $this->validate([
            "paid_amount" => "required",
            "payment_method" => "required",
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
        if ($this->paid_amount > $this->cartData['total']) {
            $this->dispatch(
                'alert',
                ['type' => 'error',  'message' => 'Paid amount cannot be higher than total!']
            );
            return;
        }
        if ($this->purchase) {
            $purchase = $this->purchase;
        } else {
            $purchase = new Purchase();
        }
        if ($this->purchase) {
            $purchase->purchase_number = $this->generatePurchaseNumber();
        } else {
            $purchase->purchase_number = $this->purchase_number;
        }
        $totalQty = 0;
        foreach ($this->cart as $product) {
            $totalQty += $product['quantity'];
        }
        $purchase->purchase_date = Carbon::now();
        $purchase->supplier_name = $this->selected_supplier->name ?? $this->newly_added_supplier_name;
        $purchase->supplier_id = $this->selected_supplier->id ?? $this->newly_added_supplier_id;
        $purchase->discount = $this->tax_rate ?? 0;
        $purchase->discount_total = $this->cartData['discount'];
        $purchase->invoice_number = $this->invoice_number;
        $purchase->invoice_date = $this->invoice_date;
        $purchase->sub_total = $this->cartData['sub_total'];
        $purchase->tax_amount =  $this->cartData['tax_amount'];
        $purchase->taxable_amount =  $this->cartData['taxable_amount'];
        $purchase->total =  $this->cartData['total'];
        $purchase->total_quantity = $totalQty;
        $purchase->notes  = $this->note;
        $purchase->status = 1;
        $purchase->created_by = Auth::id();
        $purchase->financial_year_id = null;
        $purchase->save();

        if ($this->purchase) {
            PurchaseDetail::where('purchase_id', $this->purchase->id)->delete();
        }

        foreach ($this->cart as $product) {
            $item = new PurchaseDetail();
            $item->purchase_id = $purchase->id;
            $item->type = 1;
            $item->quantity = $product['quantity'] ?? 1;
            $item->product_id = $product['product']['id'];
            $item->product_name = $product['product']['name'];
            $item->rate = $product['rate'] ?? 0;
            $item->purchase_price = $product['rate'] ?? 0;
            $item->total = $product['total'] ?? 0;
            $item->discount = $product['discount'] ?? 0;
            $item->tax_percentage = $this->tax_rate;
            $item->tax_amount = $product['tax_amount'];
            $item->save();
        }
        if (!empty($this->paid_amount) && !empty($this->payment_method)) {

            if ($this->purchase_payment) {
                $payment = $this->purchase_payment;
            } else {
                $payment =  new PurchasePayment();
            }
            $payment->purchase_id = $purchase->id;
            $payment->supplier_id = $purchase->supplier_id;
            $payment->paid_amount = $this->paid_amount;
            $payment->payment_method = $this->payment_method;
            $payment->note = $this->note;
            $payment->payment_remarks = $this->payment_remarks;
            $payment->created_by = $purchase->created_by;
            $payment->save();
        }
        
        $this->dispatch(
            'alert',
            ['type' => 'success',  'message' => 'Purchase saved!']
        );
        $this->reset([
            'cart',
            'selected_supplier',
            'search_suppliers',
            'search_products',
            'paid_amount',
            'payment_method',
            'note',
            'payment_remarks'
        ]);
        return redirect()->route('inventory.purchase.list');
    }

}
