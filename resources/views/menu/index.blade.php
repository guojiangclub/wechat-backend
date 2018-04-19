{{--@extends('wechat-backend::layouts.master')

@section ('title',  '微信管理 | 创建菜单')

@section('breadcrumbs')
    @if(session()->has('account_name'))
        <h2>{{wechat_name()}}</h2>
    @endif
    <ol class="breadcrumb">
        <li><a href="{!!route('admin.wechat.index')!!}"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li>基本功能</li>
        <li>自定义菜单</li>
    </ol>
@endsection--}}


{{--@section('after-styles-end')--}}
    {!! Html::style(env("APP_URL").'/assets/wechat-backend/css/menu.css') !!}
{{--@stop

@section('content')--}}
    <div class="ibox float-e-margins">
        <div class="ibox-content" style="display: block;">
            <div class="row">
                @if (session()->has('flash_notification.message'))
                    <div class="alert alert-{{ session('flash_notification.level') }}">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {!! session('flash_notification.message') !!}
                    </div>
                @endif

                <div class="panel-body">
                    <div class="wrapper wrapper-content animated fadeInRight" id="menu">
                        <div class="row">
                            <div class="col-md-12" style="margin-left:30px;">
                                <p>
                                    <i class="fa fa-info-circle"></i>注意<br>
                                    1.自定义菜单最多包括3个一级菜单，每个一级菜单最多包含5个二级菜单。<br>
                                    2.创建或编辑菜单不会马上被用户看到，只有点击发布菜单按钮才会更新到微信菜单，请放心调试。<br>
                                    3.发布成功后请稍等几分钟后测试微信菜单（或取消关注后再关注公众号）<br>
                                    @if(!empty($push_time))
                                    4.最近发布时间：
                                        <span class="badge badge-success">{{date('Y-m-d H:s:i',$push_time)}}</span>
                                    @endif
                                </p>
                                 <div>
                                    {!! Form::open(['route' => 'admin.wechat.menu.release', 'class' => 'form-horizontal',
                                       'role' => 'form', 'method' => 'post','id'=>'release']) !!}
                                    <button type="submit" class="btn btn-success" id="release">发布菜单</button>
                                    {!! Form::close() !!}
                                 </div>

                            </div>

                        </div>
                        <div class="mennu-box">
                            <div class="clearfix">
                                <div class="phone">
                                    <div class="frame">
                                        <div class="wx-menu">
                                            <div class="keyboard"></div>
                                            <div class="menu">
                                                        @if(count($menus)>0)
                                                            @foreach($menus as $item)
                                                            <div>
                                                                <div
                                                                        @if(isset($item['child'])&&count($item['child'])>0)
                                                                        class="fat_menu"
                                                                        @endif
                                                                >
                                                                    <P>{{$item['name']}}</P>
                                                                    @if(isset($item['child'])&&count($item['child'])>0)
                                                                    <div class="sub_menu">
                                                                        @foreach($item['child'] as $citem)
                                                                        <p>{{$citem['name']}}</p>
                                                                        @endforeach
                                                                    </div>
                                                                     @endif
                                                                </div>
                                                            </div>
                                                                @endforeach
                                                           @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="menu-list">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                        <tr>
                                            <th class="add">
                                                <a class="btn btn-xs btn-primary"
                                                   href="{{route('admin.wechat.menu.create')}}">
                                                    <i data-toggle="tooltip" data-placement="top"
                                                       class="fa fa-plus"
                                                       title="添加一级菜单"></i>添加一级菜单</a>
                                            </th>
                                            <th class="operation">操作</th>
                                            <th class="operation">排序(越到越靠前)</th>
                                        </tr>
                                        </thead>
                                        <tbody>


                                        @if(count($menus)>0)
                                                @foreach($menus as $item)
                                                    <tr>
                                                            <td>
                                                               &nbsp;&nbsp;<a  class="btn btn-xs btn-primary add-two-menu"
                                                                               href="{{route('admin.wechat.menu.create',['pid'=>$item['id']])}}">
                                                                    <i data-toggle="tooltip" data-placement="top"
                                                                       class="fa fa-plus"
                                                                       title="添加二级菜单"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;{{$item['name']}}
                                                            </td>
                                                            <td class="action-tools">
                                                                <a class="btn btn-xs btn-primary"
                                                                   href="{{route('admin.wechat.menu.edit',['id'=>$item['id']])}}">
                                                                    <i data-toggle="tooltip" data-placement="top"
                                                                       class="fa fa-pencil-square-o"
                                                                       title="编辑"></i></a>
                                                                <a data-method="delete" class="btn btn-xs btn-danger"
                                                                   href="{{route('admin.wechat.menu.delete',$item['id'])}}">
                                                                    <i data-toggle="tooltip" data-placement="top"
                                                                       class="fa fa-trash"
                                                                       title="删除"></i></a>
                                                            </td>
                                                            <td class="action-tools">
                                                                <span class="label label-default">{{$item['sort']}}</span>
                                                            </td>
                                                        </tr>

                                                    @if(isset($item['child'])&&count($item['child'])>0)
                                                        @foreach($item['child'] as $citem)
                                                            <tr   class='second-menu'>
                                                                <td>
                                                                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$citem['name']}}
                                                                </td>
                                                                <td class="action-tools">
                                                                    <a class="btn btn-xs btn-primary"
                                                                       href="{{route('admin.wechat.menu.edit',['id'=>$citem['id']])}}">
                                                                        <i data-toggle="tooltip" data-placement="top"
                                                                           class="fa fa-pencil-square-o"
                                                                           title="编辑"></i></a>
                                                                    <a data-method="delete" class="btn btn-xs btn-danger"
                                                                       href="{{route('admin.wechat.menu.delete',$citem['id'])}}">
                                                                        <i data-toggle="tooltip" data-placement="top"
                                                                           class="fa fa-trash"
                                                                           title="删除"></i></a>
                                                                </td>
                                                                <td class="action-tools">
                                                                    <span style="margin-left: 50px;" class="label label-default">{{$citem['sort']}}</span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                             @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{--<div class="issue">--}}
                                {{--{!! Form::open(['route' => 'admin.wechat.menu.release', 'class' => 'form-horizontal',--}}
                                    {{--'role' => 'form', 'method' => 'post','id'=>'release']) !!}--}}
                                {{--<button type="submit" class="btn btn-success" id="release">发布</button>--}}
                                {{--{!! Form::close() !!}--}}
                            {{--</div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{--@stop

@section('before-scripts-end')--}}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/js/common.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/js/menu.js') !!}
    @include('wechat-backend::menu.script')
    <script>
        $(function () {
            $('#release').ajaxForm({
                success: function (result) {
                    if (!result.status) {
                        swal("发布失败!", result.message, "error")
                    } else {
                        swal({
                            title: "发布成功！",
                            text: "",
                            type: "success"
                        }, function () {
                            location = '{!!route('admin.wechat.menu.index')!!}'
                        });
                    }

                }

            });
        })
    </script>
{{--@stop--}}
