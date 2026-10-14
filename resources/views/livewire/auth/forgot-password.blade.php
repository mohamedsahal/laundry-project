<section class="auth bg-base d-flex flex-wrap">  
    <div class="auth-left d-lg-block d-none">
        <div class="d-flex align-items-center flex-column h-100 justify-content-center">
            <img src="{{asset('assets/images/login-bg.jpg')}}" class="tw-h-full object-fit-cover tw-w-full" alt="">
        </div>
    </div>
    <div class="auth-right py-32 px-24 d-flex flex-column justify-content-center tw-relative tw-inset-0 tw-items-center lg:tw-px-0 tw-px-14"  >
        <div class="max-w-464-px mx-auto w-100 tw-absolute tw-inset-0 tw-flex center tw-flex-col tw-justify-center"  >
            <div>
                <div class="tw-w-full tw-flex tw-items-center tw-justify-center">
                    <a href="#" class="tw-mb-8 max-w-290-px ">
                        <span style="display:inline-flex;align-items:center;gap:0.75rem;"><span style="width:3.25rem;height:3.25rem;border-radius:0.75rem;background:var(--primary-600,#487fff);color:#fff;display:inline-flex;align-items:center;justify-content:center;font-size:1.75rem;font-weight:800;line-height:1;">L</span><span style="font-size:2rem;font-weight:800;letter-spacing:-0.02em;color:var(--text-primary-light,#111827);">Laundry</span></span>
                    </a>
                </div>
         
                <h4 class="mb-12">Reset Password</h4>
                <p class="mb-32 text-secondary-light text-lg">Please enter your new password</p>
            </div>
            <form action="#">
                <div class="icon-field">
                    <span class="icon top-50 translate-middle-y">
                        <iconify-icon icon="mage:email"></iconify-icon>
                    </span>
                    <input type="email" class="form-control h-56-px bg-neutral-50 radius-12" placeholder="Email" wire:model="email"> 
                </div>
                @error('email') <span class="text-danger">{{$message}}</span>  @enderror

                


            
                <div class="position-relative mt-16">
                    <div class="icon-field">
                        <span class="icon top-50 translate-middle-y">
                            <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                        </span> 
                        <input type="password" class="form-control h-56-px bg-neutral-50 radius-12" id="your-password" placeholder="Password" wire:model="password">
                    </div>
                    @error('password') <span class="text-danger">{{$message}}</span>  @enderror
                    @error('login_error') <span class="text-danger">{{$message}}</span>  @enderror
                    <span class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light" data-toggle="#your-password"></span>
                </div>
                <div class="position-relative mt-16">
                    <div class="icon-field">
                        <span class="icon top-50 translate-middle-y">
                            <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                        </span> 
                        <input type="password" class="form-control h-56-px bg-neutral-50 radius-12" id="mew-password" placeholder="Confirm Password" wire:model="password">
                    </div>
                    @error('password_confirm') <span class="text-danger">{{$message}}</span>  @enderror
                    @error('login_error') <span class="text-danger">{{$message}}</span>  @enderror
                    <span class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light" data-toggle="#mew-password"></span>
                </div>
               

                <button type="submit" class="btn btn-primary text-sm btn-sm px-12 py-16 w-100 radius-12 mt-32" wire:click.prevent="login">
                    Change Password And Login
                     <div class="spinner-border tw-size-3" role="status" wire:loading="login">
                        <span class="visually-hidden">Loading...</span>
                        </div>
                </button>
            </form>
        </div>
     
    </div>
</section>