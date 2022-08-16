<div>
    <div class="help-chat">
        <div class="chat-section shadow-md">
            <ul style="display: flex;align-items: center;justify-content: space-between;" class="p-2">
                @if($last_message != null)
                    <li> اخر رسالة للمندوب : {{date('d-m-Y / g:i A', strtotime($last_message->created_at))}} </li>
                @endif
                @if ($get_group->sender_id != null)
                    @if(\Illuminate\Support\Facades\Auth::guard('clients')->check())
                        @if(\Illuminate\Support\Facades\Auth::guard('clients')->user()->type != 3)
                            <li><x-jet-button wire:click="out">استبعاد المندوب</x-jet-button></li>
                        @endif
                    @elseif(\Illuminate\Support\Facades\Auth::check())
                        <li><x-jet-button wire:click="out">استبعاد المندوب</x-jet-button></li>
                    @endif
                @endif
            </ul>
            <div class="chatbox">
                <div class="footer">
                    <label class="block">
                        <textarea class="form-textarea mt-1 block w-full" wire:model='message' rows="3" placeholder="اكتب رسالتك"></textarea>
                    </label>
                    <div class="btns">
                        <div class="input-holder  {{($file != null ? 'uploaded' : '')}}">
                            <input type="file" class="uploadfile" wire:model='file'>
                            @if ($file != null)
                                <label><i class="fas fa-check"></i> تم رفع الملف</label>
                            @else
                                <label><i class="fas fa-paperclip"></i> ارفاق ملف</label>
                            @endif

                        </div>
                        <button class="sendMessage" wire:click='sendMessage'><i class="fas fa-paper-plane"></i> ارسال</button>
                    </div>
                </div>
                <hr>
                <div class="body">
                    @foreach ($messages as $message)
                        @if ($message->file != null && $message->message == 'file')
                            <div class="relative">
                                <a class="downloadFile" href="{{URL::to('download/file/'.$message->file)}}">
                                    <span class="block">
                                        @if($message->client != null)
                                        {{$message->client->name}}
                                        @elseif($message->user != null)
                                        الادارة
                                        @endif
                                    </span>
                                    <i class="fas fa-download"></i> تحميل ملف ({{last(explode(".", $message->file))}})
                                </a>
                            </div>
                        @else
                            <div class="relative">
                                <div class="message shadow-md" style="width: 280px;">
                                    <p class="space">
                                        <small>
                                            <span class="block">{{date('d-m-Y', strtotime($message->created_at))}}</span>
                                            <span class="block">{{date('g:i A', strtotime($message->created_at))}}</span>
                                        </small>
                                        <small>
                                            @if($message->client != null)
                                                {{$message->client->name}}
                                            @elseif($message->user != null)
                                                الادارة
                                            @endif
                                        </small>
                                    </p>
                                    <p class="mesg">{{$message->message}}</p>
                                </div>
                            </div>
                        @endif


                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<audio src="{{asset('audios/message.wav')}}" id="messageSound" style="display: none"></audio>
