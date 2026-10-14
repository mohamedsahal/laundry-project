<div class="dashboard-main-body">
    <div class="card h-100 p-0 radius-12 overflow-hidden">
        <div class="card-header">
            <h5 class="card-title mb-0">{{$lang->data['edit_translations'] ?? 'Edit Translations'}} </h5>
        </div>
        <div class="card-body ">
            <div class="row">
                <div class="col-sm-6">
                    <div class="mb-20">
                        <label for="application_name" class="form-label fw-semibold text-primary-light text-sm mb-8">
                            {{$lang->data['language_name']??"Language Name"}} <span
                                class="text-danger">*</span>
                        </label>
                        <input type="text" required autofocus class="form-control radius-8" id="application_name" placeholder="{{$lang->data['enter_language_name']??'Enter Language Name'}}" wire:model="name">
                        @error('name') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="d-flex align-items-end tw-pb-[22px] tw-h-full flex-wrap gap-28">
                        <div class="form-switch switch-primary d-flex align-items-center gap-3">
                            <input class="form-check-input" type="checkbox" id="switch1" wire:model="default">
                            <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="switch1">{{$lang->data['default']??'Default'}}</label>
                        </div>  
                        <div class="form-switch switch-primary d-flex align-items-center gap-3">
                            <input class="form-check-input" type="checkbox"  id="switch2" wire:model="is_rtl">
                            <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="switch2">{{$lang->data['rtl']??'RTL'}}</label>
                        </div>  
                    </div>
                </div>
                @foreach(config('global.translation.section') as $value)
                <div class="col-12 tw-flex tw-flex-col tw-gap-2">
                    <hr>
                    <div class=" mt-4">
                        <span class=" text-lg mx-2 text-uppercase mb-2">{{$value['name']}}</span>
                    </div>
                    @foreach($value['values'] as $key => $default)
                        <div class="form-group mx-2">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8 " for="example3cols1Input">{{ucwords(str_replace('_', ' ', $key))}}</label>
                            <input type="text" class="form-control radius-8" id="example3cols1Input" wire:model="data.{{$key}}" >
                        </div>
                    @endforeach
                </div>
                @endforeach
                <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                    <button type="reset"
                        class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-40 py-11 radius-8" wire:click="initialData">
                        {{$lang->data['reset']??'Reset'}}
                    </button>
                    <button type="submit"
                        class="btn btn-primary border border-primary-600 text-md px-24 py-12 radius-8"wire:click.prevent="save">{{$lang->data['save']??'Save'}}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>