<?php

namespace App\Livewire\Inventory\StockUsage;

use App\Models\Product;
use App\Models\StockUsage;
use App\Models\Translation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

class StockUsageList extends Component
{
    #[Title('Stock Usage')]
    public $usage_date, $product_id, $quantity, $note, $usage;
    public $usages, $products, $search = '', $from_date, $to_date, $lang;
    /* called before render */
    public function mount()
    {
        if (!\Illuminate\Support\Facades\Gate::allows('inventory_list')) {
            abort(404);
        }
        if (session()->has('selected_language')) {
            /* if session has selected language */
            $this->lang = Translation::where('id', session()->get('selected_language'))->first();
        } else {
            /* if session has no selected language */
            $this->lang = Translation::where('default', 1)->first();
        }
        $this->from_date = Carbon::today()->startOfMonth()->toDateString();
        $this->to_date = Carbon::today()->toDateString();
        $this->usage_date = Carbon::today()->toDateString();
    }
    /* render the page */
    public function render()
    {
        $this->products = Product::with('unit')->where('is_active', 1)->where('is_consumable', 1)->orderBy('name')->get();
        $query = StockUsage::with(['product.unit', 'user'])->orderBy('usage_date', 'desc')->orderBy('id', 'desc');
        if ($this->from_date) {
            $query->whereDate('usage_date', '>=', $this->from_date);
        }
        if ($this->to_date) {
            $query->whereDate('usage_date', '<=', $this->to_date);
        }
        if ($this->search != '') {
            $query->whereHas('product', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        }
        $this->usages = $query->get();
        return view('livewire.inventory.stock-usage.stock-usage-list');
    }
    /* reset input fields */
    public function resetInputFields()
    {
        $this->usage = null;
        $this->product_id = '';
        $this->quantity = '';
        $this->note = '';
        $this->usage_date = Carbon::today()->toDateString();
        $this->resetErrorBag();
    }
    /* stock that can still be used for the selected product */
    public function availableStock()
    {
        $product = Product::find($this->product_id);
        if (!$product) {
            return 0;
        }
        $stock = $product->calculateStock();
        /* while editing, the quantity already recorded is still available */
        if ($this->usage && $this->usage->product_id == $product->id) {
            $stock += $this->usage->quantity;
        }
        return round($stock, 3);
    }
    /* validate the usage form */
    private function validateUsage()
    {
        $this->validate([
            'usage_date' => 'required|date',
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|numeric|gt:0',
        ]);
        $available = $this->availableStock();
        if ($this->quantity > $available) {
            $this->addError('quantity', 'Only ' . $available . ' in stock.');
            return false;
        }
        return true;
    }
    /* save stock usage */
    public function store()
    {
        if (!$this->validateUsage()) {
            return;
        }
        $product = Product::find($this->product_id);
        $unitCost = $product->averageCost();
        StockUsage::create([
            'usage_date'        => $this->usage_date,
            'product_id'        => $product->id,
            'quantity'          => $this->quantity,
            'unit_cost'         => $unitCost,
            'total_cost'        => round($unitCost * $this->quantity, 2),
            'note'              => $this->note,
            'financial_year_id' => getFinancialYearId(),
            'created_by'        => Auth::user()->id,
        ]);
        $this->resetInputFields();
        $this->dispatch('closemodal');
        $this->dispatch(
            'alert',
            ['type' => 'success',  'message' => 'Stock usage has been recorded!']
        );
    }
    /* view stock usage details to update */
    public function edit($id)
    {
        $this->resetErrorBag();
        $this->usage = StockUsage::where('id', $id)->first();
        $this->usage_date = Carbon::parse($this->usage->usage_date)->toDateString();
        $this->product_id = $this->usage->product_id;
        $this->quantity = $this->usage->quantity;
        $this->note = $this->usage->note;
    }
    /* update stock usage */
    public function update()
    {
        if (!$this->usage || !$this->validateUsage()) {
            return;
        }
        $product = Product::find($this->product_id);
        /* keep the original cost unless the product changed */
        $unitCost = $product->id == $this->usage->product_id ? $this->usage->unit_cost : $product->averageCost();
        $this->usage->update([
            'usage_date' => $this->usage_date,
            'product_id' => $product->id,
            'quantity'   => $this->quantity,
            'unit_cost'  => $unitCost,
            'total_cost' => round($unitCost * $this->quantity, 2),
            'note'       => $this->note,
        ]);
        $this->resetInputFields();
        $this->dispatch('closemodal');
        $this->dispatch(
            'alert',
            ['type' => 'success',  'message' => 'Stock usage has been updated!']
        );
    }
    /* delete stock usage */
    public function delete($id)
    {
        StockUsage::where('id', $id)->delete();
        $this->dispatch(
            'alert',
            ['type' => 'success',  'message' => 'Stock usage has been deleted!']
        );
    }
}
