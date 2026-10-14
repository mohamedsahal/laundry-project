<div class="dashboard-main-body">
    <div class="p-0 card h-100 radius-12">
        <div class="tw-py-1.5 tw-px-3 bg-base d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <div class="flex-wrap gap-3 d-flex align-items-center">
                <form class="navbar-search">
                    <input type="text" class="w-auto bg-base h-40-px" name="search"
                        placeholder="{{ $lang->data['search_here'] ?? 'Search Here' }}" wire:model.live="search">
                    <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                </form>
            </div>
            @can('purchase_return_payment_create')
                <a href="{{ route('inventory.purchase-return.manage') }}"
                    class="gap-2 text-sm btn btn-primary btn-sm radius-8 d-flex align-items-center">
                    <iconify-icon icon="ic:baseline-plus" class="text-xl icon line-height-1"></iconify-icon>
                    {{ $lang->data['add_new_purchase_return'] ?? 'Add New Purchase Return' }}
                </a>
            @endcan
        </div>
        <div class="p-0 card-body">
            <div class="table-responsive scroll-sm">
                <table class="table mb-0 bordered-table sm-table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" class="">{{ $lang->data['purchase_info'] ?? 'Purchase Info' }}</th>
                            <th scope="col" class="">{{ $lang->data['supplier'] ?? 'Supplier' }}</th>
                            <th scope="col" class="">{{ $lang->data['total'] ?? 'Total' }}</th>
                            <th scope="col" class="">{{ $lang->data['status'] ?? 'Status' }}</th>
                            <th scope="col" class="">{{ $lang->data['payment'] ?? 'Payment' }}</th>
                            <th scope="col" class="">{{ $lang->data['created_by'] ?? 'Created By' }}
                            </th>
                            <th scope="col" class="text-center">{{ $lang->data['action'] ?? 'Action' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchase_returns as $item)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td class="">
                                   <div class="text-neutral-600">
                                        {{ $lang->data['purchase_return_no'] ?? 'Purchase Return No' }} : <span
                                            class="tw-font-medium text-primary-light">{{ $item->purchase_return_number }}</span>
                                    </div>
                                    <div class="text-neutral-600">
                                        {{ $lang->data['date'] ?? 'Date' }} : <span
                                            class="tw-font-medium text-primary-light">{{ $item->created_at->format('d/m/Y h:i A') }}</span>
                                    </div>

                                </td>
                                <td class="">
                                    <p>{{ $item->supplier_name }}</p>
                                    <p>{{ $item->supplier->tax_number ?? 'N/A' }}</p>
                                </td>
                                <td class="">
                                    {{ getCurrency() }} {{ number_format($item->total, 2) }}
                                </td>
                                <td>
                                    @if ($item->total == $item->purchase_payments->sum('paid_amount'))
                                        <div
                                            class="px-20 text-white badge fw-semibold text-neutral-600 bg-neutral-200 py-9 radius-4">
                                            Completed</div>
                                    @else
                                        <div
                                            class="px-20 text-white badge fw-semibold text-neutral-600 bg-neutral-200 py-9 radius-4">
                                            Pending</div>
                                    @endif
                                </td>
                                <td>
                                    <div>{{ $lang->data['total_amount'] ?? 'Total Amount' }} : <span
                                            class="tw-font-medium text-primary-light">{{ getCurrency() }}
                                            {{ number_format($item->total, 2) }}</span>
                                    </div>
                                    <div>{{ $lang->data['paid_amount'] ?? 'Paid Amount' }} : <span
                                            class="tw-font-medium text-primary-light">
                                            {{ getCurrency() }}
                                            {{ number_format($item->purchase_payments->sum('paid_amount'), 2) }}</span>
                                        @if ($item->total == $item->purchase_payments->sum('paid_amount'))
                                            <div class="tw-mt-1">
                                                <button type="button" disabled
                                                    class="btn rounded-pill btn-neutral-300 text-neutral-600 radius-8 tw-text-xs tw-py-1 tw-px-2 ">{{ $lang->data['fully_paid'] ?? 'Fully Paid' }}</button>
                                            </div>
                                        @else
                                            @can('purchase_return_payment_create')
                                                <div class="tw-mt-1">
                                                    <button type="button"
                                                        class="btn rounded-pill btn-success-100 text-success-600 radius-8 tw-text-xs tw-py-1 tw-px-2 "
                                                        data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                        wire:click="payment({{ $item->id }})">{{ $lang->data['add_payment'] ?? 'Add Payment' }}</button>
                                                </div>
                                            @endcan
                                        @endif

                                    </div>
                                </td>
                                <td class="">
                                    <p>
                                        {{ $item->user->name ?? '' }}
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="gap-10 d-flex align-items-center justify-content-center">
                                        @can('purchase_return_payment_list')
                                            <a href="{{ route('inventory.purchase-return.view', $item->id) }}"
                                                type="button"
                                                class="bg-success-100 text-success-600 bg-hover-success-200 fw-medium tw-size-8 d-flex justify-content-center align-items-center rounded-circle">
                                                <iconify-icon icon="lucide:eye" class="menu-icon"></iconify-icon>
                                            </a>
                                        @endcan
                                        @can('purchase_return_payment_edit')
                                            <a href="{{ route('inventory.purchase-return.manage', $item->id) }}"
                                                class="bg-info-100 text-info-600 bg-hover-info-200 fw-medium tw-size-8 d-flex justify-content-center align-items-center rounded-circle"
                                                title="Edit">
                                                <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                            </a>
                                        @endcan
                                        @can('purchase_return_payment_delete')
                                            <a href="#" wire:click="delete({{ $item->id }})" type="button"
                                                class="remove-item-button bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium tw-size-8 d-flex justify-content-center align-items-center rounded-circle">
                                                <iconify-icon icon="fluent:delete-24-regular"
                                                    class="menu-icon"></iconify-icon>
                                            </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if (count($purchase_returns) == 0)
                    <x-empty-item />
                @endif
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content radius-16 bg-base">
                <div class="px-24 py-16 border modal-header border-top-0 border-start-0 border-end-0">
                    <h1 class="modal-title text-md" id="exampleModalLabel">
                        {{ $lang->data['payment_details'] ?? 'Payment Details' }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- @if ($order) --}}
                <div class="p-24 modal-body">
                    <form action="#">
                        <div class="row">
                            <div class="col-12">
                                <div class="">
                                    <ul>
                                        <li class="gap-1 mb-12 d-flex align-items-center tw-justify-between tw-w-full">
                                            <span
                                                class="text-md fw-semibold text-primary-light">{{ $lang->data['supplier'] ?? 'Supplier' }}
                                                :</span>
                                            <span class="text-secondary-light fw-medium">{{ $supplier_name }}</span>
                                        </li>
                                        <li class="gap-1 mb-12 d-flex align-items-center tw-justify-between ">
                                            <span class="text-md fw-semibold text-primary-light">
                                                {{ $lang->data['purchase_id'] ?? 'Purchase ID' }} :</span>
                                            <span class="text-secondary-light fw-medium">{{ $purchase_number }}</span>
                                        </li>
                                        <li class="gap-1 mb-12 d-flex align-items-center tw-justify-between">
                                            <span class="text-md fw-semibold text-primary-light">
                                                {{ $lang->data['purchase_date'] ?? 'Purchase Date' }} :</span>
                                            <span class="text-secondary-light fw-medium">{{ $created_at }}</span>
                                        </li>
                                        <li class="gap-1 mb-12 d-flex align-items-center tw-justify-between">
                                            <span class="text-md fw-semibold text-primary-light">
                                                {{ $lang->data['total_amount'] ?? 'Total Amount' }} :</span>
                                            <span class="text-secondary-light fw-medium">{{ getCurrency() }}
                                                {{ number_format($total_amount, 2) }}</span>
                                        </li>
                                        <li class="gap-1 mb-12 d-flex align-items-center tw-justify-between">
                                            <span class="text-md fw-semibold text-primary-light">
                                                {{ $lang->data['paid_amount'] ?? 'Paid Amount' }} :</span>
                                            <span class="text-secondary-light fw-medium">{{ getCurrency() }}
                                                {{ number_format($last_paid_amount, 2) }}</span>
                                        </li>
                                        <li class="gap-1 d-flex align-items-center tw-justify-between">
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
                            <div class="mb-20 col-12 ">
                                <label for="name"
                                    class="mb-8 text-sm form-label fw-semibold text-primary-light">{{ $lang->data['paid_amount'] ?? 'Paid Amount' }}
                                    <span class="text-danger">*</span></label>
                                <input type="text" class="form-control radius-8"
                                    placeholder="{{ $lang->data['enter_amount'] ?? 'Enter Amount' }}"
                                    wire:model="paid_amount">
                                @error('paid_amount')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-20 col-12 ">
                                <label for="name"
                                    class="mb-8 text-sm form-label fw-semibold text-primary-light">{{ $lang->data['payment_type'] ?? 'Payment Type' }}
                                    <span class="text-danger">*</span></label>
                                <select  class="form-select radius-8" wire:model="payment_method">
                                        <option value="">
                                            {{ $lang->data['choose_payment_type'] ?? 'Choose Payment Type' }}
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
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-20 col-12">
                                <label for="name"
                                    class="mb-8 text-sm form-label fw-semibold text-primary-light">{{ $lang->data['notes'] ?? 'Notes' }}
                                </label>
                                <textarea class="form-control radius-8" placeholder="{{ $lang->data['enter_notes'] ?? 'Enter Notes' }}"
                                    wire:model="note"></textarea>
                                @error('note')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="gap-3 mt-24 d-flex align-items-start justify-content-end">
                                <button data-bs-dismiss="modal" type="button"
                                    class="px-40 border border-danger-600 bg-hover-danger-200 text-danger-600 text-md py-11 radius-8">
                                    {{ $lang->data['cancel'] ?? 'Cancel' }}
                                </button>
                                <button type="button" wire:click.prevent="addPayment()"
                                    class="px-24 py-12 border btn btn-primary border-primary-600 text-md radius-8">
                                    {{ $lang->data['save'] ?? 'Save' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                {{-- @endif --}}
            </div>
        </div>
    </div>
</div>
