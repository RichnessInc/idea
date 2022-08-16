<div>
    <div class="card bg-white shadow" id="allChatsPage">
        @php
            $arry = [];
            foreach($unread as $msg) {
                $arry[]= $msg->id;
            }
        @endphp
        <ul>
            @foreach ($unreaded as $group)
                <li class="whitespace-nowrap relative">
                    @if (in_array($group->id, $arry))
                        <span class="unread">*</span>
                    @endif
                    <a href="{{route('dashboard.admin.group.single', ['id' => $group->id])}}">
                        <div class="flex items-center px-6 py-4 controlChatCroupClass">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full" src="{{asset('images/icon.png')}}" alt="">
                            </div>
                            <div class="mr-4">
                                <div class="text-sm font-medium text-gray-900">{{$group->buyer->name}}</div>
                                <div class="text-sm text-gray-500">{{$group->buyer->email}}</div>
                            </div>
                            <div class="mr-4">
                                <div class="text-sm font-medium text-gray-900">{{$group->provieder->name}}</div>
                                <div class="text-sm text-gray-500">{{$group->provieder->email}}</div>
                            </div>
                            @if($group->sender != null)
                                <div class="mr-4">
                                    <div class="text-sm font-medium text-gray-900">{{$group->sender->name}}</div>
                                    <div class="text-sm text-gray-500">{{$group->sender->email}}</div>
                                </div>
                            @endif
                            <div class="mr-4">
                                <div class="text-sm font-medium text-gray-900">{{$group->request->product->name}}</div>
                            </div>
                        </div>
                    </a>
                </li>
            @endforeach

                @foreach ($groups as $group)
                    <li class="whitespace-nowrap relative">
                        @if (in_array($group->id, $arry))
                            <span class="unread">*</span>
                        @endif
                        <a href="{{route('dashboard.admin.group.single', ['id' => $group->id])}}">
                            <div class="flex items-center px-6 py-4 controlChatCroupClass">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" src="{{asset('images/icon.png')}}" alt="">
                                </div>
                                <div class="mr-4">
                                    <div class="text-sm font-medium text-gray-900">{{$group->buyer->name}}</div>
                                    <div class="text-sm text-gray-500">{{$group->buyer->email}}</div>
                                </div>
                                <div class="mr-4">
                                    <div class="text-sm font-medium text-gray-900">{{$group->provieder->name}}</div>
                                    <div class="text-sm text-gray-500">{{$group->provieder->email}}</div>
                                </div>
                                @if($group->sender != null)
                                    <div class="mr-4">
                                        <div class="text-sm font-medium text-gray-900">{{$group->sender->name}}</div>
                                        <div class="text-sm text-gray-500">{{$group->sender->email}}</div>
                                    </div>
                                @endif
                                <div class="mr-4">
                                    <div class="text-sm font-medium text-gray-900">{{$group->request->product->name}}</div>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
        </ul>
    </div>
</div>
