<?php
namespace App\Livewire\Reports\DownloadReport;
use Livewire\Component;
use Livewire\Attributes\Layout;
class ExpenseReport extends Component
{
    public $expenses, $from_date, $to_date;
    /* render the page*/
    #[Layout('components.layouts.print-layout')]
    public function render()
    {
        return view('livewire.reports.download-report.expense-report');
    }
}