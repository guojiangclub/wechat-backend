{{--@extends('wechat-backend::layouts.master')

@section ('title',  '卡券管理 | 新建卡券')

@section('breadcrumbs')
    <h2>新建卡券</h2>
    <ol class="breadcrumb">
        <li><a href="{!!route('admin.wechat.index')!!}"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li><a href="{!!route('admin.wechat.cards.index')!!}"></i>卡券管理</a></li>
        <li>卡券列表</li>
        <li class="active">新建卡券</li>
    </ol>
@endsection

@section('after-styles-end')--}}
    {!! Html::style(env("APP_URL").'/assets/wechat-backend/libs/webuploader-0.1.5/webuploader.css') !!}
{{--@stop


@section('content')--}}
    <div class="tabs-container">
        <ul class="nav nav-tabs">
            <li class="active"><a aria-expanded="true" data-toggle="tab" href="#tab-1">基础信息</a></li>
            <li class=""><a aria-expanded="false" data-toggle="tab" href="#tab-2">高级设置</a></li>
            <li class=""><a aria-expanded="false" data-toggle="tab" href="#tab-3">积分规则</a></li>
        </ul>
        {!! Form::open( [ 'url' => [route('admin.wechat.cards.store')], 'method' => 'POST','id' => 'base-form','class'=>'form-horizontal'] ) !!}
        <div class="tab-content">
            <div id="tab-1" class="tab-pane active">
                <div class="panel-body">
                        @include('Wechat::card.includes.base')
                </div>
            </div>

            <div id="tab-2" class="tab-pane">
                <div class="panel-body">
                    @include('Wechat::card.includes.more')
                </div>
            </div>

            <div id="tab-3" class="tab-pane">
                <div class="panel-body">
                    @include('Wechat::card.includes.bonus_rule')
                </div>
            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group">
            <div class="col-sm-4 col-sm-offset-2">
                <button class="btn btn-primary" type="submit">保存设置</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>



{{--@endsection

@section('before-scripts-end')--}}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/jquery.form.min.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/webuploader-0.1.5/webuploader.js') !!}
{{--@stop

@section('after-scripts-end')--}}
    <script>
        $(function () {
            $('#base-form').ajaxForm({
                success: function (result) {
                    if(result.status)
                    {
                        swal({
                            title: "保存成功！",
                            text: "",
                            type: "success"
                        }, function() {
                            location = '{{route('admin.wechat.cards.index')}}';
                        });
                    }else{
                        swal('添加失败','','error');
                    }

                }
            });
        })
    </script>
{{--@stop--}}
