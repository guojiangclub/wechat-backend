@extends('wechat-backend::layouts.master')

@section ('title',  '微信二维码管理')

@section('after-styles-end')
    {{--<!-- 引入element-ui样式 -->--}}
    {{--{!! Html::style(env("APP_URL").'/assets/wechat-backend/libs/element/index.css') !!}--}}
    {!! Html::style(env("APP_URL").'/assets/wechat-backend/libs/element/index.css') !!}

    {!! Html::style(env("APP_URL").'/assets/wechat-backend/libs/webuploader-0.1.5/webuploader.css') !!}
    {!! Html::style(env("APP_URL").'/assets/wechat-backend/libs/ladda/ladda-themeless.min.css') !!}
    {!! Html::style(env("APP_URL").'/assets/wechat-backend/css/upload.css') !!}
@stop


@section('breadcrumbs')
    @if(session()->has('account_name'))
        <h2>{{wechat_name()}}</h2>
    @endif
    <ol class="breadcrumb">
        <li><a href="{!!route('admin.wechat.index')!!}"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li><a href="">二维码管理</a></li>
        <li class=" active">二维码列表</li>
    </ol>
@endsection



@section('content')
    @if(Session::has('message'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> 提示！</h4>
            {{ Session::get('message')}}
        </div>
    @endif

    <div class="tabs-container">
        <ul class="nav nav-tabs">
            @if(empty(request('type')))
                <li class="active"><a href="{{route('admin.wechat.QRCode.index',['type'=>2])}}">永久二维码&nbsp;<span class="badge">{{$forever_count}}</span>                    </a></li>
            @else
                <li class="{{ Active::query('type',2) }}"><a href="{{route('admin.wechat.QRCode.index',['type'=>2])}}">永久二维码 &nbsp; <span class="badge">{{$forever_count}}</span>
                    </a>
                </li>
            @endif
            <li class="{{ Active::query('type',1) }}">
                <a href="{{route('admin.wechat.QRCode.index',['type'=>1])}}">临时二维码 &nbsp;<span class="badge">{{$temporary_count}}</span>
                </a>
            </li>
        </ul>

        <div class="tab-content" >
            <div class="tab-pane active" role="tabpanel" >
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-10">
                            <a class=" btn-primary btn btn-sm" style="margin-left:30px;"  href="{{route('admin.wechat.QRCode.create')}}">创建二维码</a>
                        </div>
                        <div class="input-group col-md-2">
                            <input type="text" class="form-control search-input" placeholder="场景名称" name="key" value="">
                            <span class="input-group-btn">
                                <button  style="margin-right:20px;height: 34px;" class="btn btn-default" id="search" type="button">
                                                <i class="fa fa-search" ></i>
                                </button>
                        </span>

                        </div>
                    </div>

                    <div class="row">
                        @if($type==2)
                          @include('Wechat::QRCode.includes.forever')
                        @else
                            @include('Wechat::QRCode.includes.temporary')
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection


@section('after-scripts-end')
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/webuploader-0.1.5/webuploader.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/ladda/spin.min.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/ladda/ladda.min.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/toastr/toastr.min.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/ladda/ladda.jquery.min.js') !!}
    <script>
        var ScansApi="{{route('admin.wechat.QRCode.scans',['ticket'=>'#'])}}"
        var CodesApi="{{route('admin.wechat.QRCode.api')}}"
        var deleteApi="{{route('admin.wechat.QRCode.delete',['id'=>'#'])}}"
        var editApi="{{route('admin.wechat.QRCode.edit',['id'=>'#'])}}";

        var type="{{$type}}"
    </script>
    @include('Wechat::QRCode.includes.script')
@endsection










