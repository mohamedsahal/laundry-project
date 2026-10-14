<div class="dashboard-main-body">
    <div class="tw-flex tw-gap-4 lg:tw-flex-row tw-flex-col">
        <div class="p-0 card h-100 radius-12 tw-w-full">
            <div
                class="flex-wrap gap-3 px-24 py-16 card-header border-bottom bg-base d-flex align-items-center justify-content-between ">
                <div class="tw-flex tw-flex-col tw-text-sm">
                    <div class="text-lg tw-font-medium text-primary-light">
                        {{ $purchase_return->supplier->name }}
                    </div>
                    <div class="tw-flex tw-flex-col tw-mt-2">
                        <div class="">{{ $purchase_return->supplier->phone }}</div>
                        <div class="">{{ $purchase_return->supplier->email }}</div>
                        <div class="">{{ $purchase_return->supplier->address }}</div>
                        <div class="tw-mt-2">{{ $lang->data['tax'] ?? 'TAX' }}:
                            {{ $purchase_return->supplier->tax_number }}</div>
                    </div>
                </div>
                <div class="tw-flex tw-flex-col tw-text-sm tw-items-end">
                    <div class="tw-flex tw-flex-col tw-mt-2 tw-items-end">
                        <div class="text-neutral-600">
                            {{ $lang->data['invoice_number'] ?? 'Invoice Number' }} : # <span
                                class="tw-font-medium text-primary-light">{{ $invoice_number }}</span>
                        </div>
                        <div class="text-neutral-600">
                            {{ $lang->data['invoice_date'] ?? 'Invoice Date' }} : <span
                                class="tw-font-medium text-primary-light">{{ $invoice_date }}</span>
                        </div>
                        <div class="text-neutral-600">
                            {{ $lang->data['purchase_number'] ?? 'Purchase Number' }} : # <span
                                class="tw-font-medium text-primary-light">{{ $purchase_return_number }}</span>
                        </div>
                        <div class="text-neutral-600">
                            {{ $lang->data['purchase_date'] ?? 'Purchase Date' }} : <span
                                class="tw-font-medium text-primary-light">{{ $purchase_date ? $purchase_date->format('Y-m-d') : 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-24 card-body">
                <div class="table-responsive scroll-sm">
                    <table class="table mb-0 bordered-table sm-table">
                        <thead>
                            <tr>
                                <th scope="col" class="">#</th>
                                <th scope="col" class="">
                                    {{ $lang->data['purchased_items'] ?? 'Purchased Items' }}
                                </th>
                                <th scope="col" class="">
                                    {{ $lang->data['purchase_price'] ?? 'Purchase Price' }}</th>
                                <th scope="col" class="">{{ $lang->data['qty'] ?? 'QTY' }}</th>
                                <th scope="col" class=""> {{ $lang->data['tax_amount'] ?? 'Tax Amount' }}</th>
                                <th scope="col" class=""> {{ $lang->data['total'] ?? 'Total' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchase_return_details as $detail)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td class="">
                                        <p>{{ $detail->product_name }}</p>
                                        <p>{{ $detail->created_at->format('Y-m-d') }}</p>
                                    </td>
                                    <td class="">
                                        <p>{{ getCurrency() }} {{ number_format($detail->rate, 2) }}</p>
                                    </td>
                                    <td class="">
                                        <p>{{ $detail->quantity }}</p>
                                    </td>
                                    <td class="">
                                        <p>{{ getCurrency() }} {{ number_format($detail->tax_amount, 2) }}</p>
                                    </td>
                                    <td class="">
                                        <p>{{ getCurrency() }} {{ number_format($detail->total, 2) }}</p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tw-flex tw-flex-col">
                    <div class="tw-flex tw-justify-between tw-items-start tw-mt-6">
                        <div class="tw-flex tw-flex-col">
                            <div class="pb-2 text-lg tw-font-medium text-primary-light">
                                {{ $lang->data['payment_details'] ?? 'Payment Details' }}</div>
                            <div class="tw-flex tw-justify-between tw-items-center tw-w-[17rem] tw-mt-4">
                                <div class=" tw-text-sm">
                                    {{ $lang->data['sub_total'] ?? 'Sub Total' }}
                                </div>
                                <div class=" tw-text-sm">
                                    {{ getCurrency() }} {{ number_format($sub_total, 2) }}
                                </div>
                            </div>
                            <div class="tw-flex tw-justify-between tw-items-center tw-w-[17rem]">
                                <div class=" tw-text-sm">
                                    {{ $lang->data['discount'] ?? 'Discount' }}
                                </div>
                                <div class=" tw-text-sm">
                                    {{ getCurrency() }} {{ number_format($discount_total, 2) }}
                                </div>
                            </div>
                            <div class="tw-flex tw-justify-between tw-items-center tw-w-[17rem]">
                                <div class=" tw-text-sm">
                                    {{ $lang->data['tax_amount'] ?? 'Tax Amount' }}
                                </div>
                                <div class=" tw-text-sm">
                                    {{ getCurrency() }} {{ number_format($tax_amount, 2) }}
                                </div>
                            </div>
                            <div class="tw-flex tw-justify-between tw-items-center tw-w-[17rem]">
                                <div class=" tw-text-sm">
                                    {{ $lang->data['taxable_amount'] ?? 'Taxable Amount' }}
                                </div>
                                <div class=" tw-text-sm">
                                    {{ getCurrency() }} {{ number_format($taxable_amount, 2) }}
                                </div>
                            </div>
                            <div class="tw-flex tw-justify-between tw-items-center tw-w-[17rem] tw-mt-2  ">
                                <div class=" tw-font-bold tw-text-sm">
                                    {{ $lang->data['gross_total'] ?? 'Gross Total' }}
                                </div>
                                <div class="tw-font-bold tw-text-sm">
                                    {{ getCurrency() }} {{ number_format($total, 2) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="tw-mt-4">
                    <div class="tw-flex tw-items-center tw-justify-center tw-gap-2 tw-mt-4">
                        <div class="tw-w-full tw-h-[1px]  tw-from-transparent tw-to-neutral-300 tw-bg-gradient-to-r">
                        </div>
                        <div class="tw-shrink-0 tw-font-light">{{ $lang->data['powered_by'] ?? 'Powered By' }}<span
                                class="tw-font-bold">&nbsp; {{ getApplicationName() }}</span> </div>
                        <div class="tw-w-full tw-h-[1px] tw-from-transparent tw-to-neutral-300 tw-bg-gradient-to-l">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card h-100 p-0 radius-12 lg:tw-w-[24rem]  tw-w-full tw-shrink-0">
            <div class="card-body p-24">

                @can('payment_create')
                    <div class="tw-text-xl tw-font-medium tw-pt-6">{{ $lang->data['payments'] ?? 'Payments' }}</div>
                    @foreach ($purchase_return_payments as $payments)
                        <div class="tw-flex tw-items-center tw-pt-2 tw-text-sm tw-gap-4">
                            <div class=" tw-relative tw-items-center tw-flex tw-flex-col tw-translate-y-1">
                                <iconify-icon icon="tabler:target" class="menu-icon"></iconify-icon>
                                <div class="tw-top-[100%] tw-left-[6px] tw-h-6 tw-w-[2px] tw-bg-neutral-300"></div>
                            </div>
                            <div class="tw-flex tw-flex-col">
                                <div class="tw-font-medium">{{ getFormattedCurrency($payments->paid_amount) }}</div>
                                <div class="tw-text-xs tw-font-light tw-mt-1">
                                    {{ Carbon\Carbon::parse($payments->created_at)->format('d/m/Y') }} <span
                                        class="tw-font-bold">{{ getpaymentMode($payments->payment_method) }}</span></div>
                            </div>
                        </div>
                    @endforeach
                    @if ($this->balance > 0)
                        <button data-bs-toggle="modal" data-bs-target="#exampleModal" type="button" wire:click=""
                            class="btn btn-outline-success-600 radius-8 px-20 py-11 tw-mt-6 tw-w-full">{{ $lang->data['add_payment'] ?? 'Add Payment' }}</button>
                    @else
                        <button type="button" class="btn btn-outline-neutral-600 radius-8 px-20 py-11 tw-mt-6 tw-w-full"
                            disabled>{{ $lang->data['fully_paid'] ?? 'Fully Paid' }}</button>
                    @endif
                @endcan
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-md modal-dialog modal-dialog-centered">
            <div class="modal-content radius-16 bg-base">
                <div class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0">
                    <h1 class="modal-title text-md" id="exampleModalLabel">
                        {{ $lang->data['payment_details'] ?? 'Payment Details' }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form action="#">
                        <div class="row">
                            <div class="col-12">
                                <div class="">
                                    <ul>
                                        <li class="d-flex align-items-center gap-1 mb-12 tw-justify-between tw-w-full">
                                            <span
                                                class="text-md fw-semibold text-primary-light">{{ $lang->data['supplier'] ?? 'Supplier' }}
                                                :</span>
                                            <span
                                                class="text-secondary-light fw-medium">{{ $purchase_return->supplier->name }}</span>
                                        </li>
                                        <li class="d-flex align-items-center gap-1 mb-12 tw-justify-between ">
                                            <span class="text-md fw-semibold text-primary-light">
                                                {{ $lang->data['purchase_id'] ?? 'Purchase ID' }} :</span>
                                            <span
                                                class="text-secondary-light fw-medium">{{ $purchase_return_number }}</span>
                                        </li>
                                        <li class="d-flex align-items-center gap-1 mb-12 tw-justify-between">
                                            <span class="text-md fw-semibold text-primary-light">
                                                {{ $lang->data['purchase_date'] ?? 'Purchase Date' }} :</span>
                                            <span class="text-secondary-light fw-medium">{{ $invoice_date }}</span>
                                        </li>
                                        <li class="d-flex align-items-center gap-1 mb-12 tw-justify-between">
                                            <span class="text-md fw-semibold text-primary-light">
                                                {{ $lang->data['total_amount'] ?? 'Total Amount' }} :</span>
                                            <span class="text-secondary-light fw-medium">{{ getCurrency() }}
                                                {{ number_format($total, 2) }}</span>
                                        </li>
                                        <li class="d-flex align-items-center gap-1 mb-12 tw-justify-between">
                                            <span class="text-md fw-semibold text-primary-light">
                                                {{ $lang->data['paid_amount'] ?? 'Paid Amount' }} :</span>
                                            <span class="text-secondary-light fw-medium">{{ getCurrency() }}
                                                {{ number_format($last_paid_amount, 2) }}</span>
                                        </li>
                                        <li class="d-flex align-items-center gap-1 tw-justify-between">
                                            <span class="text-md fw-semibold text-primary-light">
                                                {{ $lang->data['balance'] ?? 'Balance' }} :</span>
                                            <span class="text-secondary-light fw-medium">{{ getCurrency() }}
                                                {{ number_format($total_amount - $last_paid_amount, 2) }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-12 tw-my-6">
                                <hr>
                            </div>
                            <div class="col-12 mb-20 ">
                                <label for="name"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['paid_amount'] ?? 'Paid Amount' }}
                                    <span class="text-danger">*</span></label>
                                <input type="text" class="form-control radius-8"
                                    placeholder="{{ $lang->data['enter_amount'] ?? 'Enter Amount' }}"
                                    wire:model="paid_amount">
                                @error('paid_amount')
                                    <span class="tw-text-red-500 tw-text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 mb-20 ">
                                <label for="name"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['payment_method'] ?? 'Payment Method' }}
                                    <span class="text-danger">*</span></label>
                                <select class="form-select radius-8" wire:model="payment_method">
                                    <option value="">
                                        {{ $lang->data['choose_payment_method'] ?? 'Choose Payment Method' }}
                                    </option>
                                    <option class="select-box" value="1">
                                        Sahal
                                    </option>
                                    <option class="select-box" value="2">
                                        Edahab
                                    </option>
                                    <option class="select-box" value="3">
                                        Premier Wallet
                                    </option>
                                    <option class="select-box" value="4">
                                        Mycash
                                    </option>
                                    <option class="select-box" value="5">
                                        T-plus
                                    </option>
                                </select>
                                @error('payment_method')
                                    <span class="tw-text-red-500 tw-text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12 mb-20">
                                <label for="name"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['notes'] ?? 'Notes' }}
                                </label>
                                <textarea class="form-control radius-8" placeholder="{{ $lang->data['enter_notes'] ?? 'Enter Notes' }}"
                                    wire:model="note"></textarea>
                                @error('note')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="d-flex align-items-start justify-content-end gap-3 mt-24">
                                <button data-bs-dismiss="modal" type="button"
                                    class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-40 py-11 radius-8">
                                    {{ $lang->data['cancel'] ?? 'Cancel' }}
                                </button>
                                <button type="button" wire:click.prevent="addPayment()"
                                    class="btn btn-primary border border-primary-600 text-md px-24 py-12 radius-8">
                                    {{ $lang->data['save'] ?? 'Save' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @script
        <script>
            $wire.on('reloadpage', orderId => {
                window.location.reload()
            })
        </script>
    @endscript
</div>
