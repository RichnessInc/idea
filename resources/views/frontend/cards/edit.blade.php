<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('كروت المعايدة - تعديل') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-white shadow-md p-2">
                <form action="{{route('frontend.cards.process.edit', ['id' => $row->id])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h2 class="text-2xl" style="color: #00aeef">بيانات الكرت الاساسية</h2>
                    <div class="grid grid-cols-12 gap-4 relative">
                        <div class="md:col-span-6 col-span-12">
                            <div class="mt-4">
                                <x-jet-label for='from' value="{{__('مرسال من')}}" />
                                <x-jet-input value="{{$row->from}}" type='text' id="from" name='from' class="block mt-1 w-full" />
                                @error('from')
                                <span class="text-red-500 mt-1">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="md:col-span-6 col-span-12">
                            <div class="mt-4">
                                <x-jet-label for='to' value="{{__('مرسال الى')}}" />
                                <x-jet-input value="{{$row->to}}" type='text' id="to" name='to' class="block mt-1 w-full" />
                                @error('to')
                                <span class="text-red-500 mt-1">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <x-jet-label for='text' value="{{__('اكتب اهداء')}}" />
                        <textarea
                            id="text" name="text" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm slug block mt-1 w-full">{{$row->text}}</textarea>
                    </div>
                    <hr>
                    <br>
                    <h2 class="text-2xl" style="color: #00aeef">تخصيص مظهر الكرت</h2>
                    <h3 class="my-3	text-lg" style="color: #00aeef">الخلفيات</h3>
                    <div class="grid grid-cols-12 gap-4">
                        @foreach($backgrounds as $background)
                            <div class="col-span-3">
                                <div class="card bg-white rounded shadow-md p-2 border-2 relative">
                                    <input type="radio" {{($row->background_id == $background->id ? 'checked' : '' )}} name="background_id" value="{{$background->id}}" style="z-index: 99999;position: absolute; top: 10px; right: 12px;">
                                    <img class="rounded" src="{{asset('uploads/'.$background->background_name)}}" style="width: 100%;height: 200px">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <h3 class="my-3	text-lg" style="color: #00aeef">الصوتيات</h3>
                    <div class="grid grid-cols-12 gap-4 mb-2">
                        @foreach($sounds as $sound)
                            <div class="col-span-3">
                                <div class="card border-2 p-2 relative">
                                    <input type="radio" name="sound_id" {{($row->sound_id == $sound->id ? 'checked' : '' )}} value="{{$sound->id}}" style="z-index: 99999;position: absolute; top: 10px; right: 12px;">
                                    <audio style="width: 100%;" controls src="{{asset('uploads/'.$sound->sound_name)}}"></audio>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <span>يمكنك رفع صوت مخصص</span>
                    <div class="mt-4">
                        <x-jet-label for='sound' value="{{__('يمكنك رفع صوت مخصص')}}" />
                        <x-jet-input type='file' id="sound" name='sound' class="slug block mt-1 w-full" accept="audio/mp3" />
                        @error('sound')
                        <span class="text-red-500 mt-1">{{$message}}</span>
                        @enderror
                    </div>
                    <h3 class="text-lg my-3	" style="color: #00aeef">الفيديوهات</h3>
                    <div class="grid grid-cols-12 gap-4 mb-2">
                        @foreach($videos as $video)
                            <div class="col-span-3">
                                <div class="card bg-white rounded  border-2 shadow-md p-2 relative">
                                    <input type="radio" name="video_id" value="{{$video->id}}"  {{($row->video_id == $video->id ? 'checked' : '')}}  style="z-index: 99999;position: absolute; top: 10px; right: 12px;">
                                    <video src="{{asset('uploads/'.$video->video_name)}}" style="height: 487px;width: 276px;" height="640" width="360" playsinline="true" controls>
                                        <source src="{{asset('uploads/'.$video->video_name)}}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <span>يمكنك رفع صورة مستقله</span>
                    <div class="mt-4">
                        <x-jet-label for='sound' value="{{__('يمكنك رفع صورة مستقله')}}" />
                        <x-jet-input type='file' id="image" name='image' class="slug block mt-1 w-full" accept="image/*" />
                        @error('image')
                        <span class="text-red-500 mt-1">{{$message}}</span>
                        @enderror
                    </div>
                    <br>
                    <x-jet-button class="main-btn" type="submit"><i class="fas fa-save"></i> تعديل </x-jet-button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
