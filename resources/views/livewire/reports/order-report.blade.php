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
                <div class="d-flex align-items-center flex-wrap gap-3">
                    <div class="d-flex  gap-1 tw-flex-col">
                        <span class="fw-medium">{{ $lang->data['status'] ?? 'Status' }}</span>
                        <select class="form-select form-select-sm bg-base h-40-px w-auto" wire:model.live="status">
                            <option class="select-box" value="-1">{{$lang->data['all_orders'] ?? 'All Orders'}}</option>
                            <option class="select-box" value="0">{{$lang->data['pending'] ?? 'Pending'}}</option>
                            <option class="select-box" value="1">{{$lang->data['processing'] ?? 'Processing'}}</option>
                            <option class="select-box" value="2">{{$lang->data['ready_to_deliver'] ?? 'Ready To Deliver'}}</option>
                            <option class="select-box" value="3">{{$lang->data['delivered'] ?? 'Delivered'}}</option>
                            <option class="select-box" value="4">{{$lang->data['returned'] ?? 'Returned'}}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scroll-sm tw-min-h-[calc(100vh-16rem)] ">
                <table class="table bordered-table sm-table mb-0">
                    <thead>
                        <tr>
                            <th style="width: 15%" class="">{{$lang->data['date'] ?? 'Date'}}</th>
                            <th style="width: 15%" class="">{{$lang->data['order_id'] ?? 'Order ID'}}</th>
                            <th style="width: 30%" class="">{{$lang->data['customer'] ?? 'Customer'}}</th>
                            <th style="width: 20%" class="">{{$lang->data['order_amount'] ?? 'Order Amount'}}</th>
                            <th style="width: 20%" class="">{{$lang->data['status'] ?? 'Status'}}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $row)
                        <tr>
                            <td>
                                <p class="text-sm  mb-0"> {{\Carbon\Carbon::parse($row->order_date)->format('d/m/Y')}}</p>
                            </td>
                            <td>
                                <p class="text-sm font-weight-bold tw-text-black mb-0">{{$row->order_number}}</p>
                            </td>
                            <td>
                                <p class="text-sm font-weight-bold tw-text-black mb-0">{{$row->customer_name ?? ""}}</p>
                            </td>
                            <td>
                                <p class="text-sm font-weight-bold text-primary mb-0">{{getFormattedCurrency($row->total)}}</p>
                            </td>
                            <td>
                                <span class="badge  fw-semibold text-info-600 bg-info-100 px-20 py-9 radius-4 text-white">
                                {{getOrderStatus($row->status)}}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tw-flex tw-items-center tw-justify-between tw-w-full tw-p-2 tw-gap-2">
                <div class="tw-flex tw-items-center  tw-gap-4">
                    <div class="">{{$lang->data['total_orders'] ?? 'Total Orders'}} : <span class="tw-font-bold">{{count($orders)}}</span></div>
                    <div class="">{{$lang->data['total_order_amount'] ?? 'Total Order Amount'}} : <span class="tw-font-bold">{{getFormattedCurrency($orders->sum('total'))}}</span></div>
                </div>
                <div class="tw-flex tw-items-center tw-gap-2">
                    @can('report_download')
                    <button type="button"  wire:click="downloadFile()" class="btn btn-warning-100 text-warning-600 radius-8 px-16 py-9">{{$lang->data['download_report'] ?? 'Download Report'}}</button>
                    @endcan
                    @can('report_print')
                    <a href="{{url('admin/reports/print-report/order/'.$from_date.'/'.$to_date.'/'.$status)}}" target="_blank">   
                        <button type="button" class="btn btn-success-100 text-success-600 radius-8 px-16 py-9">{{$lang->data['print_report'] ?? 'Print Report'}}</button>
                    </a>
                    @endcan
                </div>
            </div>
        
        </div>
    </div>

</div>
