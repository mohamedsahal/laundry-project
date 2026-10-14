<div class="dashboard-main-body">
    <div class="card h-100 p-0 radius-12">
        <div
            class="tw-py-1.5 tw-px-3 bg-base d-flex align-items-center flex-wrap gap-3 justify-content-between">
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
                            <th scope="col" class="">{{ $lang->data['date'] ?? 'Date' }}</th>
                            <th scope="col" class="">{{ $lang->data['order'] ?? 'Order' }}#</th>
                            <th scope="col" class="">{{ $lang->data['customer'] ?? 'Customer' }}</th>
                            <th scope="col" class="">{{ $lang->data['subtotal'] ?? 'Subtotal' }}</th>
                            <th scope="col" class="">{{ $lang->data['addon_total'] ?? 'Addon Total' }}</th>
                            <th scope="col" class="">{{ $lang->data['discount'] ?? 'Discount' }}</th>
                            <th scope="col" class="">{{ $lang->data['tax_amount'] ?? 'Tax Amount' }}</th>
                            <th scope="col" class="">{{ $lang->data['gross_total'] ?? 'Gross Total' }}</th>

                        </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $row)
                        <tr>
                            <td >
                                <p class="">
                                {{\Carbon\Carbon::parse($row->order_date)->format('d/m/Y')}}
                                </p>
                            </td>
                            <td >
                                <p class="tw-text-black">
                                    <span class="font-weight-bold">{{$row->order_number}}</span>
                                </p>
                            </td>
                            <td >
                                <p class="tw-text-black">{{$row->customer_name}}</p>
                            </td>
                            <td >
                                <p class="">{{getFormattedCurrency($row->sub_total)}}</p>
                            </td>
                            <td >
                                <p class="">{{getFormattedCurrency($row->addon_total)}} </p>
                            </td>
                            <td >
                                <p class="">{{getFormattedCurrency($row->discount)}}</p>
                            </td>
                            <td >
                                <p class="">{{getFormattedCurrency($row->tax_amount)}}</p>
                            </td>
                            <td >
                                <p class="">{{getFormattedCurrency($row->total)}}</p>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tw-flex tw-items-center tw-justify-between tw-w-full tw-p-2 tw-gap-2">
                <div class="tw-flex tw-items-center  tw-gap-4">
                    <div class="">{{$lang->data['total_orders'] ?? 'Total Orders'}}: <span class="tw-font-bold">{{count($orders)}}</span></div>
                    <div class="">{{$lang->data['total_sales'] ?? 'Total Sales'}} : <span class="tw-font-bold">{{getFormattedCurrency($orders->sum('total'))}}</span></div>
                    <div class="">{{$lang->data['total_tax_amount'] ?? 'Total Tax Amount'}} : <span class="tw-font-bold">{{getFormattedCurrency($orders->sum('tax_amount'))}}</span></div>
                </div>
                <div class="tw-flex tw-items-center tw-gap-2">
                    @can('report_download')
                    <button type="button"   wire:click="downloadFile()" class="btn btn-warning-100 text-warning-600 radius-8 px-16 py-9">{{$lang->data['download_report'] ?? 'Download Report'}}</button>
                    @endcan
                    @can('report_print')
                    <a href="{{url('admin/reports/print-report/sales/'.$from_date.'/'.$to_date)}}" target="_blank">  
                        <button type="button" class="btn btn-success-100 text-success-600 radius-8 px-16 py-9">{{$lang->data['print_report'] ?? 'Print Report'}}</button>
                    </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
