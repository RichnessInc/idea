<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('ريشة المرح') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                    <form enctype="multipart/form-data" action="{{URL::to('control-panel/resh-page/update/')}}" method="POST">
                        @csrf
                        <div class="bg-white shadow rounded p-2">
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
