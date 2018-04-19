{{--@extends('wechat-backend::layouts.master')

@section ('title',  '卡券管理 | 卡券列表')

@section('breadcrumbs')
    <h2>卡券列表</h2>
    <ol class="breadcrumb">
        <li><a href="{!!route('admin.wechat.index')!!}"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li><a href="{!!route('admin.wechat.cards.index')!!}"></i>卡券管理</a></li>
        <li class="active">卡券列表</li>
    </ol>
@endsection




@section('content')--}}
    @if (session()->has('flash_notification.message'))
        <div class="alert alert-{{ session('flash_notification.level') }}">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! session('flash_notification.message') !!}
        </div>
    @endif

    <div class="tabs-container">
        <ul class="nav nav-tabs">
            <li class="active"><a href="">卡券列表
                    <span class="badge"></span></a></li>
        </ul>
        <div class="tab-content">

            <div id="tab-1" class="tab-pane active">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="btn-group">
                                <a class="btn btn-primary "
                                   href="{{route('admin.wechat.cards.create')}}">新建卡券</a>
                            </div>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <tbody>
                            <!--tr-th start-->
                            <tr>
                                <th>名称</th>
                                <th>CRAD_ID</th>
                                <th>操作</th>
                            </tr>
                            <!--tr-th end-->
                            @if(count($card)>0)
                                @foreach($card as $item)
                                    <tr>
                                        <td>{{$item->title}}</td>
                                        <td>{{$item->card_id}}</td>
                                        <td>
                                            <a class="btn btn-xs btn-primary"
                                               href="###">
                                                <i data-toggle="tooltip" data-placement="top"
                                                   class="fa fa-pencil-square-o"
                                                   title="编辑"></i></a>
                                            <a data-method="delete" class="btn btn-xs btn-danger"
                                               href="###">
                                                <i data-toggle="tooltip" data-placement="top"
                                                   class="fa fa-trash"
                                                   title="删除"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">
                                            <span class="empty_tips">
                                                暂无卡券
                                            </span>
                                    </td>
                                </tr>
                            @endif
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{--<div class="tabs-container">--}}
        {{--<div class="tab-content">--}}
            {{--<div id="tab-1" class="tab-pane active">--}}
                {{--<div class="panel-body">--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-md-6">--}}
                            {{--<div class="btn-group">--}}
                                {{--<a class="btn btn-primary " href="{{ route('admin.wechat.card.create') }}">新建卡券</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="hr-line-dashed"></div>--}}
                    {{--<div class="table-responsive">--}}
                        {{--<table class="table table-hover table-striped">--}}
                            {{--<tbody>--}}
                            {{--<!--tr-th start-->--}}
                            {{--<tr>--}}
                                {{--<th>名称</th>--}}
                                {{--<th>CRAD_ID</th>--}}
                                {{--<th>操作</th>--}}
                            {{--</tr>--}}
                            {{--<!--tr-th end-->--}}

                            {{--@foreach ($card as $item)--}}
                                {{--<tr>--}}
                                    {{--<td>{{$item->title}}</td>--}}
                                    {{--<td>{{$item->card_id}}</td>--}}
                                    {{--<td>--}}
                                        {{--<a--}}
                                                {{--class="btn btn-xs btn-primary"--}}
                                                {{--href="{{route('admin.positions.edit',['id'=>$item->id])}}">--}}
                                            {{--<i data-toggle="tooltip" data-placement="top"--}}
                                               {{--class="fa fa-pencil-square-o"--}}
                                               {{--title="编辑"></i></a>--}}


                                        {{--<a data-method="delete" class="btn btn-xs btn-danger"--}}
                                           {{--href="{{route('admin.wechat.card.delete',['id'=>$item->id])}}">--}}
                                            {{--<i data-toggle="tooltip" data-placement="top"--}}
                                               {{--class="fa fa-trash"--}}
                                               {{--title="删除"></i></a>--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                            {{--@endforeach--}}
                            {{--</tbody>--}}
                        {{--</table>--}}
                    {{--</div><!-- /.box-body -->--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--
@endsection--}}
