<div class="dashboard-main-body" x-data="initPaymentExpenseChart">
    <div class="tw-grid xl:tw-grid-cols-4 tw-gap-4 lg:tw-grid-cols-2 tw-grid-cols-1 tw-py-4">
        <div class="col">
            <div class="card tw-shadow-sm tw-ring-1 tw-ring-gray-200 bg-gradient-start-1 h-100">
                <div class="card-body p-20">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div>
                            <p class="fw-medium text-primary-light mb-1">
                                {{ $lang->data['pending_order'] ?? 'Pending Orders' }}
                            </p>
                            <h6 class="mb-0">{{ $pending_count }}</h6>
                        </div>
                        <div
                            class="w-50-px h-50-px tw-bg-blue-400 rounded-circle d-flex justify-content-center align-items-center">
                            <iconify-icon icon="game-icons:basket" class="text-white text-2xl mb-0"></iconify-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card tw-shadow-sm tw-ring-1 tw-ring-gray-200 bg-gradient-start-2 h-100">
                <div class="card-body p-20">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div>
                            <p class="fw-medium text-primary-light mb-1">
                                {{ $lang->data['processing_order'] ?? 'Processing Order' }}
                            </p>
                            <h6 class="mb-0"> {{ $processing_count }}</h6>
                        </div>
                        <div
                            class="w-50-px h-50-px bg-purple rounded-circle d-flex justify-content-center align-items-center">
                            <iconify-icon icon="material-symbols:hub-outline"
                                class="text-white text-2xl mb-0"></iconify-icon>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col">
            <div class="card tw-shadow-sm tw-ring-1 tw-ring-gray-200 bg-gradient-start-3 h-100">
                <div class="card-body p-20">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div>
                            <p class="fw-medium text-primary-light mb-1">
                                {{ $lang->data['ready_to_deliver'] ?? 'Ready To Deliver' }}
                            </p>
                            <h6 class="mb-0">{{ $ready_count }}</h6>
                        </div>
                        <div
                            class="w-50-px h-50-px bg-info rounded-circle d-flex justify-content-center align-items-center">
                            <iconify-icon icon="ion:thumbs-up" class="text-white text-2xl mb-0"></iconify-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card tw-shadow-sm tw-ring-1 tw-ring-gray-200 bg-gradient-start-4 h-100">
                <div class="card-body p-20">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div>
                            <p class="fw-medium text-primary-light mb-1">
                                {{ $lang->data['delivered_orders'] ?? 'Delivered Orders' }}
                            </p>
                            <h6 class="mb-0">{{ $delivered_count }}</h6>
                        </div>
                        <div
                            class="w-50-px h-50-px bg-success-main rounded-circle d-flex justify-content-center align-items-center">
                            <iconify-icon icon="mdi:check-bold" class="text-white text-2xl mb-0"></iconify-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row gy-4 mt-1">
        <div class=" @if ($pending_count ==0 || $processing_count == 0 || $ready_count == 0 || $delivered_count== 0) col-12 @else col-xl-12 @endif">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <h6 class="text-lg mb-0">{{ $lang->data['todays_delivery'] ?? "Today's Delivery" }}</h6>
                        <div class="tw-flex tw-items-center tw-gap-4">
                            <input type="text" class="form-control"
                                placeholder="{{ $lang->data['search_here'] ?? 'Search Here...' }}"
                                wire:model.live="search_query">

                            <select class="form-select" wire:model.live="order_filter">
                                <option class="select-box" value="">
                                    {{ $lang->data['all_orders'] ?? 'All Orders' }}
                                </option>
                                <option class="select-box" value="0">{{ $lang->data['pending'] ?? 'Pending' }}
                                </option>
                                <option class="select-box" value="1">
                                    {{ $lang->data['processing'] ?? 'Processing' }}
                                </option>
                                <option class="select-box" value="2">
                                    {{ $lang->data['ready_to_deliver'] ?? 'Ready To Deliver' }}
                                </option>
                                <option class="select-box" value="3">{{ $lang->data['delivered'] ?? 'Delivered' }}
                                </option>
                                <option class="select-box" value="4">{{ $lang->data['returned'] ?? 'Returned' }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="tw-grid tw-mt-4 tw-grid-cols-1 lg:tw-grid-cols-2 xl:tw-grid-cols-3  align-items-center tw-gap-2">
                        @foreach ($orders as $item)
                        <div class=" bg-neutral-50 p-16 radius-8 ">
                            <div class="tw-flex tw-justify-between tw-items-center">
                                <div class="tw-flex tw-flex-col">
                                    <div class="tw-font-bold text-primary-light">{{ $item->order_number }}</div>

                                    <div
                                        class="text-sm text-secondary-light fw-normal tw-flex tw-items-center tw-gap-2 tw-mt-1">
                                        <iconify-icon icon="mdi:user-outline"
                                            class="text-primary-light"></iconify-icon>
                                        {{ $lang->data['customer'] ?? 'Customer' }}:
                                        <span
                                            class="tw-font-bold">{{ $item->customer_name ?? ($lang->data['walk_in_customer'] ?? 'Walk In Customer') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="tw-flex tw-gap-2 tw-items-center tw-my-2">
                                @php
                                $services = \App\Models\OrderDetail::where('order_id', $item->id)
                                ->limit(4)
                                ->get();
                                @endphp
                                <div class="tw-size-8 tw-rounded-lg tw-overflow-clip">
                                    @foreach ($services as $row)
                                    @php
                                    $service = \App\Models\Service::where('id', $row->service_id)->first();
                                    @endphp
                                    <img src="{{ $service->image() }}"
                                        alt="">
                                    @endforeach
                                </div>
                            </div>
                            <div class="mt-12 d-flex align-items-center justify-content-between gap-10">
                                <div class="d-flex align-items-center justify-content-between gap-10">
                                    <iconify-icon icon="solar:calendar-outline"
                                        class="text-primary-light"></iconify-icon>
                                    <span
                                        class="start-date text-secondary-light">{{ \Carbon\Carbon::parse($item->order_date)->format('d/m/Y') }}</span>
                                </div>

                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if(count($orders) <= 0)
                        <x-empty-item />
                    @endif
                </div>
            </div>
        </div>
        <div class="col-xl-6" wire:ignore>
            <div class="card h-100 radius-8 border-0 overflow-hidden  tw-p-5">
                <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between  tw-mb-4">
                    <span class="mb-2 fw-bold tw-text-sm tw-tracking-wider">{{$lang->data['status_overview'] ?? 'Status Overview'}}</span>
                </div>
                <canvas id="myChart"></canvas>

                <div class="card-body p-24">
                    
                    <div id="userOverviewDonutChart"></div>
                    <ul class="d-flex flex-wrap align-items-center justify-content-between mt-3 gap-3">
                        <li class="d-flex align-items-center gap-2">
                            <span class="w-12-px h-12-px radius-2 tw-bg-[#8392ab]"></span>
                            <span class="text-secondary-light text-sm fw-normal">{{$lang->data['pending'] ?? 'Pending'}}
                            </span>
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <span class="w-12-px h-12-px radius-2 tw-bg-[#faae42]"></span>
                            <span class="text-secondary-light text-sm fw-normal">{{$lang->data['processing'] ?? 'Processing'}}
                            </span>
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <span class="w-12-px h-12-px radius-2 tw-bg-[#2dce89]"></span>
                            <span class="text-secondary-light text-sm fw-normal">{{$lang->data['ready_to_deliver'] ?? 'Ready To Deliver'}}
                            </span>
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <span class="w-12-px h-12-px radius-2 tw-bg-[#0083ff]"></span>
                            <span class="text-secondary-light text-sm fw-normal">{{$lang->data['delivered'] ?? 'Delivered'}}
                            </span>
                        </li>
                        <li class="d-flex align-items-center gap-2  tw-opacity-0">
                            <span class="w-12-px h-12-px radius-2 bg-primary-600"></span>
                            <span class="text-secondary-light text-sm fw-normal">{{$lang->data['ready_to_deliver'] ?? 'Ready To Deliver'}}
                            </span>
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <span class="w-12-px h-12-px radius-2 tw-bg-[#f5365c]"></span>
                            <span class="text-secondary-light text-sm fw-normal">{{$lang->data['returned'] ?? 'Returned'}}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="col-xl-6" wire:ignore>
            <div class="card h-100 radius-8 border-0 overflow-hidden tw-p-5">
                <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between tw-mb-4">
                    <span class="mb-2 fw-bold tw-text-sm tw-tracking-wider">{{$lang->data['payment_overview'] ?? 'Payment Overview'}}</span>
                </div>
                <canvas id="myChartPayment"></canvas>

                <div class="card-body p-24">
                    
                    <div id="userOverviewDonutChart"></div>
                    <ul class="d-flex flex-wrap align-items-center justify-content-between mt-3 gap-3">
                        <li class="d-flex align-items-center gap-2">
                            <span class="w-12-px h-12-px radius-2 tw-bg-[#f5365c]"></span>
                            <span class="text-secondary-light text-sm fw-normal">{{$lang->data['not_paid'] ?? 'Not Paid'}}
                            </span>
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <span class="w-12-px h-12-px radius-2 tw-bg-[#0083ff]"></span>
                            <span class="text-secondary-light text-sm fw-normal">{{$lang->data['partially_paid'] ?? 'Partially Paid'}}
                            </span>
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <span class="w-12-px h-12-px radius-2 tw-bg-[#2dce89]"></span>
                            <span class="text-secondary-light text-sm fw-normal">{{$lang->data['fully_paid'] ?? 'Fully paid'}}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

         <div class="col-xl-12  pb-8" wire:ignore>
            <div class="card h-100 radius-8 border-0 overflow-hidden tw-p-5">
                <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between tw-mb-4">
                    <span class="mb-2 fw-bold tw-text-sm tw-tracking-wider">{{$lang->data['payment_vs_expense'] ?? 'Payment vs Expense'}}</span>
                </div>
                <canvas id="paymentVsExpenseChart" class="tw-max-h-[34rem]"></canvas>

                <div class="card-body p-24">
                    
                    <div id="userOverviewDonutChart"></div>
                    <ul class="d-flex flex-wrap align-items-center justify-content-between mt-3 gap-3">
                        <li class="d-flex align-items-center gap-2">
                            <span class="w-12-px h-12-px radius-2 tw-bg-[#0083ff]"></span>
                            <span class="text-secondary-light text-sm fw-normal">{{$lang->data['payment'] ?? 'Payment'}}
                            </span>
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <span class="w-12-px h-12-px radius-2 tw-bg-[#f5365c]"></span>
                            <span class="text-secondary-light text-sm fw-normal">{{$lang->data['expense'] ?? 'Expense'}}
                            </span>
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <span class="w-12-px h-12-px radius-2 tw-bg-[#f59e0b]"></span>
                            <span class="text-secondary-light text-sm fw-normal">{{$lang->data['materials_used'] ?? 'Materials Used'}}
                            </span>
                        </li>
                       
                    </ul>
                </div>
            </div>
        </div>

        <input type="hidden" name="" id="chartdata" value="{{$array}}">
        <input type="hidden" name="" id="chartdataPayment" value="{{$payment_array}}">
    </div>

    @push('js')


    <script src="{{ asset('assets/js/chart.js') }}"></script>

    <script>
        var chartdata = document.getElementById("chartdata").value;
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Pending', 'Processing', 'Ready to Deliver', 'Delivered', 'Returned'],
                datasets: [{
                    data: JSON.parse(chartdata),
                    backgroundColor: ['#8392ab', '#faae42', '#2dce89', '#0083ff', '#f5365c'],
                    borderColor: ['#8392ab', '#faae42', '#2dce89', '#0083ff', '#f5365c'],
                    borderWidth: 1
                }]
            },
            options: {
                layout: {
                    padding: 0
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>

    <script>
    var chartdataPayment = document.getElementById("chartdataPayment").value;
    const ctxPayment = document.getElementById('myChartPayment');

    const data = JSON.parse(chartdataPayment);

    new Chart(ctxPayment, {
        data: {
        labels: ['Not Paid', 'Partially Paid', 'Fully Paid'],
        datasets: [
            {
            type: 'line',
            label: 'Payment Line',
            data: data,
            borderColor: '#222',
            borderWidth: 2,
            fill: false,
            tension: 0.4, // smooth curve
            pointBackgroundColor: '#222'
            },
            {
            type: 'bar',
            label: 'Payment Bar',
            data: data,
            backgroundColor: ['#f5365c', '#0083ff', '#2dce89'],
            borderColor: ['#f5365c', '#0083ff', '#2dce89'],
            borderWidth: 1
            },
        
        ]
        },
        options: {
        layout: {
            padding: 0
        },
        plugins: {
            legend: {
            display: false
            }
        },
        scales: {
            y: {
            beginAtZero: true
            }
        }
        }
    });
    </script>

    <script>
        function initPaymentExpenseChart(){
            return{
                init(){
                    const ctxPayment2 = document.getElementById('paymentVsExpenseChart');
                    const expenseData = this.$wire.payment_expense_chart[1];
                    const paymentData = this.$wire.payment_expense_chart[0];
                    const materialData = this.$wire.payment_expense_chart[2];
                    const labels = this.$wire.payment_chart_labels
                    const data2 = [];
                    let chart = new Chart(ctxPayment2, {
                        data: {
                        labels: labels,
                        datasets: [
                                {
                                    type: 'bar',
                                    label: 'Payment ',
                                    data: paymentData,
                                    backgroundColor: ['#0083ff'],
                                    borderColor: ['#0083ff'],
                                    borderWidth: 1
                                },
                                {
                                    type: 'bar',
                                    label: 'Expense ',
                                    data: expenseData,
                                    backgroundColor: ['#f5365c'],
                                    borderColor: ['#f5365c'],
                                    borderWidth: 1
                                },
                                {
                                    type: 'bar',
                                    label: 'Materials Used ',
                                    data: materialData,
                                    backgroundColor: ['#f59e0b'],
                                    borderColor: ['#f59e0b'],
                                    borderWidth: 1
                                },
                            ]
                        },
                        options: {
                            layout: {
                                padding: 0
                            },
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                x: {
                                    stacked: true,
                                },
                                y: {
                                    stacked: true
                                }
                            },
                            maintainAspectRatio: false,
                        }
                    });
                }
            }
        }
    </script>
    @endpush
</div>