<div class="dashboard-main-body">
    <div class="p-0 card h-100 radius-12">
        <div
            class="tw-py-1.5 tw-px-3 bg-base d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <div class="gap-4 tw-flex tw-items-center">
                <div class="flex-wrap gap-3 d-flex align-items-center">
                    <div class="gap-1 d-flex tw-flex-col">
                        <span class="fw-medium">{{ $lang->data['start_date'] ?? 'Start Date' }}</span>
                        <input type="date" class="w-auto form-control bg-base h-40-px" wire:model.live="from_date">
                    </div>
                </div>
                <div class="flex-wrap gap-3 d-flex align-items-center">
                    <div class="gap-1 d-flex tw-flex-col">
                        <span class="fw-medium">{{ $lang->data['end_date'] ?? 'End Date' }}</span>
                        <input type="date" class="w-auto form-control bg-base h-40-px" wire:model.live="to_date">
                    </div>
                </div>
            </div>
        </div>
        <div class="p-0 card-body">
            <div class="table-responsive scroll-sm tw-min-h-[calc(100vh-16rem)]">
                <table class="table mb-0 bordered-table sm-table">
                    <thead>
                        <tr>
                            <th scope="col" class="">{{ $lang->data['date_of_purchase'] ?? 'Date Of Purchase' }}</th>
                            <th scope="col" class="">{{ $lang->data['purchase'] ?? 'Purchase' }}#</th>
                            <th scope="col" class="">{{ $lang->data['supplier'] ?? 'Supplier' }}</th>
                            <th scope="col" class="">{{ $lang->data['subtotal'] ?? 'Subtotal' }}</th>
                            <th scope="col" class="">{{ $lang->data['discount'] ?? 'Discount' }}</th>
                            <th scope="col" class="">{{ $lang->data['tax_amount'] ?? 'Tax Amount' }}</th>
                            <th scope="col" class="">{{ $lang->data['gross_total'] ?? 'Gross Total' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($purchase_return as $row)
                        <tr>
                            <td >
                                <p class="">
                                {{\Carbon\Carbon::parse($row->invoice_date)->format('d/m/Y')}}
                                </p>
                            </td>
                            <td >
                                <p class="tw-text-black">
                                    <span class="font-weight-bold">{{$row->purchase_return_number}}</span>
                                </p>
                            </td>
                            <td >
                                <p class="tw-text-black">{{$row->supplier_name}}</p>
                            </td>
                            <td >
                                <p class="">{{getFormattedCurrency($row->sub_total)}}</p>
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
                <div class="tw-flex tw-items-center tw-gap-4">
                    <div class="">{{$lang->data['total_purchases'] ?? 'Total Purchases'}}: <span class="tw-font-bold">{{count($purchase_return)}}</span></div>
                    <div class="">{{$lang->data['total_sales'] ?? 'Total Purchase'}} : <span class="tw-font-bold">{{getFormattedCurrency($purchase_return->sum('total'))}}</span></div>
                    <div class="">{{$lang->data['total_tax_amount'] ?? 'Total Tax Amount'}} : <span class="tw-font-bold">{{getFormattedCurrency($purchase_return->sum('tax_amount'))}}</span></div>
                </div>
                <div class="tw-flex tw-items-center tw-gap-2">
                    @can('report_download')
                    <button type="button"   wire:click="downloadFile()" class="px-16 btn btn-warning-100 text-warning-600 radius-8 py-9">{{$lang->data['download_report'] ?? 'Download Report'}}</button>
                    @endcan
                     
                    <a href="{{url('admin/reports/print-report/purchase-return/'.$from_date.'/'.$to_date)}}" target="_blank">  
                        <button type="button" class="px-16 btn btn-success-100 text-success-600 radius-8 py-9">{{$lang->data['print_report'] ?? 'Print Report'}}</button>
                    </a>
                     
                </div>
            </div>
        </div>
    </div>
</div>
