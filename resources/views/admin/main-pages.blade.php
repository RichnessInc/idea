<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('الصفحات') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form enctype="multipart/form-data" action="{{URL::to('control-panel/main-pages/update/'.$row->slug)}}" method="POST">
                @csrf
                <div class="bg-white shadow rounded p-2">
                    <div class="mt-4">
                        <x-jet-label for='name-ed' value="{{__('الاسم')}}" />
                        <x-jet-input type='text' name="name" class="block mt-1 w-full" value="{!!$row->name!!}" />
                        @error('name')
                        <span class="text-red-500 mt-1">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mt-4">
                        <x-jet-label for='page_text' value="{{__('وصف صفحة')}}" />
                        <div class=" mb-2" >
                            <textarea class="page_text form-input rounded-md shadow-sm mt-1 block w-full" name="content" id="summernote" >{!!$row->content!!}</textarea>
                        </div>
                        @error('content')
                        <span class="text-red-500 mt-1">{{$message}}</span>
                        @enderror
                    </div>
                    <div>
                        <x-jet-button type="submit" class="ml-2 main-btn ksbtn"><i class="fas fa-save"></i> {{__(' تحديث')}}</x-jet-button>
                    </div>
                </div>
            </form>

        @push('styles')
            <!-- include libraries(jQuery, bootstrap) -->
                <!-- CSS only -->
                <!-- include libraries(jQuery, bootstrap) -->
                <link href="{{asset('files/bootstrap.min.css')}}" rel="stylesheet">
                <link href="{{asset('files/bootstrap.min.js')}}" rel="script">
                <link href="{{asset('files/jquery-3.5.1.min.js')}}" rel="script">
                <link href="{{asset('files/summernote.min.css')}}" rel="stylesheet">
                <link href="{{asset('files/summernote.min.js')}}" rel="script">
                <script defer>
                    $(document).ready(function() {
                        $('#summernote').summernote();
                    });
                </script>
            @endpush
        </div>
    </div>
</x-app-layout>
