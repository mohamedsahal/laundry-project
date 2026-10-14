<?php
namespace App\Livewire\Reports\DownloadReport;
use Livewire\Component;
use Livewire\Attributes\Layout;
class TaxReport extends Component
{   /* render the page */
    #[Layout('components.layouts.print-layout')]
    public function render()
    {
        return view('livewire.reports.download-report.tax-report');
    }
}