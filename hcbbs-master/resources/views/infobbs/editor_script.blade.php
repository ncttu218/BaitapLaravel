{{-- CSSの定義 --}}
@section('css')
@parent
<link rel="stylesheet" href="{{ asset_auto('css/dropzone.css') }}">
<style type="text/css">
.c-control-upload__image img{
    width: 240px !important;
    height: auto;
}
</style>
@stop

{{-- JSの定義 --}}
@section('js')
@parent
<?php
// 日時
$time = date('YmdHis');
// 販社コード
$hanshaCode = $loginAccountObj->gethanshaCode();
?>

<script type="text/javascript">
// TinyMCEにアクセス出来るように、一番上に定義する
var myDropzone;
</script>

@if ($textEditor == 'NICEDIT')
    <script type="text/javascript" src="{{ asset_auto('nicEdit_ja/nicEdit.js') }}"></script>
    <script type="text/javascript" src="{{ asset_auto('nicEdit_ja/load.js') }}"></script>
@elseif ($textEditor == 'TINYMCE')
    <script src="{{ asset_auto('tinymce/tinymce.min.js') }}"></script>
    <script>var tinyMCEBaseURL = "{{ asset_auto('tinymce') }}";</script>
    <script src="{{ asset_auto('tinymce/tinymce_setting.js') }}"></script>
