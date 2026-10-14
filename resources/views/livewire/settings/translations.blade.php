<div class="dashboard-main-body">
    <div class="card h-100 p-0 radius-12">
        <div class="tw-py-1.5 tw-px-3 bg-base d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <div class="d-flex align-items-center flex-wrap gap-3">
                <form class="navbar-search">
                    <input type="text" class="bg-base h-40-px w-auto" name="search" placeholder="{{ $lang->data['search_here'] ?? 'Search Here' }}" wire:model.live="search_query">
                    <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                </form>
            </div>
            @can('translation_create')
            <a href="{{route('settings.translations-create')}}" type="button" class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2">
                <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                {{$lang->data['add_translations']??'Add New Translation'}}
            </a>
            @endcan
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scroll-sm">
                <table class="table bordered-table sm-table mb-0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" class="">{{$lang->data['translation_name'] ?? 'Translation Name'}}</th>
                            <th scope="col" class="">{{$lang->data['status'] ?? 'Status'}}</th>
                            <th scope="col" class="text-center">{{$lang->data['actions'] ?? 'Actions'}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($translations)>0)
                        @foreach ($translations as $item)
                        <tr>
                            <td>{{$loop->index + 1}}</td>
                            <td class="">{{ $item->name }}</td>
                            <td class="">
                                <div class="d-flex align-items-center gap-10 ">
                                    @if ($item->is_active)
                                    <span class="badge text-sm fw-semibold text-success-600 bg-success-100 px-20 py-9 radius-4 text-white">{{$lang->data['active'] ?? 'Active'}}</span>
                                    @endif
                                    @if ($item->default)
                                    <span class="badge text-sm fw-semibold bg-primary-600 px-20 py-9 radius-4 text-white">{{$lang->data['default'] ?? 'Default'}}</span>
                                    @endif
                                    @if ($item->is_rtl)
                                    <span class="badge text-sm fw-semibold bg-light-100 px-20 py-9 radius-4 text-secondary-light">{{$lang->data['rtl'] ?? 'RTL'}}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center gap-10 justify-content-center">
                                    @can('translation_edit')
                                        <a href="{{route('settings.translations-edit',$item->id)}}" type="button" class="bg-info-100 text-info-600 bg-hover-info-200 fw-medium tw-size-8 d-flex justify-content-center align-items-center rounded-circle">
                                            <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                        </a>
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
</div>