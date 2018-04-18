<script>
// ------------------------------------------- 图片素材上传--------------------------------------
    $(document).ready(function () {
    // 初始化Web Uploader
    var uploader = WebUploader.create({
        auto: true,
        swf: '{{url('libs/webuploader-0.1.5/Uploader.swf')}}',
        server: '{{route('admin.wechat.upload',['_token'=>csrf_token()])}}',
        pick: '#upload-img',
        fileVal: 'file',
        accept: {
        title: 'Images',
        extensions: 'gif,jpg,jpeg,bmp,png',
        mimeTypes: 'image/*'
        }
    })

    // 当有文件被添加进队列的时候
    uploader.on( 'fileQueued', function( file ) {
    $('#imguping').ladda().ladda('start');
    })

    //上传成功
    uploader.on( 'uploadSuccess', function( file,data) {
    $('.delSearch').trigger("click");
    $('#imguping').ladda().ladda('stop');
    });
})
</script>