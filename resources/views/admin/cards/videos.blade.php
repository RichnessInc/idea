<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('كروت معايدة - الفيديوهات') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <form method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-4">
                        <x-jet-label for='image' value="{{__('الفيديو')}}" />
                        <x-jet-input type='file' id="image"  name="audio" class="block mt-1 w-full" />
                        @error('audio')
                        <span class="text-red-500 mt-1">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <x-jet-button type="submit" class="ml-2 main-btn"><i class="fas fa-plus"></i> {{__(' اضافة')}}</x-jet-button>
                    </div>
                </form>
                <br>
                <div class="grid grid-cols-12 gap-4">
                    @foreach($rows as $row)
                        <div class="col-span-3">
                            <div class="card bg-white rounded shadow-md p-2">
                                <video src="{{asset('uploads/'.$row->video_name)}}" style="height: 487px;width: 276px;" height="640" width="360" playsinline="true" controls>
                                    <source src="{{asset('uploads/'.$row->video_name)}}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                @if (Auth::user()->role == 1)
                                    <form method="POST" action="{{URL::to('control-panel/videos/'.$row->id)}}">
                                        @csrf
                                        @method('DELETE')
                                        <x-jet-danger-button type="submit" class="mt-1 w-full"><i class="mr-2 fas fa-trash-alt"></i> {{__(' حذف')}}</x-jet-danger-button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
