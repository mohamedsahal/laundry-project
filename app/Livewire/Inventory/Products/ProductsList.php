<?php

namespace App\Livewire\Inventory\Products;

use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Unit;
use Livewire\Attributes\Title;
use Livewire\Component;

class ProductsList extends Component
{
    #[Title('Products')]
    public $name, $unit_id, $category_id, $sku, $purchase_price, $opening_stock, $minimum_stock_level, $description, $is_consumable = 1, $is_active = 1;
    public $products, $product, $search = '', $hasMorePages, $nextCursor, $currentCursor, $units, $categories,$lang;
    /* called before render */
    public function mount()
    {
        if(!\Illuminate\Support\Facades\Gate::allows('inventory_list')){
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
        $this->units = Unit::where('is_active', 1)->latest()->get();
        $this->categories = Category::where('is_active', 1)->latest()->get();
    }
    /* render the page */
    public function render()
    {
        $query = Product::latest();
        if ($this->search != '') {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        $this->products = $query->get();

        foreach ($this->products as $product) {
            $product->current_stock = $product->calculateStock();
        }
        return view('livewire.inventory.products.products-list');
    }
    /* reset input fields */
    public function resetInputFields()
    {
        $this->name = '';
        $this->category_id = '';
        $this->unit_id = '';
        $this->sku = '';
        $this->purchase_price = '';
        $this->opening_stock = '';
        $this->minimum_stock_level = '';
        $this->description = '';
        $this->is_active = true;
        $this->is_consumable = true;
        $this->resetErrorBag();
    }
    /* save product data */
    public function save()
    {
        $this->validate([
            'name' => 'required',
            'unit_id' => 'required',
            'category_id' => 'required',
            'sku' => 'required',
            'purchase_price' => 'required',
            'minimum_stock_level' => 'nullable|numeric|min:0',
            'opening_stock' => 'nullable|numeric|min:0',
            'sku' => 'required|unique:products,sku',
        ]);
        $product = new Product();
        $product->name = $this->name;
        $product->unit_id = $this->unit_id;
        $product->category_id = $this->category_id;
        $product->sku = $this->sku;
        $product->purchase_price = $this->purchase_price;
        $product->opening_stock = $this->opening_stock !== '' ? $this->opening_stock : 0;
        $product->minimum_stock_level = $this->minimum_stock_level !== '' ? $this->minimum_stock_level : 0;
        $product->description = $this->description;
        $product->is_consumable = $this->is_consumable ? 1 : 0;
        $product->is_active = $this->is_active ? 1 : 0;
        $product->save();
        $this->resetInputFields();
        $this->dispatch('closemodal');
        $this->dispatch(
            'alert',
            ['type' => 'success',  'message' => 'Product  has been created!']
        );
    }
    /* view product details to update */
    public function edit($id)
    {
        $this->resetErrorBag();
        $product = Product::where('id', $id)->first();
        $this->name = $product->name;
        $this->unit_id = $product->unit_id;
        $this->category_id = $product->category_id;
        $this->sku = $product->sku;
        $this->purchase_price = $product->purchase_price;
        $this->opening_stock = $product->opening_stock;
        $this->minimum_stock_level = $product->minimum_stock_level;
        $this->description = $product->description;
        $this->is_consumable = $product->is_consumable == 1 ? true : false;
        $this->is_active = $product->is_active == 1 ? true : false;
        $this->product = $product;
    }
    /* update customer details */
    public function update()
    {
        /* rule validation */
        $this->validate([
            'name' => 'required',
            'unit_id' => 'required',
            'category_id' => 'required',
            'sku' => 'required|unique:products,sku,' . $this->product->id,
            'purchase_price' => 'required',
            'minimum_stock_level' => 'nullable|numeric|min:0',
            'opening_stock' => 'nullable|numeric|min:0',
        ]);
        $product = Product::where('id', $this->product->id)->first();
        $product->name = $this->name;
        $product->unit_id = $this->unit_id;
        $product->category_id = $this->category_id;
        $product->sku = $this->sku;
        $product->purchase_price = $this->purchase_price;
        $product->opening_stock = $this->opening_stock !== '' ? $this->opening_stock : 0;;
        $product->minimum_stock_level = $this->minimum_stock_level !== '' ? $this->minimum_stock_level : 0;;
        $product->description = $this->description;
        $product->is_consumable = $this->is_consumable;
        $product->is_active = $this->is_active;
        $product->save();
        $this->dispatch('closemodal');
        $this->dispatch(
            'alert',
            ['type' => 'success',  'message' => 'Product has been updated!']
        );
    }
    public function delete($id)
    {
        $product = Product::where('id', $id)->first();
        if (!$product) {
            return;
        }

        $has_purchases = PurchaseDetail::where('product_id', $id)->exists() || \App\Models\StockUsage::where('product_id', $id)->exists();
        if ($has_purchases) {
            $this->dispatch(
                'alert',
                ['type' => 'error',  'message' => 'Cannot be deleted because it is already in use!']
            );
            return;
        }
        $product->delete();
        $this->dispatch(
            'alert',
            ['type' => 'success',  'message' => 'Product  has been deleted!']
        );
    }
    public function loadProducts()
    {
        if ($this->hasMorePages !== null  && !$this->hasMorePages) {
            return;
        }
        $productlist = $this->filterdata();
        $this->customers->push(...$productlist->items());
        if ($this->hasMorePages = $productlist->hasMorePages()) {
            $this->nextCursor = $productlist->nextCursor()->encode();
        }
        $this->currentCursor = $productlist->cursor();
    }
}
