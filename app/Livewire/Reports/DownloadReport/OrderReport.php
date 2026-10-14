<?php
namespace App\Livewire\Reports\DownloadReport;
use Livewire\Component;
use Livewire\Attributes\Layout;
class OrderReport extends Component
{  /* render the page */
    #[Layout('components.layouts.print-layout')]
    public function render()
    {
        return view('livewire.reports.download-report.order-report');
    }
}