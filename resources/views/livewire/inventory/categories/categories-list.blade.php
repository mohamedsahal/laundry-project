<div class="dashboard-main-body">
    <div class="card h-100 p-0 radius-12">
        <div class="tw-py-1.5 tw-px-3 bg-base d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <div class="d-flex align-items-center flex-wrap gap-3">
                <form class="navbar-search">
                    <input type="text" class="bg-base h-40-px w-auto" name="search"
                        placeholder="{{ $lang->data['search_here'] ?? 'Search Here' }}" wire:model.live="search">
                    <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                </form>
            </div>
            @can('customer_create')
                <button type="button" class="btn btn-primary text-sm btn-sm radius-8 d-flex align-items-center gap-2"
                    data-bs-toggle="modal" data-bs-target="#exampleModal" wire:click="resetInputFields()">
                    <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                    {{ $lang->data['add_new_category'] ?? 'Add New Category' }}
                </button>
            @endcan
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scroll-sm">
                <table class="table bordered-table sm-table mb-0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" class="">{{ $lang->data['name'] ?? ' Name' }}</th>
                            <th scope="col" class="">{{ $lang->data['status'] ?? ' Status' }}</th>
                            <th scope="col" class="text-center">{{ $lang->data['action'] ?? 'Action' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $item)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td class="">{{ $item->name }}</td>
                                <td>
                                    @if ($item->is_active == 1)
                                        <span
                                            class=" text-sm fw-semibold text-success-600 bg-success-100 tw-px-2 tw-py-0.5 tw-rounded-lg text-white">{{ $lang->data['active'] ?? 'Active' }}</span>
                                    @else
                                        <span
                                            class=" text-sm fw-semibold text-danger-600 tw-bg-red-100 tw-px-2 tw-py-0.5 tw-rounded-lg text-white">{{ $lang->data['inactive'] ?? 'InActive' }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center gap-10 justify-content-center">
                                        @can('customer_edit')
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#editModal"
                                                wire:click="edit({{ $item->id }})"
                                                class="bg-info-100 text-info-600 bg-hover-info-200 fw-medium tw-size-8 d-flex justify-content-center align-items-center rounded-circle"
                                                data-bs-toggle="modal" data-bs-target="#exampleModalEdit">
                                                <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                            </button>
                                        @endcan
                                        @can('customer_delete')
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
            </div>
            @if (count($categories) == 0)
                <x-empty-item />
            @endif
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-md modal-dialog modal-dialog-centered">
            <div class="modal-content radius-16 bg-base">
                <div class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0">
                    <h1 class="modal-title text-md" id="exampleModalLabel">
                        {{ $lang->data['add_new_category'] ?? 'Add New Category' }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form action="#">
                        <div class="row">
                            <div class="col-12 mb-20">
                                <label for="name"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['name'] ?? ' Name' }}
                                    <span class="text-danger">*</span></label>
                                <input type="text" class="form-control radius-8"
                                    placeholder="{{ $lang->data['enter_category_name'] ?? 'Enter Category Name' }}"
                                    wire:model="name">
                                @error('name')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 ">
                                <div class="form-switch switch-primary d-flex align-items-center gap-3">
                                    <input class="form-check-input" type="checkbox" role="switch" id="switch1"
                                        checked="" wire:model="is_active">
                                    <label class="form-check-label line-height-1 fw-medium text-secondary-light"
                                        for="switch1">{{ $lang->data['is_active'] ?? 'Is Active' }} ?</label>
                                </div>
                            </div>
                            <div class="d-flex align-items-start justify-content-end gap-3 mt-24">
                                <button type="reset"
                                    class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-40 py-11 radius-8"
                                    wire:click.prevent="$dispatch('closemodal')">
                                    {{ $lang->data['cancel'] ?? 'Cancel' }}
                                </button>
                                <button type="submit"
                                    class="btn btn-primary border border-primary-600 text-md px-24 py-12 radius-8"
                                    wire:click.prevent="save">
                                    {{ $lang->data['save'] ?? 'Save' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-md modal-dialog modal-dialog-centered">
            <div class="modal-content radius-16 bg-base">
                <div class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0">
                    <h1 class="modal-title text-md" id="exampleModalLabel">
                        {{ $lang->data['edit_category'] ?? 'Edit Category' }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form action="#">
                        <div class="row">
                            <div class="col-12 mb-20">
                                <label for="name"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['name'] ?? ' Name' }}
                                    <span class="text-danger">*</span></label>
                                <input type="text" class="form-control radius-8"
                                    placeholder="{{ $lang->data['enter_category_name'] ?? 'Enter Category Name' }}"
                                    wire:model="name">
                                @error('name')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 ">
                                <div class="form-switch switch-primary d-flex align-items-center gap-3">
                                    <input class="form-check-input" type="checkbox" role="switch" id="switch1"
                                        checked="" wire:model="is_active">
                                    <label class="form-check-label line-height-1 fw-medium text-secondary-light"
                                        for="switch1">{{ $lang->data['is_active'] ?? 'Is Active' }} ?</label>
                                </div>
                            </div>
                            <div class="d-flex align-items-start justify-content-end gap-3 mt-24">
                                <button type="reset"
                                    class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-40 py-11 radius-8"
                                    wire:click.prevent="$dispatch('closemodal')">
                                    {{ $lang->data['cancel'] ?? 'Cancel' }}
                                </button>
                                <button type="submit"
                                    class="btn btn-primary border border-primary-600 text-md px-24 py-12 radius-8"
                                    wire:click.prevent="update">
                                    {{ $lang->data['save'] ?? 'Save' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
