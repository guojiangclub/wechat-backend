@extends('wechat-backend::layouts.master')

@section ('title',  '粉丝管理 | 粉丝列表')

@section('breadcrumbs')
    <h2>粉丝列表</h2>
    <ol class="breadcrumb">
        <li><a href="{!!route('admin.wechat.index')!!}"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li><a href="{!!route('admin.wechat.fans.index')!!}"></i>粉丝管理</a></li>
        <li class="active">粉丝列表</li>
    </ol>
    @endsection


    @section('after-styles-end')
    {!! Html::style(env("APP_URL").'/assets/wechat-backend/libs/datepicker/bootstrap-datetimepicker.min.css') !!}
    {!! Html::style(env("APP_URL").'/assets/wechat-backend/libs/webuploader-0.1.5/webuploader.css') !!}
    {!! Html::style(env("APP_URL").'/assets/wechat-backend/libs/ladda/ladda-themeless.min.css') !!}
    {!! Html::style(env("APP_URL").'/assets/wechat-backend/css/fans.css') !!}
            <!-- 引入样式 -->
    {!! Html::style(env("APP_URL").'/assets/wechat-backend/libs/element/index.css') !!}
    <style>

        .el-tag + .el-tag {
            margin-left: 10px;
        }
        .button-new-tag {
            margin-left: 10px;
            height: 32px;
            line-height: 30px;
            padding-top: 0;
            padding-bottom: 0;
        }
        .input-new-tag {
            width: 90px;
            margin-left: 10px;
            vertical-align: bottom;
        }

        #allck1{
            opacity: 0;
        }
        #allck2{
            opacity: 0;
        }
        .user-info-box .el-checkbox__label{
            display: none;
        }
        #textModal td{
            line-height: 50px;
        }
        #textModal th{
            line-height: 50px;
        }

    </style>
@stop

<style>
    .Switch{
        background:#f4f5f9;
    }
</style>


