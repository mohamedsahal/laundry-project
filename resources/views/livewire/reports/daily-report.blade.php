<div class="dashboard-main-body">
    <div class="card h-100 p-0 radius-12">
        <div
            class="tw-py-1.5 tw-px-3 bg-base d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <div class="d-flex align-items-center flex-wrap gap-3">
                <div class="d-flex  gap-1 tw-flex-col">
                    <span class="fw-medium">{{ $lang->data['date'] ?? 'Date' }}</span>
                    <input type="date" class="form-control bg-base h-40-px w-auto" wire:model.live="today">
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scroll-sm tw-min-h-[calc(100vh-16rem)]">
                <table class="table bordered-table sm-table mb-0">
                    <thead>
                        <tr>
                            <th scope="col" class="">{{ $lang->data['particulars'] ?? 'Particulars' }}</th>
                            <th scope="col" class="">{{ $lang->data['value'] ?? 'Value' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <p class="text-sm px-3 mb-0">{{ $lang->data['orders'] ?? 'Orders' }}</p>
                            </td>
                            <td>
                                <p class="text-sm font-weight-bold text-warning mb-0">{{$new_order}}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="text-sm px-3 mb-0">
                                    {{ $lang->data['no_of_orders_delivered'] ?? 'No. of Orders Delivered' }}
                                </p>
                            </td>
                            <td>
                                <p class="text-sm font-weight-bold text-primary mb-0">{{$delivered_orders}}</p>
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <p class="text-sm px-3 mb-0">{{ $lang->data['total_sales'] ?? 'Total Sales' }}</p>
                            </td>
                            <td>
                                <p class="text-sm font-weight-bold text-success mb-0">
                                    {{getFormattedCurrency($total_sales)}}
                                </p>
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <p class="text-sm px-3 mb-0">{{ $lang->data['total_payment'] ?? 'Total Payment' }}</p>
                            </td>
                            <td>
                                <p class="text-sm font-weight-bold text-info mb-0">
                                    {{getFormattedCurrency($total_payment)}}
                                </p>
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <p class="text-sm px-3 mb-0">{{ $lang->data['total_expense'] ?? 'Total Expense' }}</p>
                            </td>
                            <td>
                                <p class="text-sm font-weight-bold text-danger mb-0">
                                    {{getFormattedCurrency($total_expense)}}
                                </p>
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <p class="text-sm px-3 mb-0">{{ $lang->data['materials_used'] ?? 'Materials Used' }}</p>
                            </td>
                            <td>
                                <p class="text-sm font-weight-bold text-warning mb-0">
                                    {{getFormattedCurrency($total_material)}}
                                </p>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="tw-flex tw-items-center tw-justify-end tw-w-full tw-p-2 tw-gap-2">
                <div class="tw-flex tw-items-center tw-gap-2">
                @can('report_download')
                <button type="button" wire:click="downloadFile()"
                        class="btn btn-warning-100 text-warning-600 radius-8 px-16 py-9">{{$lang->data['download_report'] ?? 'Download Report'}}</button>
                @endcan
                @can('report_print')
                <a href="{{url('admin/reports/print-report/daily/'.$today)}}" target="_blank">
                        <button type="button"
                            class="btn btn-success-100 text-success-600 radius-8 px-16 py-9">{{$lang->data['print_report'] ?? 'Print Report'}}</button>
                    </a>
                </div>
                @endcan
            </div>
        </div>
    </div>
</div>