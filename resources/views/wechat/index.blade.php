@extends('wechat-backend::layouts.master')

@section ('title',  '微信管理 | 创建用户')

@section('breadcrumbs')
    @if(session()->has('account_name'))
        <h2>{{wechat_name()}}</h2>
    @endif
    <ol class="breadcrumb">
        <li><a href="{!!route('admin.wechat.index')!!}"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li>微信管理</li>
    </ol>
@endsection

@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-content" style="display: block;">
            <div class="row">
                <div class="panel-body">
                    其他需要展示的通知消息 图表数据等
                </div>
            </div>
        </div>
    </div>
@stop