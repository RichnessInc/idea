<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('كروت المعايدة - اضافة') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-white shadow-md p-2">
                <form action="{{route('frontend.cards.process.create')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h2 class="text-2xl" style="color: #00aeef">بيانات الكرت الاساسية</h2>
                    <div class="grid grid-cols-12 gap-4 relative">
                        <div class="md:col-span-6 col-span-12">
                            <div class="mt-4">
                                <x-jet-label for='from' value="{{__('مرسال من')}}" />
                                <x-jet-input type='text' id="from" name='from' class="block mt-1 w-full" />
                                @error('from')
                                <span class="text-red-500 mt-1">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="md:col-span-6 col-span-12">
                            <div class="mt-4">
                                <x-jet-label for='from' value="{{__('مرسال الى')}}" />
                                <x-jet-input type='text' id="to" name='to' class="block mt-1 w-full" />
                                @error('to')
                                <span class="text-red-500 mt-1">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <x-jet-label for='slug' value="{{__('اكتب اسم المرسل إليه بالنجليزية فقط')}}" />
                        <x-jet-input type='text' id="slug" name='slug' class="slug block mt-1 w-full" />
                        @error('slug')
                        <span class="text-red-500 mt-1">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mt-4">
                        <x-jet-label for='text' value="{{__('اكتب اهداء')}}" />
                        <textarea id="text" name="text" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm slug block mt-1 w-full"></textarea>
                    </div>
                    <hr>
                    <br>
                    <h2 class="text-2xl" style="color: #00aeef">تخصيص مظهر الكرت</h2>
                    <h3 class="my-3	text-lg" style="color: #00aeef">الخلفيات</h3>
                    <div class="grid grid-cols-12 gap-4">
                        @foreach($backgrounds as $row)
                            <div class="lg:col-span-3 col-span-6">
                                <div class="card bg-white rounded shadow-md p-2 border-2 relative">
                                    <input type="radio" name="background_id" value="{{$row->id}}" style="z-index: 99999;position: absolute; top: 10px; right: 12px;">
                                    <img class="rounded" src="{{asset('uploads/'.$row->background_name)}}" style="width: 100%;height: 200px">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <h3 class="flex my-3 text-lg justify-between" style="color: #00aeef">
                        <p>الصوتيات</p>
                        <a href="#" class="delete_audios">الغاء الاختيار</a>
                    </h3>
                    <div class="audios-section grid grid-cols-12 gap-4 mb-2">
                        @foreach($sounds as $row)
                            <div class="lg:col-span-3 col-span-6">
                                <div class="card border-2 p-2 relative">
                                    <h4 class='text-lg mb-2 block text-center'>{{$row->name}}</h4>
                                    <input type="radio" name="sound_id" value="{{$row->id}}" style="z-index: 99999;position: absolute; top: 10px; right: 12px;">
                                    <div class="audio-holder">
                                        <div class="waves-holder">
                                            <div class="animation-container">
                                                <div class="sound-container">
                                                    <div class="rect-1"></div>
                                                    <div class="rect-2"></div>
                                                    <div class="rect-3"></div>
                                                    <div class="rect-4"></div>
                                                    <div class="rect-5"></div>
                                                    <div class="rect-6"></div>
                                                    <div class="rect-5"></div>
                                                    <div class="rect-4"></div>
                                                    <div class="rect-3"></div>
                                                    <div class="rect-2"></div>
                                                    <div class="rect-1"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <audio class="myAudio" style="width: 100%;" controls src="{{asset('uploads/'.$row->sound_name)}}"></audio>
                                        <div class="controls">
                                            <i class="fas fa-play"></i>
                                            <i class="fas fa-pause status"></i>
                                        </div>
                                    </div>

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
                    <h3 class="flex my-3 text-lg justify-between" style="color: #00aeef">
                        <p>الفيديوهات</p>
                        <a href="#" class="delete_videos">الغاء الاختيار</a>
                    </h3>
                    <div class="grid grid-cols-12 gap-4 mb-2 videos-section">
                        @foreach($videos as $row)
                            <div class="lg:col-span-3 col-span-6">
                                <div class="card bg-white rounded  border-2 shadow-md p-2 relative">
                                    <input type="radio" name="video_id" value="{{$row->id}}" style="z-index: 99999;position: absolute; top: 10px; right: 12px;">
                                    <div class="video-holder relative sm:w-auto">
                                        <video class="shadow-md overflow-hidden rounded myVideo" src="{{asset('uploads/'.$row->video_name)}}" style="height: 487px;width: 276px;" height="640" width="360" playsinline="true">
                                            <source src="{{asset('uploads/'.$row->video_name)}}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                        <div class="controls">
                                            <i class="fas fa-play"></i>
                                            <i class="fas fa-pause status"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <span>يمكنك اختيار فيديو</span>
                    <div class="mt-4 relative">
                        <x-jet-button style="position: absolute; top: 20px; left: 8px;" class="main-btn clear-image"><i class="fas fa-trash"></i></x-jet-button>
                        <x-jet-label for='sound' value="{{__('يمكنك رفع صورة مستقلة في حالة عدم اختيار فيديو')}}" />
                        <x-jet-input type='file' id="image" name='image' class="slug block mt-1 w-full" />
                        @error('image')
                        <span class="text-red-500 mt-1">{{$message}}</span>
                        @enderror
                    </div>
                    <br>
                    <x-jet-button class="main-btn" type="submit"><i class="fas fa-plus"></i> اضافة </x-jet-button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.querySelector('.delete_audios').addEventListener('click', function (e) {
            e.preventDefault();
            let radioButtons = document.querySelectorAll(".audios-section input[type='radio']");
            radioButtons.forEach((input) => {
                input.checked = false;
            });
        });


        document.querySelector('.delete_videos').addEventListener('click', function (e) {
            e.preventDefault();
            let radioButtons = document.querySelectorAll(".videos-section input[type='radio']");
            radioButtons.forEach((input) => {
                input.checked = false;
            });
        });

        document.querySelector('.clear-image').addEventListener('click', function (e) {
           e.preventDefault();
           document.querySelector('#image').value = null;
        });

    </script>
</x-guest-layout>
