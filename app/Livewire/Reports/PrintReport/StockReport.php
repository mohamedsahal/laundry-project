<?php

namespace App\Livewire\Reports\PrintReport;

use Livewire\Attributes\Layout;
use Livewire\Component;

class StockReport extends Component
{
    public $products;

    #[Layout('components.layouts.print-layout')]
    public function render()
    {
        return view('livewire.reports.print-report.stock-report');
    }
    public function  mount()
    {
        $this->products = \App\Models\Product::latest()->get();
    }
}
