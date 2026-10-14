<?php

namespace App\Livewire\Reports;

use App\Models\Product;
use App\Models\Translation;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Title;
use Livewire\Component;

class StockReport extends Component
{
    public  $products, $lang, $search;

    #[Title('Stock Report')]
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
        return view('livewire.reports.stock-report');
    }
    public function mount()
    {
        if (session()->has('selected_language')) {
            $this->lang = Translation::where('id', session()->get('selected_language'))->first();
        } else {
            $this->lang = Translation::where('default', 1)->first();
        }
        $this->report();
    }
    public function updated($name, $value)
    {
        $this->report();
    }
    public function report()
    {
        $this->products = \App\Models\Product::latest()->get();
    }
    public function downloadFile()
    {
        $products = $this->products;

        // Calculate stock for each product
        foreach ($products as $product) {
            $product->current_stock = $product->calculateStock();
        }

        $pdfContent = Pdf::loadView('livewire.reports.download-report.stock-report', compact('products'))->output();

        return response()->streamDownload(fn() => print($pdfContent), "ProductReport.pdf");
    }
}
