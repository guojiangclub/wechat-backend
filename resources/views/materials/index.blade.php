{{--@extends('wechat-backend::layouts.master')

@section ('title',  '基本功能 | 素材管理')

@section('after-styles-end')--}}
    {{--<!-- 引入element-ui样式 -->--}}
    {!! Html::style(env("APP_URL").'/assets/wechat-backend/libs/element/index.css') !!}
    {!! Html::style(env("APP_URL").'/assets/wechat-backend/libs/webuploader-0.1.5/webuploader.css') !!}
    {!! Html::style(env("APP_URL").'/assets/wechat-backend/libs/ladda/ladda-themeless.min.css') !!}
    {!! Html::style(env("APP_URL").'/assets/wechat-backend/css/upload.css') !!}
    <style>
        .picture_action span{ width:50%; float:left; height:40px; line-height:40px; text-align:center; color:#888; background:#eee;cursor:pointer }
        .picture_action span:hover{ background:#ddd;}

        .appmsg_action span{ width:50%; float:left; height:40px; line-height:40px; text-align:center; color:#888; background:#eee;cursor:pointer }
        .appmsg_action span:hover{ background:#ddd;}
    </style>
{{--@stop


@section('breadcrumbs')--}}
    @if(session()->has('account_name'))
        <h2>{{wechat_name()}}</h2>
    @endif
    <ol class="breadcrumb">
        <li><a href="{!!route('admin.wechat.index')!!}"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li class=" active"><a href="">素材管理</a></li>
    </ol>
{{--@endsection



@section('content')--}}
    @if(Session::has('message'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> 提示！</h4>
            {{ Session::get('message')}}
        </div>
    @endif

    <div class="tabs-container">
        {{--'article','image', 'voice', 'video','text'--}}
        <ul class="nav nav-tabs">
            @if(empty(request('type')))
                <li class="active"><a href="{{route('admin.wechat.material.index',['type'=>1])}}">图片素材
                        <span class="badge">{{$countImage}}</span>
                    </a>
                </li>
            @else
                <li class="{{ Active::query('type',1) }}"><a href="{{route('admin.wechat.material.index',['type'=>1])}}">图片素材
                        <span class="badge">{{$countImage}}</span>
                    </a>
                </li>
            @endif
            <li class="{{ Active::query('type',2) }}">
                <a href="{{route('admin.wechat.material.index',['type'=>2])}}">视频素材
                    <span class="badge">{{$countVideo}}</span>
                  </a>
            </li>
                  <li class="{{ Active::query('type',4) }}"><a href="{{route('admin.wechat.material.index',['type'=>4])}}">图文素材
                      <span class="badge">{{$countArticle}}</span>
                </a>
            </li>

            <li class="{{ Active::query('type',5) }}"><a href="{{route('admin.wechat.material.index',['type'=>5])}}">文本素材
                    <span class="badge">{{$countText}}</span>
                </a></li>
        </ul>

        <input type="button"  class="upload-success"  @click="getData()" style="display: none">
        @include('Wechat::materials.show')

    </div>
{{--@endsection


@section('after-scripts-end')--}}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/jquery.zclip/jquery.zclip.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/webuploader-0.1.5/webuploader.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/ladda/spin.min.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/ladda/ladda.min.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/ladda/ladda.jquery.min.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/datepicker/bootstrap-datetimepicker.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/datepicker/bootstrap-datetimepicker.zh-CN.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/ladda/ladda.jquery.min.js') !!}
    <script>
        var type="{{$type}}";
        var materialApi="{{route('admin.wechat.material.api')}}";
        var delApi="{{route('admin.wechat.material.delete','#')}}"
        var editArticleApi="{{route('admin.wechat.material.edit.article','#')}}"

    </script>
    @include('wechat-backend::materials.script')
    <script>
        // 初始化Web Uploader图片上传
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

            //图片上传成功
            uploader.on( 'uploadSuccess', function( file,data) {
                if(data.id){
                    var src=data.source_url;
                    $('.upload-success').trigger("click");
                }
                $('#imguping').ladda().ladda('stop');
                location.reload();

            });

//            同步图片素材
            {{--href="{{route('admin.wechat.material.pull',['type'=>1])}}"--}}
            $('#pullImage').on('click',function () {
                $('#pullImage').ladda().ladda('start');
                var _token=$('meta[name="_token"]').attr('content');
                var href="{{route('admin.wechat.material.pull')}}";
                $.ajax({
                    type:"get",
                    url:href,
                    data:{'_token':_token},
                    success:function(res){
                        if(res==1){
                            $('#pullImage').ladda().ladda('stop');
                            swal({
                                title: "同步成功",
                                text: "",
                                type: "success"
                            }, function () {
                                location = "{{route('admin.wechat.material.index',['type'=>1])}}";
                            });
                        }
                    }
                });
            })



        })
    </script>
{{--@endsection--}}








