<div class="dashboard-main-body">
    <div class="tw-flex tw-items-center tw-justify-end">
        <select class="form-select form-select-sm w-auto bg-base border text-secondary-light" wire:model.live="dateFilter">
            <option value="all">{{$lang->data['all'] ?? 'All'}}</option>
            <option value="monthly">{{$lang->data['monthly'] ?? 'Monthly'}}</option>
            <option value="weekly">{{$lang->data['weekly'] ?? 'Weekly'}}</option>
            <option value="today">{{$lang->data['today'] ?? 'Today'}}</option>
        </select>
    </div>
    <div class="overflow-x-auto scroll-sm tw-py-4">
        <div class="kanban-wrapper">
            <div class="d-flex align-items-start gap-24" id="sortable-wrapper">
                <div class="w-100 kanban-item radius-12 progress-card" >
                    <div class="card p-0 radius-12 overflow-hidden shadow-none">
                        <div class="card-body p-0 pb-24">
                            <div class="d-flex align-items-center gap-2 justify-content-between ps-24 pt-24 pe-24">
                                <h6 class="text-lg fw-semibold mb-0">{{ $lang->data['pending'] ?? 'Pending' }}</h6>
                                <div class="d-flex align-items-center gap-3 justify-content-between mb-0">
                                </div>
                            </div>
                            <div class="connectedSortable ps-24 pt-24 pe-24" id="pending">
                                @foreach ($pending_orders as $item)
                                <div class="kanban-card bg-neutral-50 p-16 radius-8 mb-24" id="{{ $item->id }}">
                                    <div class="tw-flex tw-justify-between tw-items-center">
                                        <div class="tw-flex tw-flex-col">
                                            <div class="tw-font-bold text-primary-light">{{ $item->order_number }}</div>
                                            <div class="text-sm text-secondary-light fw-normal tw-flex tw-items-center tw-gap-2 tw-mt-1">
                                                <iconify-icon icon="solar:calendar-outline" class="text-primary-light"></iconify-icon>
                                                {{ $lang->data['delivery_date'] ?? 'Delivery Date' }}:
                                                <span class="tw-font-bold">{{ \Carbon\Carbon::parse($item->delivery_date)->format('d/m/Y') }}</span>
                                            </div>
                                            <div class="text-sm text-secondary-light fw-normal tw-flex tw-items-center tw-gap-2 tw-mt-1">
                                                <iconify-icon icon="mdi:user-outline" class="text-primary-light"></iconify-icon>
                                                {{ $lang->data['customer'] ?? 'Customer' }}:
                                                <span class="tw-font-bold">{{ $item->customer_name ?? ($lang->data['walk_in_customer'] ?? 'Walk In Customer') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tw-flex tw-gap-2 tw-items-center tw-my-2">
                                        @php
                                        $services = \App\Models\OrderDetail ::where('order_id', $item->id)
                                                ->limit(4)
                                                ->get();
                                        @endphp
                                           <div class="tw-size-8 tw-rounded-lg tw-overflow-clip">
                                            @foreach ($services as $row)
                                                @php
                                                    $service = \App\Models\Service::where('id', $row->service_id)->first();
                                                @endphp
                                            <img src="{{$service->image()}}" alt="">
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="mt-12 d-flex align-items-center justify-content-between gap-10">
                                        <div class="d-flex align-items-center justify-content-between gap-10">
                                            <iconify-icon icon="solar:calendar-outline" class="text-primary-light"></iconify-icon>
                                            <span class="start-date text-secondary-light">{{ \Carbon\Carbon::parse($item->order_date)->format('d/m/Y') }}</span>
                                        </div>
                                        
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-100 kanban-item radius-12 pending-card" >
                    <div class="card p-0 radius-12 overflow-hidden shadow-none">
                        <div class="card-body p-0 pb-24">
                            <div class="d-flex align-items-center gap-2 justify-content-between ps-24 pt-24 pe-24">
                                <h6 class="text-lg fw-semibold mb-0">{{ $lang->data['processing'] ?? 'Processing' }}</h6>
                                <div class="d-flex align-items-center gap-3 justify-content-between mb-0">
                                </div>
                            </div>
                            <div class="connectedSortable ps-24 pt-24 pe-24" id="processing">
                                @foreach ($processing_orders as $item)
                                <div class="kanban-card bg-neutral-50 p-16 radius-8 mb-24" id="{{ $item->id }}">
                                    <div class="tw-flex tw-justify-between tw-items-center">
                                        <div class="tw-flex tw-flex-col">
                                            <div class="tw-font-bold text-primary-light">{{ $item->order_number }}</div>
                                            <div class="text-sm text-secondary-light fw-normal tw-flex tw-items-center tw-gap-2 tw-mt-1">
                                                <iconify-icon icon="solar:calendar-outline" class="text-primary-light"></iconify-icon>
                                                {{ $lang->data['delivery_date'] ?? 'Delivery Date' }}:
                                                <span class="tw-font-bold">{{ \Carbon\Carbon::parse($item->delivery_date)->format('d/m/Y') }}</span>
                                            </div>
                                            <div class="text-sm text-secondary-light fw-normal tw-flex tw-items-center tw-gap-2 tw-mt-1">
                                                <iconify-icon icon="mdi:user-outline" class="text-primary-light"></iconify-icon>
                                                {{ $lang->data['customer'] ?? 'Customer' }}:
                                                <span class="tw-font-bold">{{ $item->customer_name ?? ($lang->data['walk_in_customer'] ?? 'Walk In Customer') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tw-flex tw-gap-2 tw-items-center tw-my-2">
                                        @php
                                        $services = \App\Models\OrderDetail ::where('order_id', $item->id)
                                                ->limit(4)
                                                ->get();
                                        @endphp
                                           <div class="tw-size-8 tw-rounded-lg tw-overflow-clip">
                                            @foreach ($services as $row)
                                                @php
                                                    $service = \App\Models\Service::where('id', $row->service_id)->first();
                                                @endphp
                                            <img src="{{$service->image()}}" alt="">
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="mt-12 d-flex align-items-center justify-content-between gap-10">
                                        <div class="d-flex align-items-center justify-content-between gap-10">
                                            <iconify-icon icon="solar:calendar-outline" class="text-primary-light"></iconify-icon>
                                            <span class="start-date text-secondary-light">{{ \Carbon\Carbon::parse($item->order_date)->format('d/m/Y') }}</span>
                                        </div>
                                       
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-100 kanban-item radius-12 done-card">
                    <div class="card p-0 radius-12 overflow-hidden shadow-none">
                        <div class="card-body p-0 pb-24">
                            <div class="d-flex align-items-center gap-2 justify-content-between ps-24 pt-24 pe-24">
                                <h6 class="text-lg fw-semibold mb-0">{{ $lang->data['ready_to_deliver'] ?? 'Ready To Deliver' }}</h6>
                                <div class="d-flex align-items-center gap-3 justify-content-between mb-0">
                                </div>
                            </div>
                            <div class="connectedSortable ps-24 pt-24 pe-24"  id="ready">
                                @foreach ($ready_orders as $item)
                                <div class="kanban-card bg-neutral-50 p-16 radius-8 mb-24" id="{{ $item->id }}">
                                    <div class="tw-flex tw-justify-between tw-items-center">
                                        <div class="tw-flex tw-flex-col">
                                            <div class="tw-font-bold text-primary-light">{{ $item->order_number }}</div>
                                            <div class="text-sm text-secondary-light fw-normal tw-flex tw-items-center tw-gap-2 tw-mt-1">
                                                <iconify-icon icon="solar:calendar-outline" class="text-primary-light"></iconify-icon>
                                                {{ $lang->data['delivery_date'] ?? 'Delivery Date' }}:
                                                <span class="tw-font-bold">{{ \Carbon\Carbon::parse($item->delivery_date)->format('d/m/Y') }}</span>
                                            </div>
                                            <div class="text-sm text-secondary-light fw-normal tw-flex tw-items-center tw-gap-2 tw-mt-1">
                                                <iconify-icon icon="mdi:user-outline" class="text-primary-light"></iconify-icon>
                                                {{ $lang->data['customer'] ?? 'Customer' }}:
                                                <span class="tw-font-bold">{{ $item->customer_name ?? ($lang->data['walk_in_customer'] ?? 'Walk In Customer') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tw-flex tw-gap-2 tw-items-center tw-my-2">
                                        @php
                                        $services = \App\Models\OrderDetail ::where('order_id', $item->id)
                                                ->limit(4)
                                                ->get();
                                        @endphp
                                           <div class="tw-size-8 tw-rounded-lg tw-overflow-clip">
                                            @foreach ($services as $row)
                                                @php
                                                    $service = \App\Models\Service::where('id', $row->service_id)->first();
                                                @endphp
                                            <img src="{{$service->image()}}" alt="">
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="mt-12 d-flex align-items-center justify-content-between gap-10">
                                        <div class="d-flex align-items-center justify-content-between gap-10">
                                            <iconify-icon icon="solar:calendar-outline" class="text-primary-light"></iconify-icon>
                                            <span class="start-date text-secondary-light">{{ \Carbon\Carbon::parse($item->order_date)->format('d/m/Y') }}</span>
                                        </div>
                                       
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
    <script>
        "use strict";
       var drake = dragula([document.querySelector('#ready'), document.querySelector('#processing'), document
           .querySelector('#pending')
       ]);
       drake.on("drop", function(el, target, source, sibling) {
           @this.changestatus(el.id, target.id);
       });
   </script>
    @endpush
</div>