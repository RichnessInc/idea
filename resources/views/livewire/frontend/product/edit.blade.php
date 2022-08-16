<div>
    <form  wire:submit.prevent="submit" enctype="multipart/form-data">
        <div class="mt-4">
            <div class="images">
                @if ($row->main_image != null)
                    <img src="{{asset('uploads/'.$row->main_image)}}" alt="">
                @endif
                @if ($row->images != null)
                    @foreach (explode(',', $row->images) as $image)
                        <img src="{{asset('uploads/'.$image)}}" alt="">
                    @endforeach
                @endif
            </div>
        </div>
        <div class="mt-4">
            <x-jet-label for='productname-add' value="{{__('الاسم')}}" />
            <x-jet-input type='text' id="productname-add" wire:model='productname' class="block mt-1 w-full" />
            @error('productname')
            <span class="text-red-500 mt-1">{{$message}}</span>
            @enderror
        </div>
        <div class="mt-4">
            <x-jet-label for='category_id-add' value="{{__('التصنيف')}}" />
            <div class="w-full">
                <div class="relative">
                    <select class="block appearance-none w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            wire:model='category_id'
                            name='category_id'
                            id="category_id-add">
                        <option>التصنيف</option>
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @error('category_id')
            <span class="text-red-500 mt-1">{{$message}}</span>
            @enderror
        </div>
        <div class="mt-4">
            <x-jet-label for='wight-add' value="{{__('الوزن')}}" />
            <x-jet-input type='text' id="wight-add" wire:model='wight' class="block mt-1 w-full wight" />
            @error('wight')
            <span class="text-red-500 mt-1">{{$message}}</span>
            @enderror
        </div>
        <div class="mt-4">
            <x-jet-label for='width-add' value="{{__('الطول')}}" />
            <x-jet-input type='text' id="width-add" wire:model='width' class="block mt-1 w-full" />
            @error('width')
            <span class="text-red-500 mt-1">{{$message}}</span>
            @enderror
        </div>
        <div class="mt-4">
            <x-jet-label for='height-add' value="{{__('العرض')}}" />
            <x-jet-input type='text' id="height-add" wire:model='height' class="block mt-1 w-full" />
            @error('height')
            <span class="text-red-500 mt-1">{{$message}}</span>
            @enderror
        </div>
        <div class="mt-4">
            <x-jet-label for='price-add' value="{{__('السعر')}}" />
            <x-jet-input type='text' id="price-add" wire:model='price' class="block mt-1 w-full" />
            @error('price')
            <span class="text-red-500 mt-1">{{$message}}</span>
            @enderror
        </div>
        <div class="mt-4">
            <x-jet-label for='aval_count-add' value="{{__('الكمية المتاحة')}}" />
            <x-jet-input type='number' id="aval_count-add" wire:model='aval_count' class="block mt-1 w-full" />
            @error('aval_count')
            <span class="text-red-500 mt-1">{{$message}}</span>
            @enderror
        </div>

        <div class="mt-4">
            <small>لا يمكن تغير الرابط بعد الاضافة</small>
            <x-jet-label for='slug' value="{{__('اكتب اسم المنتج بالنجليزية فقط')}}" />
            <x-jet-input type='text' id="slug" wire:model='slug' class="block mt-1 w-full slug" />
            @error('slug')
            <span class="text-red-500 mt-1">{{$message}}</span>
            @enderror
        </div>
        <div class="mt-4">
            <x-jet-label for='main_image-add' value="{{__('الصورة المصغرة')}}" />
            <x-jet-input type='file' id="main_image-add" wire:model='main_image' class="block mt-1 w-full" accept='image/*'/>
            @error('main_image')
            <span class="text-red-500 mt-1">{{$message}}</span>
            @enderror
        </div>
        <div class="mt-4">
            <x-jet-label for='images-add' value="{{__('صور المعرض')}}" />
            <x-jet-input type='file' multiple id="images-add" wire:model='images' class="block mt-1 w-full" accept='image/*'/>
            @error('images')
            <span class="text-red-500 mt-1">{{$message}}</span>
            @enderror
        </div>
        <div class="mt-4 relative">
            <i wire:click="add_tag" class="fas fa-plus" style="position: absolute; top: 37px; left: 10px; color: #006EB9FF; cursor: pointer;"></i>
            <x-jet-label for='tags-add' value="{{__('الكلمات المفتاحية')}}" />
            <x-jet-input wire:keydown.space="add_tag" type='text' id="tags-add" wire:model='tags' class="block mt-1 w-full" />
            @error('tags')
            <span class="text-red-500 mt-1">{{$message}}</span>
            @enderror
            <div class="tags">
                @if(!empty($tagsArr))
                    @foreach($tagsArr as $tag)
                        <div class="tag">
                                <span style="display: block;cursor: pointer" wire:click="delete_tag('{{$tag}}')">
                                    <i class="fas fa-trash"></i>
                                </span>
                            {{$tag}}</div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="mt-4">
            <x-jet-label for='receipt_days-add' value="{{__('وقت التسليم')}}" />
            <x-jet-input type='number' id="receipt_days-add" wire:model='receipt_days' class="block mt-1 w-full" />
            @error('receipt_days')
            <span class="text-red-500 mt-1">{{$message}}</span>
            @enderror
        </div>
        <div class="mt-4">
            <x-jet-label for='desc-add' value="{{__(' الوصف')}}" />
            <textarea id="desc-add" wire:model='desc' class="block mt-1 w-full"></textarea>
            @error('desc')
            <span class="text-red-500 mt-1">{{$message}}</span>
            @enderror
        </div>
        <br>
        <div class="grid grid-cols-12 gap-4 relative">
            <div class="md:col-span-6 col-span-12">
                <x-jet-label for='desc-add' value="الفروع المتاح بها المنتج"/>
                <ul class="rounded bg-white shadow-sm">
                    @if($branches != null)
                    @foreach($branches as $branch)
                        <li wire:click="addBranch({{$branch->id}})"
                            class="relative {{(in_array($branch->id, $selectedBranches) ? 'bg-green-600 font-bold' : '')}} border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full cursor-pointer"
                            style="padding: .5rem .75rem;">
                            {{$branch->government->name}}
                            {{--{{json_encode($selectedBranches)}}--}}
                        </li>
                    @endforeach
                    @endif
                </ul>
            </div>
            <div class="md:col-span-6 col-span-12">
                <x-jet-label for='desc-add' value="الفروع المحدده"/>
                <ul class="rounded bg-white shadow-sm">
                    @if(!empty($selectedBranches))
                        @foreach($selectedBranches as $item)
                            @if($item != '')
                                <li style = " padding: .5rem .75rem;"
                                    class="relative bg-green-600 font-bold border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full cursor-pointer">
                                    {{\App\Models\Address::with('government')->where('id', '=', $item)->first()->government->name}}
                                    <button type="button"
                                            style="position: absolute; left: 0; top: 0; background-color: #e22626; height: 39px; width: 30px; color: #FFF;"
                                            wire:click="removeBranch({{$item}})" class="rounded cursor-pointer"><i
                                            class="fas fa-times"></i></button>
                                </li>
                            @endif
                        @endforeach
                    @else
                        <li style = " padding: .5rem .75rem;"
                            class="relative bg-red-600 font-bold border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full cursor-pointer">
                            لا يوجد فروع محددة
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="mt-4">
            <x-jet-button type='submit' class="ml-2 main-btn"><i class="fas fa-plus"></i> {{__(' اضافة')}}</x-jet-button>
        </div>
    </form>


    @push('scripts')
        <script>
            window.addEventListener('load', function () {
                let tagsList = [];
                // loop of old tags
                let oldTags = document.querySelector('.tags').dataset.oldtags;
                if (oldTags != null && oldTags !== '') {

                }
                // Add Tag
                document.querySelector('#add_tag').addEventListener('click', function (e) {
                    let tagsInput = document.querySelector('#tags');
                    e.preventDefault();
                    tagsInput.value = tagsInput.value.replace(' ', '');
                    let tag = tagsInput.value;
                    tagsList.push(tag);
                    tagsInput.value = '';
                    console.log(tagsList);
                    addNewTag(tag);
                    document.querySelector('#sendTags').value = tagsList.join();
                });
                document.querySelector('#tags').addEventListener('keyup', function (e) {
                    if(e.keyCode === 32){
                        e.preventDefault();
                        this.value = this.value.replace(' ', '');
                        let tag = this.value;
                        tagsList.push(tag);
                        this.value = '';
                        console.log(tagsList);
                        addNewTag(tag);
                        document.querySelector('#sendTags').value = tagsList.join();
                    }
                });
                document.addEventListener('click', function (e) {
                    if (e.target.classList.contains('delete-tag')) {
                        let targetedTag = e.target.parentNode.dataset.tag
                        let filteredArray = tagsList.filter(function(e) { return e !== targetedTag });
                        e.target.parentNode.parentNode.remove();
                        document.querySelector('#sendTags').value = filteredArray;
                    }
                });
            }, false);
            function addNewTag(tag) {
                let tagHolder = document.createElement('div');
                tagHolder.className = 'tag';
                let span = document.createElement('span');
                span.style.display  = 'block';
                span.style.cursor   = 'pointer';
                span.dataset.tag    = tag;
                let i = document.createElement('i');
                i.className = "fas fa-trash delete-tag";
                span.appendChild(i);
                tagHolder.appendChild(span);
                let tagTextNode = document.createTextNode(tag);
                tagHolder.appendChild(tagTextNode);
                document.querySelector('.tags').appendChild(tagHolder);
            }
        </script>
    @endpush
</div>