@section('content')
    @if (session()->has('flash_notification.message'))
        <div class="alert alert-{{ session('flash_notification.level') }}">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! session('flash_notification.message') !!}
        </div>
    @endif



    <div class="tabs-container" id="app">
        <ul class="nav nav-tabs">
            <li class="active"><a href="">粉丝列表
                    <span class="badge">{{$count}}</span></a></li>
        </ul>
        <div class="tab-content">
            <div id="tab-1" class="tab-pane active">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <p>
                                        <i class="fa fa-info-circle"></i>注意<br>
                                        1.粉丝数量过多时同步数据请耐心等待<br>
                                        2.上次同步时间：
                                        @if(!empty($pull_time))
                                            <span class="badge badge-success">{{date('Y-m-d H:s:i',$pull_time)}}</span>
                                        @else
                                            <span class="badge badge-info">未同步</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="btn-group">
                                {!! Form::open(['route' => 'admin.wechat.fans.PullFans', 'class' => 'form-horizontal',
                                    'role' => 'form', 'method' => 'post','id'=>'release']) !!}
                                <button class="btn btn-success"   id="release">
                                    <span id="releasebtn" data-style="expand-right"  class="ladda-button">同步粉丝</span>
                                </button>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="wrapper wrapper-content animated fadeInRight" id="fans">
                        <div class="row">
                            <div class="fans-box" style="margin-top: -40px;">
                                <div class="fans-form clearfix">
                                    <div class="fans-left col-md-9">
                                        <div class="fans-left-top clearfix">
                                            <div class="col-lg-4 col-md-4 fans-all">
                                                <button type="button" class="btn btn-success" id="set-label-button" @click="searchFansAll()">全部粉丝</button>
                                                <button type="button" class="btn btn-success" id="set-group-button" @click="setGroup">设置标签组</button>
                                                {{--<input type="checkbox" id="all">--}}
                                                {{--<label for="all">--}}
                                                {{--全选--}}
                                                {{--</label>--}}
                                            </div>
                                            <div class="clearfix import-box">
                                                {{--<select class=" select-item form-control select-time">--}}
                                                {{--<option value="time">关注时间</option>--}}
                                                {{--<option value="active">活跃度</option>--}}
                                                {{--<option value="speak">最后发言时间</option>--}}
                                                {{--</select>--}}
                                                <div class="row">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control search-input" placeholder="昵称" name="nickname" value="" v-model="nickname"  >
                                                                            <span class="input-group-btn">
                                                                                <button  style="margin-right:20px;height: 34px;" class="btn btn-default" id="search" type="button" @click="searchFans()">
                                                                                <i class="fa fa-search"></i>
                                                                                </button>
                                                                            </span>
                                                    </div><!-- /.col-lg-6 -->
                                                </div><!-- /.row -->



                                            </div>
                                        </div>
                                        <div class="fans-list">

                                            <div class="no-user">
                                                <i class="fa fa-exclamation-circle"></i><span>无用户</span>
                                            </div>

                                            <div class="user-list row">
                                                <img src="{{env("APP_URL").'/assets/wechat-backend/img/loading.gif'}}" alt="" id="loading" style="margin-left: 600px;">
                                                @include('wechat-backend::fans.includes.fans-list')
                                            </div>

                                            <div class="modal fade" id="textModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" @click="Location" >
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="margin-bottom: 10px;">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                            <div class="have-material clearfix">
                                                                <div class="material-table clearfix">
                                                                    <div class="loading" style="margin-left:400px;margin-top:120px;height:280px;">
                                                                        <img src="{{env("APP_URL").'/assets/wechat-backend/img/loading.gif'}}" alt="">
                                                                    </div>
                                                                    <table class="table table-striped table-bordered table-hover">
                                                                        <thead>
                                                                        <tr>
                                                                            <th class="col-md-6">OpenId</th>
                                                                            <td class="td-text">{#info.openid#}</td>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr>
                                                                            <th class="col-md-6">昵称</th>
                                                                            <td class="td-text">{#decodeURI(info.nickname)#}</td>
                                                                        </tr>
                                                                        </tbody>

                                                                        <thead>
                                                                        <tr>
                                                                            <th class="col-md-6" >头像</th>
                                                                            <td class="td-text" v-if="info.avatar">
                                                                                <a :href="info.avatar" target="-_blank">
                                                                                    <img :src="info.avatar" alt="" width="50" height="50">
                                                                                </a>
                                                                            </td>
                                                                            <td class="td-text"  v-else></td>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        {{--<tr>--}}
                                                                        {{--<th class="col-md-6">性别</th>--}}
                                                                        {{--<td class="td-text">{#info.sex#}</td>--}}
                                                                        {{--</tr>--}}
                                                                        </tbody>

                                                                        <thead>
                                                                        <tr>
                                                                            <th class="col-md-6">地区</th>
                                                                            <td class="td-text" ><span>{#info.country#}</span>&nbsp;&nbsp;&nbsp;<span>{#info.city#}</span></td>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr>
                                                                            <th class="col-md-6">关注时间</th>
                                                                            <td class="td-text" ><span>{#info.subscribed_at#}</span></td>
                                                                        </tr>
                                                                        </tbody>


                                                                        <thead>
                                                                        {{--<tr>--}}
                                                                        {{--<th class="col-md-6">最后活跃时间</th>--}}
                                                                        {{--<td class="td-text"  v-if="info.last_online_at">{#info.last_online_at#}</td>--}}
                                                                        {{--<td class="td-text"  v-else></td>--}}
                                                                        {{--</tr>--}}
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr>
                                                                            <th class="col-md-6">标签</th>
                                                                            <td class="td-text"  v-if="dynamicTags">

                                                                                <el-tag
                                                                                        :key="tag"
                                                                                        v-for="( tag,index) in dynamicTags"
                                                                                        closable
                                                                                        :disable-transitions="false"
                                                                                        @close="handleClose(tag.group_id,info.openid, index)"

                                                                                >
                                                                                    {#tag.title#}
                                                                                </el-tag>
                                                                                <el-input
                                                                                        class="input-new-tag"
                                                                                        v-if="inputVisible"
                                                                                        v-model="inputValue"
                                                                                        ref="saveTagInput"
                                                                                        size="small"
                                                                                        @keyup.enter.native="handleInputConfirm"
                                                                                        @blur="handleInputConfirm"
                                                                                >
                                                                                </el-input>
                                                                                {{--<el-button v-else class="button-new-tag" size="small" @click="showInput">创建新标签</el-button>--}}


                                                                            </td>
                                                                            <td class="td-text"  v-else></td>
                                                                        </tr>
                                                                        </tbody>

                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal -->
                                            </div>

                                            <!--分页-->
                                            <div class="block pull-right" v-if="fans.length">
                                                <span class="demonstration"></span>
                                                <el-pagination
                                                @current-change="handleCurrentChange"
                                                layout="prev, pager, next"
                                                :total="total"
                                                :current-page="currentPage"
                                                :page-size="pageSize"
                                                >
                                                </el-pagination>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="fans-right col-md-3">
                                        <div class="grouping-top clearfix">
                                            <span class="col-lg-8 col-md-9"style="font-size: 16px">标签组</span>
                                                    <span class="col-lg-4 col-md-3 add-group" id="add-group-button">
                                                         <i class="fa fa-plus" @click="createGroup()"></i>
                                                     </span>
                                            <!-- 设置标签组模态框（Modal） -->
                                            <div class="modal fade" id="SetGroup" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="margin-top: 200px;">
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                            <p class="modal-title">
                                                                设置标签组
                                                            </p>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="set-box">
                                                                <select class="select-item form-control set-group"  v-model="select_group"  v-if="groups.length">
                                                                    <option
                                                                            v-for="item in groups"
                                                                            :value="item.group_id"
                                                                    >
                                                                        {#item.title#}
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                                                            </button>
                                                            <button type="button" class="btn btn-primary" id="submit-set-group-info" @click="submitSetGroupInfo">
                                                            确定
                                                            </button>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal -->
                                            </div>
                                        </div>
                                        <div class="grouping-list clearfix">
                                            <ul class="clearfix" id="group-ul">
                                                <li class="clearfix group-li group-li-show" style="display: none"  v-show="groups.length"  v-for="(item,index) in groups" :data-group_id="item.group_id"  @click="switchGroup(item.group_id)"
                                                :class="{Switch:switchShow(item.group_id)}"
                                                >
                                                <span class="group-list-name col-lg-7">{#item.title#}</span>
                                                <div class="col-lg-5 group-right">
                                                    <span class="user-num ">{#item.fan_count#}</span>
                                                                        <span class="actions">
                                                                             <span v-if="item.group_id>=100"   class="compile" @click="editGroup(item.group_id,item.title)"   ><i class="fa fa-pencil-square-o"></i>编辑</span>
                                                    <span v-if="item.group_id>=100"  class="delete"   @click="delGroup(item.group_id)"  ><i class="fa fa-times-circle-o"></i>删除</span>
                                                    </span>
                                                </div>
                                                </li>



                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>




    {{--<div class="modal fade" id="AddGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">--}}
    {{--<div class="modal-dialog modal-sm">--}}
    {{--<div class="modal-content">--}}
    {{--<div class="modal-header">--}}
    {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">--}}
    {{--<i class="fa fa-times"></i>--}}
    {{--</button>--}}
    {{--<p class="modal-title">--}}
    {{--添加分组--}}
    {{--</p>--}}
    {{--</div>--}}
    {{--<div class="modal-body">--}}
    {{--<div class="add-group">--}}
    {{--<span>分组名称 ：</span>--}}
    {{--<input type="text" class="form-control group-name" >--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="modal-footer">--}}
    {{--<button type="button" class="btn btn-default" data-dismiss="modal">关闭--}}
    {{--</button>--}}
    {{--<button type="button" class="btn btn-primary confirm" data-id="0">--}}
    {{--确定--}}
    {{--</button>--}}
    {{--</div>--}}
    {{--</div><!-- /.modal-content -->--}}
    {{--</div><!-- /.modal -->--}}
    {{--</div>--}}



            <!-- 设置标签模态框（Modal） -->
    <div class="modal fade" id="SetLabel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="fa fa-times"></i>
                    </button>
                    <p class="modal-title">
                        设置标签
                    </p>
                </div>
                <div class="modal-body">
                    <div class="set-box">
                        <select class=" select-item form-control set-label">

                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                    </button>
                    <button type="button" class="btn btn-primary" id="submit-set-label-info">
                        确定
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>


@endsection

@section('before-scripts-end')
    <script>
        var moveUsers="{{route('admin.wechat.fans.move.users')}}";
        var getInfo="{{route('admin.wechat.fans.info','#')}}";
        var fansApi="{{route('admin.wechat.fans.api')}}";
        var storeFansGroup="{{route('admin.wechat.fans.group.store')}}"
        var delFansGroup="{{route('admin.wechat.fans.group.del')}}"
        var editFansGroup="{{route('admin.wechat.fans.group.update')}}"
        var stime="";
        var etime="";
        var moveTag="{{route('admin.wechat.fans.move.tag')}}"

    </script>
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/datepicker/bootstrap-datetimepicker.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/datepicker/bootstrap-datetimepicker.zh-CN.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/element/vue.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/element/index.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/ladda/spin.min.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/ladda/ladda.min.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/ladda/ladda.jquery.min.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/js/common.js') !!}

    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/webuploader-0.1.5/webuploader.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/ladda/ladda.jquery.min.js') !!}

    @include('wechat-backend::fans.includes.script')
    <script>
        $(function () {

            $('.form_datetime').datetimepicker({
                minView: 0,
                format: "yyyy-mm-dd hh:ii",
                autoclose: 1,
                language: 'zh-CN',
                weekStart: 1,
                todayBtn: 1,
                todayHighlight: 1,
                startView: 2,
                forceParse: 0,
                showMeridian: true,
                minuteStep: 1,
                maxView: 4
            });

//            开始
            $('.form_datetime_stime').on('changeDate', function (ev) {
                stime = timeDate(ev.date);
            })
//            截止
            $('.form_datetime_etime').on('changeDate', function (ev) {
                etime = timeDate(ev.date);
            })
            function timeDate(d) {
                var date = (d.getFullYear()) + "-" +
                        (d.getMonth() + 1) + "-" +
                        (d.getDate()) + " " +
                        (d.getHours()) + ":" +
                        (d.getMinutes());
                return date;
            }

            $('.delSearch').click(function () {
                $('.form_datetime_stime input').val('');
                $('.form_datetime_etime input').val('');
            });
            $('.material_btn').click(function () {
                $('.form_datetime_stime input').val('');
                $('.form_datetime_etime input').val('');
            })



            $('#release').ajaxForm({
                beforeSubmit:function () {
                    $('#releasebtn').ladda().ladda('start');
                },
                success: function (result) {
                    if (!result.status) {
                        swal("同步失败!", result.message, "error")
                    } else {
                        swal({
                            title: "同步成功！",
                            text: "",
                            type: "success"
                        }, function () {
                            $('#releasebtn').ladda().ladda('stop');
                            location = '{!!route('admin.wechat.fans.index')!!}'
                        });
                    }

                }

            });
        })
    </script>
@stop
