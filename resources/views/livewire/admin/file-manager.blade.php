<div>
    <div class="grid grid-cols-12 gap-4">
        @foreach($allFiles as $file)
            <div class="col-span-6 lg:col-span-3">
                <div class="card bg-white shadow rounded p-2">
                    @php
                        $arr = ['jpg', 'jpeg', 'png'];
                    @endphp
                    @if(in_array(pathinfo(storage_path('/uploads/'.$file->getFileName()), PATHINFO_EXTENSION), $arr))
                        <img src="{{asset('uploads/'.$file->getFileName())}}" style="height: 367px;width: 100%">
                    @else
                        <h3 class="text-lg">{{pathinfo(storage_path('/uploads/'.$file->getFileName()), PATHINFO_EXTENSION)}}</h3>
                    @endif
                    <x-jet-danger-button class="block w-full mt-1" wire:click="remove('{{$file->getFileName()}}')"><i class="fas fa-trash"></i> حذف </x-jet-danger-button>
                </div>
            </div>
        @endforeach
    </div>
</div>
