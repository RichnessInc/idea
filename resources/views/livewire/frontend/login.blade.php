<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="loginpage">
                <div class="mt-4">
                    <x-jet-label for='email' value="{{__('البريد الإلكتروني')}}" />
                    <x-jet-input type='email' id="email" wire:model='email' class="block mt-1 w-full" />
                    @error('email')
                    <span class="text-red-500 mt-1">{{$message}}</span>
                    @enderror
                </div>
                <div class="mt-4 relative">
                    <i wire:click="showPasswordF" class="fas fa-eye" style="position: absolute; top: 37px; left: 10px; color: #006EB9FF; cursor: pointer;"></i>
                    <x-jet-label for='password' value="{{__('كلمة المرور')}}" />
                    <x-jet-input type="{{$showPassword == false ? 'password' : 'text'}}" id="password" wire:model='password' class="block mt-1 w-full" />
                    @error('password')
                    <span class="text-red-500 mt-1">{{$message}}</span>
                    @enderror
                </div>
                <div class="mt-4">
                   <div style="justify-content: space-between;display: flex">
                       <x-jet-button wire:click='login' class="main-btn"><i class="fas fa-sign-in-alt"></i> دخول</x-jet-button>
                       <p><input type="checkbox" wire:model="remember" value="true"> تذكرني</p>
                       <a wire:click='forget_password' style="cursor: pointer">فقد كلمة المرور</a>
                   </div>
                </div>
            </div>
        </div>
    </div>
    <x-jet-dialog-modal wire:model="forget_password_visible">
        <x-slot name="title">{{__('إعادة كلمة السر')}}</x-slot>
        <x-slot name="content">
            <div class="mt-4">
                <x-jet-label for='email' value="{{__('البريد الإلكتروني')}}" />
                <x-jet-input type='email' id="email" wire:model='email' class="block mt-1 w-full" />
                @error('email')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-button wire:click='forget_password_fun' class="ml-2 main-btn"><i class="fas fa-paper-plane"></i> {{__('إعادة كلمة السر')}}</x-jet-button>
            <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
