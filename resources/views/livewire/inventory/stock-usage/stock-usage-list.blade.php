<div class="dashboard-main-body">
    <div class="card h-100 p-0 radius-12">
        <div class="tw-py-1.5 tw-px-3 bg-base d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <div class="d-flex align-items-end flex-wrap gap-3">
                <form class="navbar-search">
                    <input type="text" class="bg-base h-40-px w-auto" name="search" placeholder="{{ $lang->data['search_here'] ?? 'Search Here' }}" wire:model.live="search">
                    <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                </form>
                <div class="d-flex gap-1 tw-flex-col">
                    <span class="fw-medium">{{ $lang->data['start_date'] ?? 'Start Date' }}</span>
                    <input type="date" class="form-control bg-base h-40-px w-auto" wire:model.live="from_date">
                </div>
                <div class="d-flex gap-1 tw-flex-col">
                    <span class="fw-medium">{{ $lang->data['end_date'] ?? 'End Date' }}</span>
                    <input type="date" class="form-control bg-base h-40-px w-auto" wire:model.live="to_date">
                </div>
            </div>

            @can('inventory_create')
            <button type="button" class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#exampleModal" wire:click="resetInputFields()">
                <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                {{ $lang->data['add_stock_usage'] ?? 'Add Stock Usage' }}
            </button>
            @endcan
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scroll-sm">
                <table class="table bordered-table sm-table mb-0">
                    <thead>
                        <tr>
                            <th scope="col">{{ $lang->data['date'] ?? 'Date' }}</th>
                            <th scope="col">{{ $lang->data['product'] ?? 'Product' }}</th>
                            <th scope="col">{{ $lang->data['quantity_used'] ?? 'Quantity Used' }}</th>
                            <th scope="col">{{ $lang->data['unit_cost'] ?? 'Unit Cost' }}</th>
                            <th scope="col">{{ $lang->data['total_cost'] ?? 'Total Cost' }}</th>
                            <th scope="col">{{ $lang->data['notes'] ?? 'Notes' }}</th>
                            <th scope="col">{{ $lang->data['created_by'] ?? 'Created By' }}</th>
                            <th scope="col" class="text-center">{{ $lang->data['action'] ?? 'Action' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usages as $row)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($row->usage_date)->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge text-sm fw-semibold text-info-600 bg-info-100 px-20 py-9 radius-4">
                                    {{ $row->product->name ?? '' }}
                                </span>
                            </td>
                            <td>{{ $row->quantity + 0 }} {{ $row->product->unit->short_form ?? '' }}</td>
                            <td>{{ getFormattedCurrency($row->unit_cost) }}</td>
                            <td class="text-danger-600 fw-semibold">{{ getFormattedCurrency($row->total_cost) }}</td>
                            <td>{{ $row->note }}</td>
                            <td>{{ $row->user->name ?? '' }}</td>
                            <td class="text-center">
                                <div class="d-flex align-items-center gap-10 justify-content-center">
                                    @can('inventory_edit')
                                    <button type="button" class="bg-info-100 text-info-600 bg-hover-info-200 fw-medium tw-size-8 d-flex justify-content-center align-items-center rounded-circle" data-bs-toggle="modal" data-bs-target="#editModal" wire:click="edit({{ $row->id }})">
                                        <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                    </button>
                                    @endcan
                                    @can('inventory_delete')
                                    <button type="button" class="remove-item-button bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium tw-size-8 d-flex justify-content-center align-items-center rounded-circle" wire:click="delete({{ $row->id }})" wire:confirm="{{ $lang->data['are_you_sure'] ?? 'Are you sure?' }}">
                                        <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                    </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if (count($usages) == 0)
                    <x-empty-item/>
                @endif
            </div>
            <div class="tw-flex tw-items-center tw-justify-between tw-w-full tw-p-2 tw-gap-2">
                <div class="tw-flex tw-items-center tw-gap-4">
                    <div class="">{{ $lang->data['total_entries'] ?? 'Total Entries' }} : <span class="tw-font-bold">{{ count($usages) }}</span></div>
                    <div class="">{{ $lang->data['total_material_cost'] ?? 'Total Material Cost' }} : <span class="tw-font-bold text-danger-600">{{ getFormattedCurrency($usages->sum('total_cost')) }}</span></div>
                </div>
            </div>
        </div>
    </div>

    @foreach (['exampleModal' => 'store', 'editModal' => 'update'] as $modalId => $action)
    <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog modal-dialog-centered">
            <div class="modal-content radius-16 bg-base">
                <div class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0">
                    <h1 class="modal-title text-md" id="{{ $modalId }}Label">
                        @if ($action == 'store')
                            {{ $lang->data['add_stock_usage'] ?? 'Add Stock Usage' }}
                        @else
                            {{ $lang->data['edit_stock_usage'] ?? 'Edit Stock Usage' }}
                        @endif
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form action="#">
                        <div class="row">
                            <div class="col-6 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['date'] ?? 'Date' }} <span class="text-danger">*</span></label>
                                <input type="date" class="form-control radius-8" wire:model="usage_date">
                                @error('usage_date')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-6 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['product'] ?? 'Product' }} <span class="text-danger">*</span></label>
                                <select class="form-select radius-8" wire:model.live="product_id">
                                    <option value="">{{ $lang->data['choose_product'] ?? 'Choose Product' }}</option>
                                    @foreach ($products as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-6 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['quantity_used'] ?? 'Quantity Used' }} <span class="text-danger">*</span></label>
                                <input type="number" step="any" min="0" class="form-control radius-8" placeholder="{{ $lang->data['enter_quantity'] ?? 'Enter Quantity' }}" wire:model="quantity">
                                @error('quantity')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-6 mb-20">
                                @if ($product_id)
                                    @php $selected = $products->firstWhere('id', $product_id); @endphp
                                    <label class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['available_stock'] ?? 'Available Stock' }}</label>
                                    <div class="d-flex align-items-center gap-3 tw-h-[42px]">
                                        <span class="badge text-sm fw-semibold text-success-600 bg-success-100 px-20 py-9 radius-4">
                                            {{ $this->availableStock() + 0 }} {{ $selected->unit->short_form ?? '' }}
                                        </span>
                                        <span class="text-secondary-light text-sm">
                                            {{ $lang->data['cost_per_unit'] ?? 'Cost per unit' }}: {{ getFormattedCurrency($selected ? $selected->averageCost() : 0) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['notes'] ?? 'Notes' }}</label>
                                <textarea class="form-control radius-8" placeholder="{{ $lang->data['enter_notes'] ?? 'Enter Notes' }}" wire:model="note"></textarea>
                            </div>
                            <div class="d-flex align-items-start justify-content-center gap-3 mt-24">
                                <button type="reset" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-40 py-11 radius-8" wire:click.prevent="$dispatch('closemodal')">
                                    {{ $lang->data['cancel'] ?? 'Cancel' }}
                                </button>
                                <button type="submit" class="btn btn-primary border border-primary-600 text-md px-24 py-12 radius-8" wire:click.prevent="{{ $action }}">
                                    {{ $lang->data['save'] ?? 'Save' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
