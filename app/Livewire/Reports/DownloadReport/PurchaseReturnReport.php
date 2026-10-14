<?php

namespace App\Livewire\Reports\DownloadReport;

use Livewire\Attributes\Layout;
use Livewire\Component;

class PurchaseReturnReport extends Component
{
    #[Layout('components.layouts.print-layout')]
    public function render()
    {
        return view('livewire.reports.download-report.purchase-return-report');
    }
}
