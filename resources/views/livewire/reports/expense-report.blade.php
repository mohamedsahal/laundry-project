<div class="dashboard-main-body">
    <div class="card h-100 p-0 radius-12">
        <div class="tw-py-1.5 tw-px-3 bg-base d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <div class="tw-flex  tw-items-center gap-4">
                <div class="d-flex align-items-center flex-wrap gap-3">
                    <div class="d-flex  gap-1 tw-flex-col">
                        <span class="fw-medium">{{ $lang->data['start_date'] ?? 'Start Date' }}</span>
                        <input type="date" class="form-control bg-base h-40-px w-auto" wire:model.live="from_date">
                    </div>
                </div>

                <div class="d-flex align-items-center flex-wrap gap-3">
                    <div class="d-flex  gap-1 tw-flex-col">
                        <span class="fw-medium">{{ $lang->data['end_date'] ?? 'End Date' }}</span>
                        <input type="date" class="form-control bg-base h-40-px w-auto" wire:model.live="to_date">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scroll-sm tw-min-h-[calc(100vh-16rem)]">
                <table class="table bordered-table sm-table mb-0">
                    <thead>
                        <tr>
                            <th class="">{{$lang->data['date'] ?? 'Date'}}</th>
                            <th class="">{{$lang->data['towards'] ?? 'Towards'}}</th>
                            <th class="">{{$lang->data['expense_amount'] ?? 'Expense Amount'}}</th>
                            <th class="">{{$lang->data['tax'] ?? 'Tax'}}%</th>
                            <th class="">{{$lang->data['tax_amount'] ?? 'Tax Amount'}}</th>
                            <th class="">{{$lang->data['payment_mode'] ?? 'Payment Mode'}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $tax_amount_total = 0;
                        @endphp
                        @foreach($expenses as $row)
                        <tr>
                            <td>
                                <p class="">
                                    {{\Carbon\Carbon::parse($row->expense_date)->format('d/m/Y')}}
                                </p>
                            </td>
                            <td>
                                <p class="">
                                    <span class="">{{$row->expenseCategory->expense_category_name ?? ""}}</span>
                                </p>
                            </td>
                            <td>
                                <p class="">{{getFormattedCurrency($row->expense_amount)}}</p>
                            </td>
                            <td>
                                <p class="">{{$row->tax_percentage}}</p>
                            </td>
                            <td>
                                <p class="">
                                    @php
                                    $tax_amount = $row->expense_amount * ($row->tax_percentage/100);
                                    $tax_amount_total +=$tax_amount;
                                    @endphp
                                    {{getFormattedCurrency($tax_amount)}}
                                </p>
                            </td>
                            <td>
                                <p class="">{{getpaymentMode($row->payment_mode)}}</p>
                            </td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
            </div>
            <div class="tw-flex tw-items-center tw-justify-between tw-w-full tw-p-2 tw-gap-2">
                <div class="tw-flex tw-items-center  tw-gap-4">
                    <div class="">{{$lang->data['total_expenses'] ?? 'Total Expenses'}} : <span class="tw-font-bold">{{count($expenses)}}</span></div>
                    <div class="">{{$lang->data['total_expense_amount'] ?? 'Total Expense Amount'}} : <span class="tw-font-bold">{{getFormattedCurrency($expenses->sum('expense_amount'))}}</span></div>
                    <div class="">{{$lang->data['total_tax_amount'] ?? 'Total Tax Amount'}} : <span class="tw-font-bold">{{getFormattedCurrency($tax_amount_total)}}</span></div>
                </div>
                <div class="tw-flex tw-items-center tw-gap-2">
                    @can('report_download')
                    <button wire:click="downloadFile()"
                        class="btn btn-warning-100 text-warning-600 radius-8 px-16 py-9">{{$lang->data['download_report'] ?? 'Download Report'}}</button>
                    @endcan
                    @can('report_print')
                    <a href="{{url('admin/reports/print-report/expense/'.$this->from_date.'/'.$this->to_date)}}" target="_blank">
                        <button type="button"
                            class="btn btn-success-100 text-success-600 radius-8 px-16 py-9">{{$lang->data['print_report'] ?? 'Print Report'}}</button>
                    </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>