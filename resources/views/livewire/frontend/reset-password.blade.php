<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="loginpage">
                <div class="mt-4 relative">
                    <i wire:click="showPasswordF" class="fas fa-eye" style="position: absolute; top: 37px; left: 10px; color: #006EB9FF; cursor: pointer;"></i>
                    <x-jet-label for='password' value="{{__('كلمة المرور')}}" />
                    <x-jet-input type="{{$showPassword == false ? 'password' : 'text'}}" id="password" wire:model='password' class="block mt-1 w-full" />
                    @error('password')
                    <span class="text-red-500 mt-1">{{$message}}</span>
                    @enderror
                </div>
                <div class="mt-4 relative">
                    <i wire:click="showPasswordF" class="fas fa-eye" style="position: absolute; top: 37px; left: 10px; color: #006EB9FF; cursor: pointer;"></i>
                    <x-jet-label for='conform_password' value="{{__('إعادة كلمة المرور')}}" />
                    <x-jet-input type="{{$showPassword == false ? 'password' : 'text'}}" id="conform_password" wire:model='conform_password' class="block mt-1 w-full" />
                    @error('conform_password')
                    <span class="text-red-500 mt-1">{{$message}}</span>
                    @enderror
                </div>
                <div class="mt-4">
                    <div style="justify-content: space-between;display: flex">
                        <x-jet-button wire:click='login' class="main-btn">إعادة كلمة المرور</x-jet-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