@push('scripts')
    <script>
    function formatAMPM(date) {
        let hours = date.getHours();
        let minutes = date.getMinutes();
        let ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0'+minutes : minutes;
        let strTime = hours + ':' + minutes + ' ' + ampm;
        return strTime;
    }
        Pusher.logToConsole = true;

        let pusher = new Pusher('9c8687b4c2d840121ae3', {
            cluster: 'eu'
        });
        let clid = "{{Auth::guard('clients')->user()->id}}";
        let channel = pusher.subscribe('send-message-to-group-from-client.'+"{{$gid}}");
        channel.bind('send-message-to-group', function(data) {
            if(data.client_id != clid) {
                document.getElementById('messageSound').play();
                if (data.fileName != null) {
                    let relativeDiv = document.createElement("div");
                    relativeDiv.className = 'relative';
                    let link = document.createElement('a');
                    link.className = 'downloadFile';
                    link.setAttribute('href', window.location.origin+"/download/file/"+data.fileName);
                    let icon = document.createElement('i');
                    icon.className  = 'fas fa-download';
                    let textnode    = document.createTextNode('تحميل الملف');
                    link.appendChild(icon);
                    link.appendChild(textnode);
                    relativeDiv.appendChild(link);
                    document.querySelector(".body").prepend(relativeDiv);
                    if(data.message != null) {
                        let d = new Date;
                        let ye = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(d);
                        let mo = new Intl.DateTimeFormat('en', { month: 'numeric' }).format(d);
                        let da = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(d);
                        mo = mo >= 10 ? mo : `0${mo}`;
                        let DateNode = document.createTextNode(`${da}-${mo}-${ye}`);
                        let TimeNode = document.createTextNode(formatAMPM(d));
                        let messageDiv = document.createElement("div");
                        let textnode = document.createTextNode(data.message);
                        let relativeDiv = document.createElement("div");
                        let firstP = document.createElement('p');
                        firstP.className = 'space';
                        let firstSmall = document.createElement('small');
                        let firstSpan = document.createElement('span');
                        let secondSpan = document.createElement('span');
                        firstSpan.style.display = "block";
                        secondSpan.style.display = "block";
                        firstSpan.appendChild(DateNode);
                        secondSpan.appendChild(TimeNode);
                        firstSmall.appendChild(firstSpan);
                        firstSmall.appendChild(secondSpan);
                        let secondSmall = document.createElement('small');
                        let name = document.createTextNode(data.name);
                        secondSmall.appendChild(name);
                        firstP.appendChild(firstSmall);
                        firstP.appendChild(secondSmall);
                        let secondP = document.createElement('p');
                        secondP.className = 'mesg';
                        secondP.appendChild(textnode);
                        relativeDiv.className = 'relative';
                        messageDiv.className = 'message shadow';
                        messageDiv.style.width = '280px';
                        relativeDiv.appendChild(messageDiv);
                        messageDiv.appendChild(firstP);
                        messageDiv.appendChild(secondP);
                        document.querySelector(".body").prepend(relativeDiv);
                    }
                } else {
                    let d = new Date;
                    let ye = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(d);
                    let mo = new Intl.DateTimeFormat('en', { month: 'numeric' }).format(d);
                    let da = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(d);
                    mo = mo >= 10 ? mo : `0${mo}`;
                    let DateNode = document.createTextNode(`${da}-${mo}-${ye}`);
                    let TimeNode = document.createTextNode(formatAMPM(d));
                    let messageDiv = document.createElement("div");
                    let textnode = document.createTextNode(data.message);
                    let relativeDiv = document.createElement("div");
                    let firstP = document.createElement('p');
                    firstP.className = 'space';
                    let firstSmall = document.createElement('small');
                    let firstSpan = document.createElement('span');
                    let secondSpan = document.createElement('span');
                    firstSpan.style.display = "block";
                    secondSpan.style.display = "block";
                    firstSpan.appendChild(DateNode);
                    secondSpan.appendChild(TimeNode);
                    firstSmall.appendChild(firstSpan);
                    firstSmall.appendChild(secondSpan);
                    let secondSmall = document.createElement('small');
                    let name = document.createTextNode(data.name);
                    secondSmall.appendChild(name);
                    firstP.appendChild(firstSmall);
                    firstP.appendChild(secondSmall);
                    let secondP = document.createElement('p');
                    secondP.className = 'mesg';
                    secondP.appendChild(textnode);
                    relativeDiv.className = 'relative';
                    messageDiv.className = 'message shadow';
                    messageDiv.style.width = '280px';
                    relativeDiv.appendChild(messageDiv);
                    messageDiv.appendChild(firstP);
                    messageDiv.appendChild(secondP);
                    document.querySelector(".body").prepend(relativeDiv);
                }
            }
        });
    </script>
@endpush
