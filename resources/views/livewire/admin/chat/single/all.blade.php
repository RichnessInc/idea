<div>
    <div class="search-section mb-2">
        <x-jet-input
        wire:model='search'
        class="dark:bg-gray-900 dark:text-gray-100 mb-2 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight"
        placeholder="اسم العميل او البريد الالكتروني"/>
    </div>
    <div class="card bg-white shadow" id="allChatsPage">
        <ul>
            @foreach ($unreaded as $chat)
                <li class="whitespace-nowrap relative">
                    <span class="unread">*</span>
                    <a href="{{route('dashboard.admin.chat.single.single', ['id' => $chat->client->id])}}">
                        <div class="flex items-center px-6 py-4">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full" src="{{asset('images/icon.png')}}" alt="">
                            </div>
                            <div class="mr-4">
                                <div class="text-sm font-medium text-gray-900">{{$chat->client->name}}</div>
                                <div class="text-sm text-gray-500">{{$chat->client->email}}</div>
                            </div>
                        </div>
                    </a>
                </li>
            @endforeach
            @foreach ($chats as $chat)
            <li class="whitespace-nowrap relative">
                <a href="{{route('dashboard.admin.chat.single.single', ['id' => $chat->client->id])}}">
                    <div class="flex items-center px-6 py-4">
                        <div class="flex-shrink-0 h-10 w-10">
                            <img class="h-10 w-10 rounded-full" src="{{asset('images/icon.png')}}" alt="">
                        </div>
                        <div class="mr-4">
                            <div class="text-sm font-medium text-gray-900">{{$chat->client->name}}</div>
                            <div class="text-sm text-gray-500">{{$chat->client->email}}</div>
                        </div>
                    </div>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>
