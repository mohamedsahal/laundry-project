<div class="dashboard-main-body">
    <div class="card h-100 p-0 radius-12">
        <div class="tw-py-1.5 tw-px-3 bg-base d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <div class="d-flex align-items-center flex-wrap gap-3">
                <form class="navbar-search">
                    <input type="text" class="bg-base h-40-px w-auto" name="search" placeholder="{{ $lang->data['search_here'] ?? 'Search Here' }}" wire:model.live="search">
                    <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                </form>
            </div>
            @can('user_create')
            <button type="button" class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addModal" wire:click="resetFields()">
                <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                {{$lang->data['add_staff']??'Add New Staff'}}
            </button>
            @endcan
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scroll-sm">
                <table class="table bordered-table sm-table mb-0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" class="">{{$lang->data['staff_name'] ?? 'Staff Name'}}</th>
                            <th scope="col" class="">{{$lang->data['role'] ?? 'Role'}}</th>
                            <th scope="col" class="">{{$lang->data['contact'] ?? 'Contact'}}</th>
                            <th scope="col" class="">{{$lang->data['status'] ?? 'Status'}}</th>
                            <th scope="col" class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($staffs)>0)
                        @foreach ($staffs as $item)
                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td class="">{{$item->name}}</td>
                            <td class="">
                                <span class="badge text-sm fw-semibold text-info-600 bg-info-100 px-20 py-9 radius-4 text-white">{{$item->role?->name ?? 'Admin'}}</span>
                            </td>
                            <td class="">
                                {{$item->phone}}
                                <p>{{$item->email}}</p>
                            </td>
                            <td>
                                <div class="form-switch switch-primary d-flex align-items-center gap-3" wire:click="toggle({{$item->id}})">
                                    <input class="form-check-input" type="checkbox" role="switch" id="switch1" @if($item->is_active == 1) checked @endif>
                                    <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="switch1"></label>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center gap-10 justify-content-center">
                                    @can('user_edit')
                                        <button type="button" wire:click="edit({{$item->id}})" class="bg-info-100 text-info-600 bg-hover-info-200 fw-medium tw-size-8 d-flex justify-content-center align-items-center rounded-circle" data-bs-toggle="modal" data-bs-target="#editModal">
                                            <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                        </button>
                                    @endcan
                                    @can('user_delete')
                                    @if(!Auth::user()->user_type == 1)
                                    <button type="button" wire:click="delete({{$item->id}})" class="remove-item-button bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium tw-size-8 d-flex justify-content-center align-items-center rounded-circle">
                                        <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                    </button>
                                    @endif
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="5" class="text-center">No records found...</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog modal-dialog-centered">
            <div class="modal-content radius-16 bg-base">
                <div class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0">
                    <h1 class="modal-title text-md" id="exampleModalLabel">{{$lang->data['add_staff']??'Add New Staff'}}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form action="#">
                        <div class="row">
                            <div class="col-6 mb-20">
                                <label for="date" class="form-label fw-semibold text-primary-light text-sm mb-8">{{$lang->data['staff_name'] ?? 'Staff Name'}} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control radius-8" id="staffName" {{$lang->data['enter_staff_name'] ??'Enter Staff Name'}}" wire:model="name">
                                @error('name') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label for="end_date" class="form-label fw-semibold text-primary-light text-sm mb-8">{{$lang->data['phone_number'] ?? 'Phone Number'}} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control radius-8" id="phoneNumber" placeholder="{{ $lang->data['enter_phone_number'] ?? 'Enter Phone Number' }}" wire:model="phone">
                                @error('phone') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label for="end_date" class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['email'] ?? 'Email' }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control radius-8" placeholder="{{ $lang->data['enter_email'] ?? 'Enter Email' }}" wire:model="email">
                                @error('email') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-6">
                                <div class="mb-20">
                                    <label for="user_role"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">
                                        {{ $lang->data['role'] ?? 'Role' }}
                                    </label>
                                    <select id="user_role" class="form-select radius-8" wire:model="user_role">
                                        @foreach ($roles as $item)
                                            <option value="{{$item->id}}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('user_role') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                            </div>
                            <div class="col-6 mb-20">
                                <label for="end_date" class="form-label fw-semibold text-primary-light text-sm mb-8">{{$lang->data['password']??'Password'}} </label>
                                <input type="password" class="form-control radius-8" placeholder="{{$lang->data['enter_a_password']??'Enter a Password'}}" wire:model="password">
                                @error('password') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            
                            <div class="col-6 ">
                                <div class="form-switch switch-primary d-flex align-items-center gap-3">
                                    <input class="form-check-input" type="checkbox" role="switch" id="switch12" checked wire:model="is_active">
                                    <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="switch12">{{$lang->data['is_active'] ?? 'Is Active'}}</label>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                                <button type="reset" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-40 py-11 radius-8" wire:click.prevent="$dispatch('closemodal')">
                                    {{ $lang->data['cancel'] ?? 'Cancel' }}
                                </button>
                                <button type="submit" class="btn btn-primary border border-primary-600 text-md px-24 py-12 radius-8" wire:click.prevent="save">
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
        <div class="modal-dialog modal-lg modal-dialog modal-dialog-centered">
            <div class="modal-content radius-16 bg-base">
                <div class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0">
                    <h1 class="modal-title text-md" id="exampleModalLabel">{{$lang->data['edit_staff']??'Edit Staff'}}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form action="#">
                        <div class="row">
                            <div class="col-6 mb-20">
                                <label for="date" class="form-label fw-semibold text-primary-light text-sm mb-8">{{$lang->data['staff_name'] ?? 'Staff Name'}} </label>
                                <input type="text" class="form-control radius-8" id="staffName" {{$lang->data['enter_staff_name'] ??'Enter Staff Name'}}" wire:model="name">
                                @error('name') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label for="end_date" class="form-label fw-semibold text-primary-light text-sm mb-8">{{$lang->data['phone_number'] ?? 'Phone Number'}} </label>
                                <input type="text" class="form-control radius-8" id="phoneNumber" placeholder="{{ $lang->data['enter_phone_number'] ?? 'Enter Phone Number' }}" wire:model="phone">
                                @error('phone') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-6">
                                <label for="end_date" class="form-label fw-semibold text-primary-light text-sm mb-8">{{ $lang->data['email'] ?? 'Email' }} </label>
                                <input type="text" class="form-control radius-8" placeholder="{{ $lang->data['enter_email'] ?? 'Enter Email' }}" wire:model="email">
                                @error('email') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-6 mb-20">
                                <label for="end_date" class="form-label fw-semibold text-primary-light text-sm mb-8">{{$lang->data['password']??'Password'}} </label>
                                <input type="password" class="form-control radius-8" placeholder="{{$lang->data['enter_a_password']??'Enter a Password'}}" wire:model="password">
                            </div>
                            <div class="col-12">
                                <div class="mb-20">
                                    <label for="user_role2"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">
                                        {{ $lang->data['role'] ?? 'Role' }}
                                    </label>
                                    <select id="user_role2" class="form-select radius-8" wire:model="user_role">
                                        @foreach ($roles as $item)
                                            <option value="{{$item->id}}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('user_role') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-switch switch-primary d-flex align-items-center gap-3">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        role="switch"
                                        id="edit"
                                        wire:model="is_active_edit"
                                        checked
                                      >
                                    <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="edit">
                                        {{$lang->data['is_active'] ?? 'Is Active'}}
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
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