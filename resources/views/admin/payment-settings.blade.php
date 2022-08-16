<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('الإعدادات المالية - الإعدادات') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{URL::to('control-panel/payment/settings/update')}}" method="POST">
                @csrf
                <div class="rounded overflow-hidden shadow-lg bg-white w-full">
                    <div class="px-6 py-4 w-full">
                        <div class="mt-4">
                            <x-jet-label for='pro_max_dept' value="{{__('الحد الاقصى لديون التاجر')}}" />
                            <x-jet-input type='text' id="pro_max_dept" name='pro_max_dept' class="block mt-1 w-full" value="{{$data->pro_max_dept}}"/>
                            @error('pro_max_dept')
                            <span class="text-red-500 mt-1">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <x-jet-label for='pro_max_dept' value="{{__('الحد الاقصى لديون الصانع')}}" />
                            <x-jet-input type='text' id="handmade_max_dept" name='handmade_max_dept' class="block mt-1 w-full" value="{{$data->handmade_max_dept}}"/>
                            @error('handmade_max_dept')
                            <span class="text-red-500 mt-1">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <x-jet-label for='sender_max_dept' value="{{__('الحد الاقصى لديون المندوب')}}" />
                            <x-jet-input type='text' id="sender_max_dept" name='sender_max_dept' class="block mt-1 w-full" value="{{$data->sender_max_dept}}" />
                            @error('sender_max_dept')
                            <span class="text-red-500 mt-1">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <x-jet-label for='handmade_commission' value="{{__('  عمولة الموقع من الصانع %')}}" />
                            <x-jet-input type='number' id="handmade_commission" name='handmade_commission' class="block mt-1 w-full" value="{{$data->handmade_commission}}" />
                            @error('handmade_commission')
                            <span class="text-red-500 mt-1">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <x-jet-label for='provider_commission' value="{{__('عمولة الموقع من التاجر %')}}" />
                            <x-jet-input type='number' id="provider_commission" name='provider_commission' class="block mt-1 w-full" value="{{$data->provider_commission}}" />
                            @error('provider_commission')
                            <span class="text-red-500 mt-1">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <x-jet-label for='sender_commission' value="{{__('عمولة المندوب %')}}" />
                            <x-jet-input type='number' id="sender_commission" name='sender_commission' class="block mt-1 w-full" value="{{$data->sender_commission}}" />
                            @error('sender_commission')
                            <span class="text-red-500 mt-1">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <x-jet-label for='cashback_commission' value="{{__('نسبة الكاش باك %')}}" />
                            <x-jet-input type='number' id="cashback_commission" name='cashback_commission' class="block mt-1 w-full" value="{{$data->cashback_commission}}" />
                            @error('cashback_commission')
                            <span class="text-red-500 mt-1">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <x-jet-label for='marketing_commission' value="{{__('نسبة المسوق %')}}" />
                            <x-jet-input type='number' id="marketing_commission" name='marketing_commission' class="block mt-1 w-full" value="{{$data->marketing_commission}}" />
                            @error('cashback_commission')
                            <span class="text-red-500 mt-1">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <x-jet-label for='text' value="{{__('وصف صفحة الخزنة')}}" />
                            <textarea class="page_text form-input rounded-md shadow-sm mt-1 block w-full" name="text" id="summernote" >{!!$data->text!!}</textarea>
                            @error('text')
                            <span class="text-red-500 mt-1">{{$message}}</span>
                            @enderror

                        </div>
                    </div>
                    <div class="px-6 py-4 w-full bg-gray-300">
                        <x-jet-button class="ml-2 main-btn ksbtn"><i class="fas fa-save"></i> {{__(' تحديث')}}</x-jet-button>

                    </div>
                </div>
            </form>
        </div>
    </div>
@push('styles')
    <!-- include libraries(jQuery, bootstrap) -->
        <!-- CSS only -->
        <!-- include libraries(jQuery, bootstrap) -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <!-- include summernote css/js -->
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
        <script defer>
            $(document).ready(function() {
                $('#summernote').summernote();
            });
        </script>
    @endpush
</x-app-layout>
