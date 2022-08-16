<div>
    <div class="search-container grid grid-cols-12 gap-4">
        <div class="col-span-8">
            <input wire:model='searchForm'
                   class="dark:bg-gray-900 dark:text-gray-100 mb-2 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight"
                   type="text"
                   value=" "
                   autocomplete="new-password"
                   placeholder="البحث">
        </div>
        <div class="col-span-4">
            <x-jet-button  wire:click='createShowModel' class="mb-2 w-full h-10 text-center main-btn">
                <i class="fas fa-plus"></i> {{__('اضافة المنتج')}}
            </x-jet-button>
        </div>
    </div>

    {{-- Start Create New User Model --}}
    <x-jet-dialog-modal wire:model="createFormVisible">
        <x-slot name="title">{{__('اضافة المنتج')}}</x-slot>
        <x-slot name="content">
            <hr style="border-color:#000 !important">
            <div class="mt-4">
                <x-jet-label for='name-add' value="{{__('الاسم')}}" />
                <x-jet-input type='text' id="name-add" wire:model='name' class="block mt-1 w-full" />
                @error('name')
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
                <x-jet-label for='tags' value="{{__('الكلمات المفتاحية')}}" />
                <x-jet-input wire:keydown.space="add_tag" type='text' id="tags" wire:model='tags' class="block mt-1 w-full" />

                @error('tags')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
                <div class="tags">
                    @if(!empty($tagsArr))
                        @foreach($tagsArr as $tag)
                            @if($tag != null && $tag != '')
                                <div class="tag">
                            <span style="display: block;cursor: pointer" wire:click="delete_tag('{{$tag}}')">
                                <i class="fas fa-trash"></i>
                            </span>
                                    {{$tag}}</div>
                            @endif
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
        </x-slot>
        <x-slot name="footer">
            <x-jet-button wire:click='store' class="ml-2 main-btn"><i class="fas fa-plus"></i> {{__(' اضافة')}}</x-jet-button>
            <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
    {{-- Start Create New User Model --}}
    <x-jet-dialog-modal wire:model="addProductExtraVisible">
        <x-slot name="title">{{__('اضافة ملحق لمنتج')}}</x-slot>
        <x-slot name="content">
            <hr style="border-color:#000 !important">
            <div class="mt-4">
                <x-jet-label for='name' value="{{__('الاسم')}}" />
                <x-jet-input type='text' id="name" wire:model='name' class="block mt-1 w-full" />
                @error('name')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for='price' value="{{__('السعر')}}" />
                <x-jet-input type='text' id="price" wire:model='price' class="block mt-1 w-full" />
                @error('price')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for='main_image' value="{{__('الصورة المصغرة')}}" />
                <x-jet-input type='file' id="main_image" wire:model='main_image' class="block mt-1 w-full" accept='image/*'/>
                @error('main_image')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>

        </x-slot>
        <x-slot name="footer">
            <x-jet-button wire:click='addProductExtra' class="ml-2 main-btn"><i class="fas fa-plus"></i> {{__(' اضافة')}}</x-jet-button>
            <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>

    <x-jet-dialog-modal wire:model="ProductExtraVisible">
        <x-slot name="title">{{__('ملحقات المنتج')}}</x-slot>
        <x-slot name="content">
            <hr style="border-color:#000 !important">
            @if ($extras != null)
                @foreach ($extras as $extra)
                    <br>
                    <img src="{{asset('uploads/'.$extra->main_image)}}" style="width: 50px" alt="">
                    <ul>
                        <li>الاسم : {{$extra->name}}</li>
                        <li>السعر : {{number_format($extra->price, 2)}} SAR</li>
                    </ul>
                    <br>
                @endforeach
            @endif
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>

    {{-- Start Update User Model --}}
    <x-jet-dialog-modal wire:model="updateFormVisible" class="">
        <x-slot name="title">{{ __('تعديل بيانات المنتج') }}</x-slot>
        <x-slot name="content">
            <hr style="border-color:#000 !important">
            <div class="mt-4">
                <div class="images">
                    @if ($image_name != null)
                        <img src="{{asset('uploads/'.$image_name)}}" alt="">
                    @endif
                    @if ($images_names != null)
                        @foreach (explode(',', $images_names) as $image)
                            <img src="{{asset('uploads/'.$image)}}" alt="">
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="mt-4">
                <x-jet-label for='name' value="{{__('الاسم')}}" />
                <x-jet-input type='text' id="name'" wire:model='name' class="block mt-1 w-full" />
                @error('name')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='category_id' value="{{__('التصنيف')}}" />
                <div class="w-full">
                    <div class="relative">
                        <select class="block appearance-none w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                wire:model='category_id'
                                name='category_id'
                                id="category_id">
                            <option>التصنيف</option>
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}" {{($category_id == $category->id ? 'selected' : '')}}>{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @error('category_id')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='wight' value="{{__('الوزن')}}" />
                <x-jet-input type='text' id="wight" wire:model='wight' class="block mt-1 w-full" />
                @error('wight')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='width' value="{{__('الطول')}}" />
                <x-jet-input type='text' id="width" wire:model='width' class="block mt-1 w-full" />
                @error('width')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='height' value="{{__('العرض')}}" />
                <x-jet-input type='text' id="height" wire:model='height' class="block mt-1 w-full" />
                @error('height')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='price' value="{{__('السعر')}}" />
                <x-jet-input type='text' id="price" wire:model='price' class="block mt-1 w-full" />
                @error('price')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='aval_count' value="{{__('الكمية المتاحة')}}" />
                <x-jet-input type='text' id="aval_count" wire:model='aval_count' class="block mt-1 w-full" />
                @error('aval_count')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='main_image' value="{{__('الصورة المصغرة')}}" />
                <x-jet-input type='file' id="main_image" wire:model='main_image' class="block mt-1 w-full" accept='image/*'/>
                @error('main_image')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='images' value="{{__('صور المعرض')}}" />
                <x-jet-input type='file' multiple id="images" wire:model='images' class="block mt-1 w-full" accept='image/*'/>
                @error('images')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4 relative">
                <i wire:click="add_tag" class="fas fa-plus" style="position: absolute; top: 37px; left: 10px; color: #006EB9FF; cursor: pointer;"></i>
                <x-jet-label for='tags' value="{{__('الكلمات المفتاحية')}}" />
                <x-jet-input wire:keydown.space="add_tag" type='text' id="tags" wire:model='tags' class="block mt-1 w-full" />

                @error('tags')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
                <div class="tags">
                    @if(!empty($tagsArr))
                        @foreach($tagsArr as $tag)
                            @if($tag != null && $tag != '')
                                <div class="tag">
                            <span style="display: block;cursor: pointer" wire:click="delete_tag('{{$tag}}')">
                                <i class="fas fa-trash"></i>
                            </span>
                                    {{$tag}}</div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="mt-4">
                <x-jet-label for='receipt_days' value="{{__('وقت التسليم')}}" />
                <x-jet-input type='number' id="receipt_days" wire:model='receipt_days' class="block mt-1 w-full" />
                @error('receipt_days')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='desc' value="{{__(' الوصف')}}" />
                <textarea id="desc" wire:model='desc' class="block mt-1 w-full"></textarea>
                @error('desc')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-button wire:click='update' class="ml-2 main-btn"><i class="fas fa-edit"></i> {{__('التعديل')}}</x-jet-button>
            <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
    {{-- End Update User Model --}}
    {{-- Start Delete User Model --}}
    <x-jet-dialog-modal wire:model="ProductDisableVisible">
        <x-slot name="title">{{ __('ايقاف عرض المنتج') }}</x-slot>
        <x-slot name="content">{{ __('انت متأكد من قرار ايقاف عرض المنتج') }}</x-slot>
        <x-slot name="footer">
            <x-jet-danger-button wire:click="ProductDisableFun" class="ml-2"><i class="fas fa-ban"></i> {{__('ايقاف')}}</x-jet-danger-button>
            <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
    <x-jet-dialog-modal wire:model="ProductActiveVisible">
        <x-slot name="title">{{ __('عرض المنتج') }}</x-slot>
        <x-slot name="content">{{ __('انت متأكد من قرار عرض المنتج') }}</x-slot>
        <x-slot name="footer">
            <x-jet-button wire:click="ProductActiveFun" class="ml-2"><i class="fas fa-eye"></i> {{__('عرض')}}</x-jet-button>
            <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
    @if (Auth::user()->role == 1)
        <x-jet-dialog-modal wire:model="deleteFormVisible">
            <x-slot name="title">{{ __('حذف المنتج') }}</x-slot>
            <x-slot name="content">{{ __('انت متأكد من قرار حذف المنتج') }}</x-slot>
            <x-slot name="footer">
                <x-jet-danger-button wire:click='destroy' class="ml-2"><i class="fas fa-trash"></i> {{__('حذف')}}</x-jet-danger-button>
                <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
            </x-slot>
        </x-jet-dialog-modal>
