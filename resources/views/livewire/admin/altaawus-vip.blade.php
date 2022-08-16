<div>
    <h3 style="font-size: 30px;margin-bottom: 15px">معلومات الصفحة</h3>
    <div class="rounded overflow-hidden shadow-lg bg-white w-full">
        <div class="px-6 py-4 w-full">
            <div class="mt-4">
                <x-jet-label for='text' value="{{__('وصف الصفحة')}}" />
                <div wire:ignore wire:key="myid" class=" hidden">
                    <textarea id="page_texts" wire:model='page_text'>{!!$data->text!!}</textarea>
                </div>
                <div class=" mb-2" >
                    <textarea class="page_text form-input rounded-md shadow-sm mt-1 block w-full" id="page_text" >{!!$data->!!}</textarea>
                </div>
                @error('text')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
        </div>
        <div class="px-6 py-4 w-full bg-gray-300">
            <x-jet-button class="ml-2 main-btn ksbtn"><i class="fas fa-save"></i> {{__(' تحديث')}}</x-jet-button>

        </div>
    </div>
</div>
@push('scripts')
<script src="https://cdn.tiny.cloud/1/i3angf3gce3j3xj51lzzzb3l6fa0xcb7o6qzoaafuy2zmgkz/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
      document.querySelector('.ksbtn').addEventListener('click', function () {
    Livewire.emit('postAdded', document.querySelector('#page_texts').value);

});

window.onload = function() {
        Livewire.on('doneTal', () => {
            window.location.reload();
        })
    }
tinymce.init({


            height : "750",
            selector: '#page_text',
            plugins: 'image code advlist autolink lists link  charmap print preview hr anchor pagebreak',
            toolbar: 'undo redo | link image | code | ltr rtl',
            toolbar_mode: 'floating',
            /* enable title field in the Image dialog*/
            image_title: true,
            /* enable automatic uploads of images represented by blob or data URIs*/
            automatic_uploads: true,
            /*
            URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
            images_upload_url: 'postAcceptor.php',
            here we add custom filepicker only to Image dialog
            */
            file_picker_types: 'image',
            /* and here's our custom image picker*/
            file_picker_callback: function (cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                /*
                Note: In modern browsers input[type="file"] is functional without
                even adding it to the DOM, but that might not be the case in some older
                or quirky browsers like IE, so you might want to add it to the DOM
                just in case, and visually hide it. And do not forget do remove it
                once you do not need it anymore.
                */
                input.onchange = function () {
                    var file = this.files[0];
                    var reader = new FileReader();
                    reader.onload = function () {
                        /*
                        Note: Now we need to register the blob in TinyMCEs image blob
                        registry. In the next release this part hopefully won't be
                        necessary, as we are looking to handle it internally.
                        */
                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(',')[1];
                        var blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);

                        /* call the callback and populate the Title field with the file name */
                        cb(blobInfo.blobUri(), { title: file.name });
                    };
                    reader.readAsDataURL(file);
                };

                input.click();
            },
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
            setup: function (editor) {
            var toggleState = false;
            editor.on('init change', function () {
              editor.save();
            });
            editor.on('change', function (e) {
                document.getElementById('page_texts').value = editor.getContent();

            });
          },
        });
    </script>
    @endpush
