<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __(' كارت تهنئة مرسل من ' . $row->from) }}
        </h2>

    </x-slot>
    <div class="spender_holder">
        <div class="loading_screen">
            <img src="{{asset('images/card.gif')}}" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        </div>
    </div>


    <div class="cardPage" data-background="{{($row->background != null ? $row->background->background_name: '')}}">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="card-container">
                    <div class="box box-one">
                        <div class="card-text bg-white rounded relative shadow-md">
                            <div class="p-2">
                                <p>{{$row->text}}</p>
                            </div>

                            <hr>
                            <div class="p-2">
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
                                    @if($row->sound_id != null)
                                        <audio class="myAudio" style="width: 100%;" controls src="{{asset('uploads/'.\App\Models\CardsSound::findOrFail($row->sound_id)->sound_name)}}"></audio>
                                    @else
                                        <audio class="myAudio" style="width: 100%;" controls src="{{asset('uploads/'.$row->sound)}}"></audio>
                                    @endif
                                    <div class="controls">
                                        <i class="fas fa-play"></i>
                                        <i class="fas fa-pause status"></i>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="p-2">
                                <p> مرسل الى {{ $row->to}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="box box-tow">
                       @if($row->video != null)
                        <div class="video-holder relative" id="VControl">
                            <video autoplay class="shadow-md overflow-hidden rounded myVideo" src="{{asset('uploads/'.$row->video->video_name)}}" style="height: 487px;width: 276px;" height="640" width="360" playsinline="true">
                                <source src="{{asset('uploads/'.$row->video->video_name)}}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <div class="controls">
                                <i class="fas fa-play"></i>
                                <i class="fas fa-pause status"></i>
                            </div>
                        </div>
                        @else
                           <img  height="640" width="360" alt="s" src="{{asset('uploads/'.$row->image)}}">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener("load", function() {
            setTimeout(() =>  {
                document.querySelector(".spender_holder").style.top = '-100%';
            }, 1000);
        });
    </script>
</x-guest-layout>
