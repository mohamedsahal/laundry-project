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
            @can('purchase_create')
                <a href="{{ route('inventory.purchase.manage') }}"
                    class="gap-2 text-sm btn btn-primary btn-sm radius-8 d-flex align-items-center">
                    <iconify-icon icon="ic:baseline-plus" class="text-xl icon line-height-1"></iconify-icon>
                    {{ $lang->data['add_new_purchase'] ?? 'Add New Purchase' }}
                </a>
            @endcan
        </div>
        <div class="p-0 card-body">
            <div class="table-responsive scroll-sm">
                <table class="table mb-0 bordered-table sm-table">
                    <thead>
                        <tr>
                            <th scope="col" class="">{{ $lang->data['purchase_info'] ?? 'Purchase Info' }}</th>
                            <th scope="col" class="">{{ $lang->data['supplier'] ?? 'Supplier' }}</th>
                            <th scope="col" class="">{{ $lang->data['total'] ?? 'Total' }}</th>
                            <th scope="col" class="">{{ $lang->data['created_by'] ?? 'Created By' }}</th>
                            <th scope="col" class="text-center">{{ $lang->data['action'] ?? 'Action' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchases as $item)
                            <tr>
                                <td class="">
                                    <div class="text-neutral-600">
                                        {{ $lang->data['purchase_no'] ?? 'Purchase No' }} : <span
                                            class="tw-font-medium text-primary-light">{{ $item->purchase_number }}</span>
                                    </div>
                                    <div class="text-neutral-600">
                                        {{ $lang->data['date'] ?? 'Date' }} : <span
                                            class="tw-font-medium text-primary-light">{{ $item->created_at->format('d/m/Y h:i A') }}</span>
                                    </div>
                                </td>
                                <td class="">
                                    <p>{{ $item->supplier->name }}</p>
                                    <p>{{ $item->supplier->tax_number ?? 'N/A' }}</p>
                                </td>
                                <td class="">
                                    <div class="tw-text-blue-500">{{ getCurrency() }}
                                        {{ number_format($item->total, 2) }}</div>
                                </td>
                                <td>
                                    <p>
                                    {{ $item->user->name ?? '' }}
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="gap-10 d-flex align-items-center justify-content-center">
                                        @can('purchase_view')
                                            <a href="{{ route('inventory.purchase.view', $item->id) }}" type="button"
                                                class="bg-success-100 text-success-600 bg-hover-success-200 fw-medium tw-size-8 d-flex justify-content-center align-items-center rounded-circle">
                                                <iconify-icon icon="lucide:eye" class="menu-icon"></iconify-icon>
                                            </a>
                                        @endcan
                                        @can('purchase_edit')
                                            <a href="{{ route('inventory.purchase.manage', $item->id) }}"
                                                class="bg-info-100 text-info-600 bg-hover-info-200 fw-medium tw-size-8 d-flex justify-content-center align-items-center rounded-circle"
                                                title="Edit">
                                                <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                            </a>
                                        @endcan
                                        @can('purchase_delete')
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
                @if (count($purchases) == 0)
                    <x-empty-item />
                @endif
            </div>
        </div>
    </div>
</div>
