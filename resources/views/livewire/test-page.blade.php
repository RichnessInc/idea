<div>
    <div>
        <div class="mt-4">
            <x-jet-label for='desc-add' value="الفروع المتاح بها المنتج"/>
            <ul class="rounded bg-white shadow-sm">
                @foreach($branches as $branch)

                    <li wire:click="addBranch({{$branch->id}})"
                        class="relative {{(in_array($branch->id, $selectedBranches) ? 'bg-green-600 font-bold' : '')}} border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full cursor-pointer"
                        style="padding: .5rem .75rem;">
                        {{$branch->government->name}}
                        {{--{{json_encode($selectedBranches)}}--}}

                    </li>
                @endforeach
                @foreach($selectedBranches as $item)
                    <p>hello {{$item}}</p>
                    <button type="button"
                            style="position: absolute; left: 0; top: 0; background-color: #e22626; height: 39px; width: 30px; color: #FFF;"
                            wire:click="removeBranch({{$item}})" class="rounded cursor-pointer"><i
                            class="fas fa-times"></i></button>
                @endforeach
            </ul>
        </div>
    </div>
</div>