@endif
<script src="{{ asset_auto('js/dropzone.js') }}"></script>
<script type="text/javascript" src="{{ asset_auto('js/upload.js') }}"></script>
<script>
var submit_val;
function valSet(v){
    submit_val = v;
}
$(window).on('beforeunload', function() {
    if(submit_val != 'OK'){
        return "入力が完了していません。このページを離れますか？";
    }
});
$(function(){
    // おまじない
    Dropzone.autoDiscover = false;
    Dropzone.options.myAwesomeDropzone = {
        paramName : "file",         // input fileの名前
        parallelUploads:1,            // 1度に何ファイルずつアップロードするか
        acceptedFiles:'image/*',   // 画像だけアップロードしたい場合
        maxFiles:100,                      // 1度にアップロード出来るファイルの数
        maxFilesize:5,                // 1つのファイルの最大サイズ(1=1M)
        // dictRemoveFileConfirmation: 'こちらの画像を削除しますか？',
        dictFileTooBig: "ファイルが大きすぎます。 (\{\{filesize\}\}MB). 最大サイズ: \{\{maxFilesize\}\}MB.",
        dictInvalidFileType: "画像ファイル以外です。",
        dictMaxFilesExceeded: "一度にアップロード出来るのは100ファイルまでです。",
        dictDefaultMessage: "ここへファイルをドラッグ＆ドロップするとアップロードされます。<br>アップロードできるファイルサイズの上限は5MBまでです。<br>最大100個までアップ可能です。それ以上になる場合は分割して下さい。<br><br>（もしくはここをクリックするとファイル選択ウインドウが表示されますのでそこで選択してもアップ可能です）",
    };
    
    // urlは実際に画像をアップロードさせるURLパスを入れる
    const token = '{{ csrf_token() }}';
    
    <?php
    // ローカルホストのチェック
    $isLocalhost = $_SERVER['SERVER_NAME'] == 'localhost' && $_SERVER['HTTP_HOST'] == 'localhost';
    ?>
    
    {{-- 画像のアップ先のパスの切り替え --}}
    @if (!$isLocalhost && config('original.image_upload_target') == 'PRODUCTION')
        const imageUploadUrl = "https://image.hondanet.co.jp/cgi/upload_img.php?id={{ $hanshaCode }}/{{ $tableType }}&time={{ $time }}";
    @else
        const imageUploadUrl = "{{ action_auto('Infobbs\CommonUploadController@postIndex', ['table_type' => $tableType]) }}";
    @endif
    
    const imageDeleteUrl = "{{ action_auto('Infobbs\InfobbsController@postDeleteImage') }}";
    myDropzone = new Dropzone("div#my-awesome-dropzone",{
        url: imageUploadUrl,
        method: 'post',
        // addRemoveLinks: true,
        params: {
            _token: token,
        },
        // アップする前、ファイル名のチェック
        renameFile: function (file) {
            console.log(file);
            let newName = encodeURI(file.name)
                    .replace(/%/g, '')
                    .replace(/\+/, '20');
            // 長さの制限
            const maxLength = 100;
            if (newName.length > maxLength) {
                const ext = file.name.replace(/^.*?\.([jJpPeEgGiIfFnN]+)$/, '$1');
                newName = newName.substring(0, maxLength) + '.' + ext;
            }
            return newName;
        },
        init: function () {
            this.on("complete", function (file) {
                /*if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                }*/
                let fileUrl = typeof file.xhr !== 'undefined' ? file.xhr.responseText : file.dataUrl;
                {{-- 画像のURLの切り替え --}}
                @if (!$isLocalhost && config('original.image_upload_target') == 'PRODUCTION')
                fileUrl = "https://image.hondanet.co.jp/cgi/{{ $hanshaCode }}/{{ $tableType }}/data/image/" + fileUrl;
                @endif

                if (fileUrl.match(/\/err\//)) {
                    // 一覧からファイルを削除
                    this.removeFile(file);
                    alert('サーバー側でエラーが発生しました。');
                    return;
                }

                @if ($textEditor == 'TINYMCE')
                    var media = tinymce.activeEditor.dom.createHTML('img', {src: fileUrl, style:'width:80%;display:block;', class:'mce-img'}, '');
                    tinymce.activeEditor.selection.setContent(media);
                    // let _ref = file.previewElement;
                    // $(_ref).attr('data-src', fileUrl);
                @elseif ($textEditor == 'NICEDIT')
                    removeArea2();
                    const filetag = '<img src="' + fileUrl + '" alt="" style="max-width:100%;"><br />\n';
                    const textval = $('#text-editor').val() + filetag;
                    $('#text-editor').val(textval);
                    addArea2();
                @endif
            });
            /** nicEditから画像を削除コマンド **/
            /*this.on("removedfile", function (file) {
                const fileUrl = typeof file.xhr !== 'undefined' ? file.xhr.responseText : file.dataUrl;
                const imgUrl = fileUrl;
                const data = {
                    _token: token,
                    name: file.name,
                    path: fileUrl,
                };
                const rel = fileUrl.replace(/^.+?\/([^\/]+\..+?)$/, '$1');
                $.post(imageDeleteUrl, data, function() {
                    $('.nicEdit-main').find('img[rel="' + rel + '"]').remove();
                });
            });*/
        }
    });
    
    //Add existing files into dropzone
    /*const existingImages = {!! json_encode($data['existing_images']) !!};
    
    const resizedataURL = function (data, wantedWidth, wantedHeight){
        return new Promise(async function(resolve,reject){

            // We create an image to receive the Data URI
            var img = document.createElement('img');

            // When the event "onload" is triggered we can resize the image.
            img.onload = function()
            {        
                // We create a canvas and get its context.
                var canvas = document.createElement('canvas');
                var ctx = canvas.getContext('2d');

                // We set the dimensions at the wanted size.
                canvas.width = wantedWidth;
                canvas.height = wantedHeight;

                // We resize the image with the canvas method drawImage();
                ctx.drawImage(this, 0, 0, wantedWidth, wantedHeight);

                var dataURI = canvas.toDataURL();

                // This is the return of the Promise
                resolve({
                    uri: dataURI,
                    file: data
                });
            };

            // We put the Data URI in the image's src attribute
            img.src = data.dataUrl;

        })
    };

    for (i = 0; i < existingImages.length; i++) {
        mockFile = existingImages[i];
        if (mockFile.size == 0) {
            continue;
        }
        
        resizedataURL(
            mockFile,
            myDropzone.options.thumbnailWidth, 
            myDropzone.options.thumbnailHeight
        ).then((data) => {
            myDropzone.files.push(data.file);
            myDropzone.emit("addedfile", data.file);
            myDropzone.emit('thumbnail', data.file, data.uri);
            $('.dz-progress').hide();
        });
    }*/
});
</script>
@stop
