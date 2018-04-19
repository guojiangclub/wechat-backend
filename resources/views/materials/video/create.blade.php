{{--@extends('wechat-backend::layouts.master')

@section ('title',  '素材管理 | 添加视频素材')

@section('after-styles-end')--}}
    {!! Html::style(env("APP_URL").'/assets/wechat-backend/libs/webuploader-0.1.5/webuploader.css') !!}
    {!! Html::style(env("APP_URL").'/assets/wechat-backend/libs/ladda/ladda-themeless.min.css') !!}
    {!! Html::style(env("APP_URL").'/assets/wechat-backend/css/common.css') !!}
    {!! Html::style(env("APP_URL").'/assets/wechat-backend/css/upload.css') !!}
{{--@stop


@section('breadcrumbs')--}}
    <h2>
        @if(session()->has('account_name'))
            <h2>{{wechat_name()}}</h2>
        @endif
    </h2>

    <ol class="breadcrumb">
        <li><a href="{{route('admin.wechat.index')}}"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li><a href="{{route('admin.wechat.material.index')}}"></i>素材管理</a></li>
        <li class="active">添加视频素材</li>
    </ol>
{{--@endsection

@section('content')--}}
    <div class="ibox float-e-margins">
        <div class="ibox-content" style="display: block;">
            <div class="row">
                <div class="panel-body">
                    {!! Form::open( [ 'url' => [route('admin.wechat.material.store_video')], 'method' => 'POST', 'id' => 'create-account-form','class'=>'form-horizontal'] ) !!}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">*视频标题：</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="title" placeholder=""/>
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('name','*描述介绍：', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-8">
                            <textarea class="form-control" name="description" rows="6"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('name','*上传视频：', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-8">
                            <div id="upload-video"  class="pull-left col-sm-4" style="margin-left:-10px;">
                                <span id="videouping"  data-style="expand-right"  class="ladda-button" type="submit" disabled >上传视频</span>
                            </div>
                            <div class="col-sm-4" style="height:35px;border:1px dashed #cccccc; display:none;" id="showvideo"><i class="fa fa-check"></i></div>
                        </div>
                    </div>

                    <input type="hidden" name="id" value="" id="video_id">
                    <input type="hidden" name="filename" value="" id="video_filename">




                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button  id="uping"  data-style="expand-right"  class="btn btn-primary ladda-button" type="submit" disabled >保存</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

{{--@stop

@section('after-scripts-end')--}}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/formvalidation/dist/js/formValidation.min.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/formvalidation/dist/js/framework/bootstrap.min.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/formvalidation/dist/js/language/zh_CN.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/webuploader-0.1.5/webuploader.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/ladda/spin.min.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/ladda/ladda.min.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/ladda/ladda.jquery.min.js') !!}
    <script>
        $(document).ready(function () {
            // 初始化Web Uploader
            var uploader = WebUploader.create({
                auto: true,
                swf: '{{url('libs/webuploader-0.1.5/Uploader.swf')}}',
                server: '{{route('admin.wechat.upload',['_token'=>csrf_token()])}}',
                pick: '#upload-video',
                fileVal: 'file',
                accept: {
                    title: 'Videos',
                    extensions: 'mp4',
                    mimeTypes: 'video/*'
                }
            })


            uploader.on( 'beforeFileQueued', function( file ) {
                var title=$('input[name=title]').val();
                var description=$('textarea[name=description]').val();
                if(title==""){
                    toastr.error('请填写视频标题');
                    window.location.reload();
                    return false;
                }
                if(description==""){
                    toastr.error('请填写描述介绍');
                    window.location.reload();
                    return false;
                }

            })


            // 当有文件被添加进队列的时候
            uploader.on( 'fileQueued', function( file ) {
                $('#videouping').ladda().ladda('start');
            })

            //上传成功
            uploader.on( 'uploadSuccess', function( file,data) {
                $('#showvideo').show();
                $('#showvideo').html(data.name+"<i class='fa fa-check'></i>");
                $('#video_id').val(data.id);
                $('#video_filename').val(data.filename);
                $('#videouping').ladda().ladda('stop');
                if($('#video_id').val()!==''&&$('#video_filename').val()!==''){
                    $("#uping").attr("disabled",false);
                }
            });

            $('input[name=title]').change(function () {
                console.log(1);
            })


        })

    </script>


{{--@stop--}}


