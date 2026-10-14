<section class="auth bg-base d-flex flex-wrap">  
    <div class="auth-left d-lg-block d-none">
        <div class="d-flex align-items-center flex-column h-100 justify-content-center">
            <img src="{{asset('assets/images/login-bg.jpg')}}" class="tw-h-full object-fit-cover tw-w-full" alt="">
        </div>
    </div>
    <div class="auth-right py-32 px-24 d-flex flex-column justify-content-center tw-relative tw-inset-0 tw-items-center  "  x-data="{resetpassword : false,success:@entangle('success')}" x-transition.fade>
        <div class="max-w-464-px mx-auto w-100 tw-absolute tw-inset-0 tw-flex center tw-flex-col tw-justify-center lg:tw-px-0 tw-px-14"  x-show="resetpassword == false"  x-transition >
            <div>
                <div class="tw-w-full tw-flex tw-items-center tw-justify-center">
                    <a href="#" class="tw-mb-8 max-w-290-px ">
                        <span style="display:inline-flex;align-items:center;gap:0.75rem;"><span style="width:3.25rem;height:3.25rem;border-radius:0.75rem;background:var(--primary-600,#487fff);color:#fff;display:inline-flex;align-items:center;justify-content:center;font-size:1.75rem;font-weight:800;line-height:1;">L</span><span style="font-size:2rem;font-weight:800;letter-spacing:-0.02em;color:var(--text-primary-light,#111827);">Laundry</span></span>
                    </a>
                </div>
         
                <h4 class="mb-12">Sign In to your Account</h4>
                <p class="mb-32 text-secondary-light text-lg">Welcome back! please enter your detail</p>
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
                </div>
                <div class="mt-20">
                    <div class="d-flex justify-content-between gap-2">
                        <div class="form-check style-check d-flex align-items-center">
                            <input class="form-check-input border border-neutral-300" type="checkbox" value="" id="remeber">
                            <label class="form-check-label" for="remeber">Remember me </label>
                        </div>
                        @if($forgetpassword == 1)
                        <a href="javascript:void(0)" class="text-primary-600 fw-medium"  @click.prevent ="resetpassword = true">Forgot Password?</a>
                        @endif
                    </div>
                </div>

                <button type="submit" class="btn btn-primary text-sm btn-sm px-12 py-16 w-100 radius-12 mt-32" wire:click.prevent="login">
                     Sign In
                     <div class="spinner-border tw-size-3" role="status" wire:loading="login">
                        <span class="visually-hidden">Loading...</span>
                        </div>
                    </button>
            </form>
        </div>
        <div class="max-w-464-px mx-auto w-100  lg:tw-px-0 tw-px-14" x-show="resetpassword == true" x-transition x-cloak>
            <div class="" x-show="success==false">
                <div>
                    <div class="tw-w-full tw-flex tw-items-center tw-justify-center">
                        <a href="#" class="tw-mb-8 max-w-290-px ">
                            <span style="display:inline-flex;align-items:center;gap:0.75rem;"><span style="width:3.25rem;height:3.25rem;border-radius:0.75rem;background:var(--primary-600,#487fff);color:#fff;display:inline-flex;align-items:center;justify-content:center;font-size:1.75rem;font-weight:800;line-height:1;">L</span><span style="font-size:2rem;font-weight:800;letter-spacing:-0.02em;color:var(--text-primary-light,#111827);">Laundry</span></span>
                        </a>
                    </div>
             
                    <h4 class="mb-12">Password Reset</h4>
                    <p class="mb-32 text-secondary-light text-lg">Welcome back! please enter your detail</p>
                </div>
                <div class="text-muted mb-4">
                    <small>Enter Your Email Address</small>
                </div>
                <form role="form" class="text-start">
                    <div class="icon-field">
                        <span class="icon top-50 translate-middle-y">
                            <iconify-icon icon="mage:email"></iconify-icon>
                        </span>
                        <input type="email" class="form-control h-56-px bg-neutral-50 radius-12" placeholder="Email" wire:model="email"> 
                    </div>
                    @error('email') <span class="text-danger">{{$message}}</span>  @enderror
                    
                    @error('login_error') <span class="text-danger">{{$message}}</span>  @enderror
                    <div class="mt-20">
                        <div class="d-flex justify-content-end gap-2">
                      
                            @if($forgetpassword == 1)
                            <a href="javascript:void(0)" class="text-primary-600 fw-medium"  @click.prevent ="resetpassword = false">I Know My Password.</a>
                            @endif
                        </div>
                    </div>
                       <button type="submit" class="btn btn-primary text-sm btn-sm px-12 py-16 w-100 radius-12 mt-32" wire:click.prevent="forgotpassword">
                        Send Reset Link
                        <div class="spinner-border tw-size-3" role="status" wire:loading="forgotpassword">
                           <span class="visually-hidden">Loading...</span>
                           </div>
                       </button>
                </form>
            </div>
            <div class="" x-show="success == true">
                <div class="text-muted mb-4">
                </div>
                <form role="form" class="text-start">
                    <p class="text-center">You will receive the reset link in your mail</p>
                </form>
            </div>
        </div>
    </div>
</section>