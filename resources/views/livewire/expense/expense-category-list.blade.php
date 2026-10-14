<div class="dashboard-main-body">
    <div class="card h-100 p-0 radius-12">
        <div class="tw-py-1.5 tw-px-3 bg-base d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <div class="d-flex align-items-center flex-wrap gap-3">
                <form class="navbar-search">
                    <input type="text" class="bg-base h-40-px w-auto" name="search" placeholder="{{ $lang->data['search_here'] ?? 'Search Here' }}" wire:model.live="search">
                    <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                </form>
            </div>
            @can('expense_category_create')
            <button type="button" class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#exampleModal" wire:click="resetInputFields()">
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
                            <th scope="col" class=""> {{ $lang->data['expense_category'] ?? 'Expense Category' }}</th>
                            <th scope="col" class="">{{ $lang->data['status'] ?? 'Status' }}</th>
                            <th scope="col" class="text-center">{{ $lang->data['action'] ?? 'Action' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($categories)>0)
                        @foreach ($categories as $row)
                        <tr>
                            <td>{{ $loop->index + 1}}</td>
                            <td class="">{{ $row->expense_category_name }}</td>
                            <td class="">{{ getExpenseCategoryType($row->expense_category_type) }}</td>
                            <td class="text-center">
                                <div class="d-flex align-items-center gap-10 justify-content-center">
                                    @can('expense_category_edit')
                                        <button wire:click="edit({{ $row->id }})"
                                            data-bs-target="#editModal" type="button" class="bg-info-100 text-info-600 bg-hover-info-200 fw-medium tw-size-8 d-flex justify-content-center align-items-center rounded-circle" data-bs-toggle="modal" data-bs-target="#exampleModalEdit">
                                            <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                        </button>
                                    @endcan
                                    @can('expense_category_delete')
                                        <button wire:click="delete({{ $row->id }})" type="button" class="remove-item-button bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium tw-size-8 d-flex justify-content-center align-items-center rounded-circle">
                                            <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                        </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    
                        @endif
                    </tbody>
                </table>

                @if(count($categories) == 0)
                    <x-empty-item/>
                @endif
            </div>
            
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-md modal-dialog modal-dialog-centered">
            <div class="modal-content radius-16 bg-base">
                <div class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0">
                    <h1 class="modal-title text-md" id="exampleModalLabel">{{ $lang->data['add_Expense_category'] ?? 'Add Expense Category' }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form action="#">
                        <div class="row">
                            <div class="col-12 mb-20">
                                <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['category_name'] ?? 'Category Name' }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control radius-8" placeholder="{{ $lang->data['enter_category_name'] ?? 'Enter Category Name' }}" wire:model="expense_category_name">
                                @error('expense_category_name') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-12 ">
                                <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['category_type'] ?? 'Category Type' }}<span class="text-danger">*</span></label>
                                <select name="" id="" class="form-select radius-8" wire:model="expense_category_type">
                                    <option class="select-box" value="">
                                        {{ $lang->data['choose_expense_category'] ?? 'Choose Expense Category' }}
                                    </option>
                                    <option class="select-box" value="1">
                                        {{ $lang->data['asset'] ?? 'Asset' }}
                                    </option>
                                    <option class="select-box" value="2">
                                        {{ $lang->data['liability'] ?? 'Liability' }}
                                    </option>
                                </select>
                                @error('expense_category_type')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="d-flex align-items-start justify-content-end gap-3 mt-24">
                                <button type="reset" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-40 py-11 radius-8" wire:click.prevent="$dispatch('closemodal')">
                                    {{ $lang->data['cancel'] ?? 'Cancel' }}
                                </button>
                                <button type="submit" class="btn btn-primary border border-primary-600 text-md px-24 py-12 radius-8" wire:click.prevent="store">
                                    {{ $lang->data['save'] ?? 'Save' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-md modal-dialog modal-dialog-centered">
            <div class="modal-content radius-16 bg-base">
                <div class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0">
                    <h1 class="modal-title text-md" id="exampleModalLabel">{{ $lang->data['edit_expense_category'] ?? 'Edit Expense Category' }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form action="#">
                        <div class="row">
                            <div class="col-12 mb-20">
                                <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['category_name'] ?? 'Category Name' }}<span class="text-danger">*</span></label>
                                <input type="text" class="form-control radius-8" placeholder="{{ $lang->data['enter_category_name'] ?? 'Enter Category Name' }}" wire:model="expense_category_name">
                                @error('expense_category_name') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-12 ">
                                <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['category_type'] ?? 'Category Type' }}<span class="text-danger">*</span></label>
                                <select name="" id="" class="form-select radius-8" wire:model="expense_category_type">
                                    <option class="select-box" value="">
                                        {{ $lang->data['choose_expense_category'] ?? 'Choose Expense Category' }}
                                    </option>
                                    <option class="select-box" value="1">
                                        {{ $lang->data['asset'] ?? 'Asset' }}
                                    </option>
                                    <option class="select-box" value="2">
                                        {{ $lang->data['liability'] ?? 'Liability' }}
                                    </option>
                                </select>
                                @error('expense_category_type')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="d-flex align-items-start justify-content-end gap-3 mt-24">
                                <button type="reset" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-40 py-11 radius-8" wire:click.prevent="$dispatch('closemodal')">
                                    {{ $lang->data['cancel'] ?? 'Cancel' }}
                                </button>
                                <button type="submit" class="btn btn-primary border border-primary-600 text-md px-24 py-12 radius-8" wire:click.prevent="update">
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