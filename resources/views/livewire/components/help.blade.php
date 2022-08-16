<div>
    <div class="help-chat">
        <div class="chat-section shadow-md">
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
                                <i class="fas fa-download"></i> تحميل ملف ({{last(explode(".", $message->file))}})
                            </a>
                        </div>
                        @else
                        <div class="relative">
                            <div class="{{($message->from == 1 ? 'message-from' : 'message')}} shadow-md">
                                {{$message->message}}
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
        Pusher.logToConsole = true;

        var pusher = new Pusher('9c8687b4c2d840121ae3', {
            cluster: 'eu'
        });
        var channel = pusher.subscribe('send-message-from-admin.'+"{{Auth::guard('clients')->user()->id}}");
        channel.bind('my-message', function(data) {
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
                    let messageDiv = document.createElement("div");
                    let textnode = document.createTextNode(data.message);
                    let relativeDiv = document.createElement("div");
                    relativeDiv.className = 'relative';
                    messageDiv.className = 'message shadow';
                    relativeDiv.appendChild(messageDiv);
                    messageDiv.appendChild(textnode);
                    document.querySelector(".body").prepend(relativeDiv);
                }
            } else {
                let messageDiv = document.createElement("div");
                let textnode = document.createTextNode(data.message);
                let relativeDiv = document.createElement("div");
                relativeDiv.className = 'relative';
                messageDiv.className = 'message shadow';
                relativeDiv.appendChild(messageDiv);
                messageDiv.appendChild(textnode);
                document.querySelector(".body").prepend(relativeDiv);
            }
        });
    </script>
@endpush
