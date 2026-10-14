<div class="dashboard-main-body">
    <div class="row gy-4">
        <div class="col-lg-4">
            <div class="overflow-hidden border user-grid-card position-relative radius-16 bg-base h-100">
                <div class="pb-24 mb-24 tw-px-4 tw-mx-0 tw-flex tw-flex-col">
                    <div class=" border-bottom">
                        <div class="tw-flex tw-items-center tw-gap-4 tw-py-2">
                            <div class="tw-size-14 dark:tw-bg-white tw-bg-neutral-300 tw-rounded-full"></div>
                            <div class="tw-flex tw-flex-col">
                                <h6 class="mt-16 mb-0"> {{$supplier->name}}</h6>
                                <span class="mb-16 text-secondary-light"> {{$supplier->email}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-24 tw-gap-6 tw-flex tw-flex-col">
                        <div class="gap-12 d-flex align-items-center">
                            <div class="flex-shrink-0 w-40-px h-40-px radius-8 bg-info-50 d-flex justify-content-center align-items-center">
                                <iconify-icon icon="hugeicons:invoice-01" class="text-neutral-900 tw-text-lg"></iconify-icon>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 text-md fw-normal"> {{ $lang->data['total_purchase'] ?? 'Total Purchase' }}</h6>
                                <span class="text-sm text-secondary-light fw-normal"> {{$purchase_count}}</span>
                            </div>
                        </div>
                        <div class="gap-12 d-flex align-items-center">
                            <div class="flex-shrink-0 w-40-px h-40-px radius-8 bg-info-50 d-flex justify-content-center align-items-center">
                                <iconify-icon icon="mdi:dollar" class="text-neutral-900 tw-text-lg"></iconify-icon>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 text-md fw-normal">{{ $lang->data['purchase_total'] ?? 'Purchase Total' }}</h6>
                                <span class="text-sm text-secondary-light fw-normal">{{getFormattedCurrency($purchase_amount)}}</span>
                            </div>
                        </div>
                        <div class="gap-12 d-flex align-items-center">
                            <div class="flex-shrink-0 w-40-px h-40-px radius-8 bg-info-50 d-flex justify-content-center align-items-center">
                                <iconify-icon icon="mdi:dollar" class="text-neutral-900 tw-text-lg"></iconify-icon>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 text-md fw-normal">{{ $lang->data['total_payments'] ?? 'Total Payments' }}</h6>
                                <span class="text-sm text-secondary-light fw-normal">{{getFormattedCurrency($payment)}}</span>
                            </div>
                        </div>
                        <div class="gap-12 d-flex align-items-center">
                            <div class="flex-shrink-0 w-40-px h-40-px radius-8 bg-info-50 d-flex justify-content-center align-items-center">
                                <iconify-icon icon="mdi:dollar" class="text-neutral-900 tw-text-lg"></iconify-icon>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 text-md fw-normal">{{ $lang->data['total_balance'] ?? 'Total Balance' }}</h6>
                                <span class="text-sm text-secondary-light fw-normal">
                                    @php
                                    $balance_amount = $purchase_amount - $payment;
                                @endphp
                                @if ($balance_amount == 0)
                                    {{ getFormattedCurrency($balance_amount) }} {{ 'Cr' }}
                                @else
                                    @if ($balance_amount < 0)
                                        {{ getFormattedCurrency($balance_amount * -1) }} {{ 'Cr' }}
                                    @else
                                        {{ getFormattedCurrency($balance_amount) }} {{ 'Dr' }}
                                    @endif
                                @endif
                                </span>
                            </div>
                        </div>
                        <div class="gap-12 d-flex align-items-center">
                            <div class="flex-shrink-0 w-40-px h-40-px radius-8 bg-success-50 d-flex justify-content-center align-items-center">
                                <iconify-icon icon="solar:phone-outline" class="text-neutral-900 tw-text-lg"></iconify-icon>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 text-md fw-normal">{{ $lang->data['phone_number'] ?? 'Phone Number' }}</h6>
                                <span class="text-sm text-secondary-light fw-normal">{{getCountryCode()}} {{$supplier->phone ? $supplier->phone : '-'}}</span>
                            </div>
                        </div>
                        <div class="gap-12 d-flex align-items-center">
                            <div class="flex-shrink-0 w-40-px h-40-px radius-8 bg-success-50 d-flex justify-content-center align-items-center">
                                <iconify-icon icon="oui:email" class="text-neutral-900 tw-text-lg"></iconify-icon>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 text-md fw-normal"> {{ $lang->data['email'] ?? 'Email' }}</h6>
                                <span class="text-sm text-secondary-light fw-normal">{{$supplier->email ? $supplier->email : '-'}}</span>
                            </div>
                        </div>
                        <div class="gap-12 d-flex align-items-center">
                            <div class="flex-shrink-0 w-40-px h-40-px radius-8 bg-success-50 d-flex justify-content-center align-items-center">
                                <iconify-icon icon="tabler:tax" class="text-neutral-900 tw-text-lg"></iconify-icon>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 text-md fw-normal">{{ $lang->data['tax_number'] ?? 'Tax Number' }}</h6>
                                <span class="text-sm text-secondary-light fw-normal">{{$supplier->tax_number ? $supplier->tax_number : '-'}}</span>
                            </div>
                        </div>
                        <div class="gap-12 d-flex align-items-center">
                            <div class="flex-shrink-0 w-40-px h-40-px radius-8 bg-success-50 d-flex justify-content-center align-items-center">
                                <iconify-icon icon="entypo:address" class="text-neutral-900 tw-text-lg"></iconify-icon>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 text-md fw-normal"> {{ $lang->data['address'] ?? 'Address' }}</h6>
                                <span class="text-sm text-secondary-light fw-normal"> {{$supplier->address ? $supplier->address : '-'}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="p-24 card-body">
                    <ul class="mb-20 nav border-gradient-tab nav-pills d-inline-flex" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                          <button class="px-24 nav-link d-flex align-items-center active" id="pills-edit-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-edit-profile" type="button" role="tab" aria-controls="pills-edit-profile" aria-selected="true">
                          {{ $lang->data['invoices'] ?? 'Invoices' }}
                          </button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="px-24 nav-link d-flex align-items-center" id="pills-change-passwork-tab" data-bs-toggle="pill" data-bs-target="#pills-change-passwork" type="button" role="tab" aria-controls="pills-change-passwork" aria-selected="false" tabindex="-1">
                          {{ $lang->data['payments'] ?? 'Payments' }} 
                          </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">   
                        <livewire:customers.partials.customer-invoice :customer="$customer"/>
                        <livewire:customers.partials.customer-payments :customer="$customer"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>