@endif

{{-- End Delete User Model --}}
{{-- Start Users Table --}}
<!-- This example requires Tailwind CSS v2.0+ -->
    <div class="mx-1 richness-table clients-table">
        <table class="w-full flex flex-row flex-no-wrap sm:bg-white sm:dark:bg-gray-900 rounded-lg overflow-hidden sm:shadow-lg my-5">
            <thead class="text-white mob-text-aline">
            @foreach ($rows as $user)

                <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0 table-tr">
                    <th class="p-3">الاسم</th>
                    <th class="p-3">التصنيف</th>
                    <th class="p-3">الوزن</th>
                    <th class="p-3">العرض</th>
                    <th class="p-3">الطول</th>
                    <th class="p-3">السعر</th>
                    <th class="p-3">الكمية المتاحة</th>
                    <th class="p-3"><i class="fas fa-tools"></i> التحكم</th>
                </tr>
            @endforeach
            </thead>
            <tbody class="flex-1 sm:flex-none">
            @foreach ($rows as $user)
                <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 bg-white dark:bg-gray-900 mob-text-aline">
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$user->name}}</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$user->category->name}}</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$user->wight}} جرام</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$user->width}} cm</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$user->height}} cm</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format($user->price, 2)}} SAR</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$user->aval_count}}</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                        @if($user->status == 1)
                            <x-jet-danger-button wire:click="ProductDisable({{$user->id}})" class="ml-2"><i class="fas fa-ban"></i> {{__('ايقاف')}}</x-jet-danger-button>
                        @else
                            <x-jet-button wire:click="ProductActive({{$user->id}})" class="ml-2"><i class="fas fa-eye"></i> {{__('عرض')}}</x-jet-button>
                        @endif
                        <x-jet-button wire:click="showProductExtrasModel({{$user->id}})" class="ml-2"><i class="fas fa-boxes"></i> {{__('الملحقات')}}</x-jet-button>
                        <x-jet-button wire:click="showAddProductExtraModel({{$user->id}})" class="ml-2"><i class="fas fa-plus"></i> {{__(' اضافة ملحق')}}</x-jet-button>
                        <x-jet-button wire:click="showUpdateModel({{$user->id}})" class="ml-2 main-btn"><i class="mr-2 fas fa-edit"></i> {{__(' تعديل')}}</x-jet-button>
                        <x-jet-danger-button wire:click="confirmUserDelete({{$user->id}})" class="ml-2"><i class="mr-2 fas fa-trash-alt"></i> {{__(' حذف')}}</x-jet-danger-button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <br>
    <div class="mx-1">
        {{$rows->links()}}
    </div>
</div>
@push('scripts')

@endpush
