<?php

namespace App\Livewire\Reports\DownloadReport;
use Livewire\Component;
use Livewire\Attributes\Layout;
class DailyReport extends Component
{
    public $today, $new_order, $delivered_orders, $total_payment, $total_expense, $total_sales,$lang;
    /* render the page */
    #[Layout('components.layouts.print-layout')]
    public function render()
    {
        return view('livewire.reports.download-report.daily-report');
    }
}