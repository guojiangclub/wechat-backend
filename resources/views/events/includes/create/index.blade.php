{{--@extends('wechat-backend::layouts.master')

@section ('title',  '自动回复 | 创建消息')

@section('after-styles-end')--}}
    {{--<!-- 引入样式 -->--}}
    {!! Html::style(env("APP_URL").'/assets/wechat-backend/libs/element/index.css') !!}
    {!! Html::style(env("APP_URL").'/assets/wechat-backend/css/reply.css') !!}
    {!! Html::style(env("APP_URL").'/assets/wechat-backend/libs/datepicker/bootstrap-datetimepicker.min.css') !!}
    {!! Html::style(env("APP_URL").'/assets/wechat-backend/libs/ladda/ladda-themeless.min.css') !!}
    {!! Html::style(env("APP_URL").'/assets/wechat-backend/libs/webuploader-0.1.5/webuploader.css') !!}
    <style>
        .el-radio .el-radio__label{
            display: none;
        }
    </style>
{{--@stop


@section('breadcrumbs')--}}
    @if(session()->has('account_name'))
        <h2>{{wechat_name()}}</h2>
    @endif
    <ol class="breadcrumb">
        <li><a href="{!!route('admin.wechat.index')!!}"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li><a href="">基本功能</a></li>
        <li><a href="{{route('admin.wechat.events.index',['m_type'=>1])}}">自动回复</a></li>
        @if(!isset($id))
            @if(empty(request('m_type'))||request('m_type')==1)
            <li class=" active">创建文本消息</li>
            @elseif(request('m_type')==2)
            <li class=" active">创建图片消息</li>
            @elseif(request('m_type')==3)
                <li class=" active">创建图文消息</li>
            @elseif(request('m_type')==4)
                <li class=" active">创建视频消息</li>
            @endif
         @else
            <li class=" active">编辑自动回复消息</li>
        @endif



    </ol>
{{--@endsection--}}



{{--@section('content')--}}
    @if(Session::has('message'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> 提示！</h4>
            {{ Session::get('message')}}
        </div>
    @endif


    <div class="tabs-container">
        @if(!isset($id))
        <ul class="nav nav-tabs" style="border:0">
            @if(empty(request('m_type')))
                <li class="active"><a href="{{route('admin.wechat.events.create',['m_type'=>1])}}">创建文本消息
                    </a></li>
            @else
                <li class="{{ Active::query('m_type',1) }}"><a href="{{route('admin.wechat.events.create',['m_type'=>1])}}">创建文本消息
                    </a>
                </li>
            @endif
            <li class="{{ Active::query('m_type',2) }}">
                <a href="{{route('admin.wechat.events.create',['m_type'=>2])}}">创建图片消息
                </a>
            </li>

            <li class="{{ Active::query('m_type',3) }}">
                <a href="{{route('admin.wechat.events.create',['m_type'=>3])}}">创建图文消息
                </a>
            </li>

            <li class="{{ Active::query('m_type',4) }}">
                <a href="{{route('admin.wechat.events.create',['m_type'=>4])}}">创建视频消息
                </a></li>

            <li class="{{ Active::query('m_type',6) }}">
                    <a href="{{route('admin.wechat.events.create',['m_type'=>4])}}">创建卡券消息
             </a></li>

        </ul>
        @endif


    </div>


        <div class="ibox-content" style="display: block;"  id="app">
            <div class="row">
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label text-right">*规则说明</label>
                            <div class="col-sm-8">
                                <input type="text" name="rule" id=""  v-model="rule"   class="form-control" placeholder="请输入规则说明">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label text-right">*关键字</label>
                            <div class="col-sm-8">
                                    <el-select class="col-sm-12" style="margin-left: -12px;"
                                        v-model="keyArr"
                                        multiple
                                        filterable
                                        allow-create
                                        placeholder="请输入关键字">
                                    </el-select>
                            </div>
                        </div>


                        @if(request('m_type')==1)
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label text-right">*文本内容</label>
                            <div class="col-sm-8">
                                {{ Widget::run('MaterialType','','text') }}
                                <textarea  name="" @if(isset($id))
                                        disabled="disabled"
                                @endif class="col-sm-12"  ccols="30" rows="10" v-model="decodeURI(data_text)" v-text="data_text"  disabled="disabled"></textarea>
                                {{--<i class="fa fa-times-circle" id="delImg" style="font-size: 20px;position: absolute;left:295px;" @click="delData()" v-if="type=='text'&&data_text&&selected?true:false"></i>--}}
                            </div>
                            <div class="col-sm-4">
                                <a  target="_blank" href="{{route('admin.wechat.material.create_text')}}"  data-style="expand-right"  class="btn btn-info" style="position: relative;top:-255px;left: 380px;">添加文本素材</a>
                            </div>
                        </div>
                         @endif


                        @if(request('m_type')==2)
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label text-right">*图片</label>
                                <div class="col-sm-8">
                                    {{ Widget::run('MaterialType','','image') }}
                                </div>
                            </div>
                        @endif

                        @if(request('m_type')==3)
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label text-right">*图文</label>
                                <div class="col-sm-8">
                                    {{ Widget::run('MaterialType','','article') }}
                                </div>
                            </div>
                        @endif

                        @if(request('m_type')==4)
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label text-right">*视频</label>
                                <div class="col-sm-8">
                                    {{ Widget::run('MaterialType','','video') }}
                                </div>
                            </div>
                        @endif


                        @if(request('m_type')==6)
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label text-right">*微信卡券ID</label>
                                <div class="col-sm-8">
                                    <input type="text" name="value" id=""  v-model="value"   class="form-control" placeholder="微信卡券ID">
                                </div>
                            </div>
                        @endif



                    </div>
                    @if(!empty(request('m_type')))
                    <div class="hr-line-dashed"></div>
                    <br>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button  data-style="expand-right"  class="btn btn-primary ladda-button" type="submit" @click="messageSubmit({{request('m_type')}})">保存</button>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>


{{--@endsection


@section('after-scripts-end')--}}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/datepicker/bootstrap-datetimepicker.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/datepicker/bootstrap-datetimepicker.zh-CN.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/element/vue.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/element/index.js') !!}
    <script>
        var materialApi="{{route('admin.wechat.material.api')}}";
        var storeApi="{{route('admin.wechat.events.store')}}";
        var locationUrl="{{route('admin.wechat.events.index',['m_type'=>'#'])}}";
        var editGetDataUrl="{{route('admin.wechat.events.api.edit',['id'=>'#'])}}";
        var updateApi="{{route('admin.wechat.events.update',['id'=>'#'])}}";
        var editId="{{isset($id)?$id:''}}";
        var action="{{isset($material['data_type'])?2:1}}";
        var data_title="{{isset($material['data_title'])?$material['data_title']:''}}";
        var data_time="{{isset($material['data_time'])?$material['data_time']:''}}";
        var data_img="{{isset($material['data_img'])?$material['data_img']:''}}";
        var data_type="{{isset($material['data_type'])?$material['data_type']:''}}";
        var data_selected="{{isset($material['data_selected'])?$material['data_selected']:''}}"
        var stime="";
        var etime="";
        var m_type="{{$m_type}}";
    </script>
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/webuploader-0.1.5/webuploader.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/ladda/spin.min.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/ladda/ladda.min.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/toastr/toastr.min.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/ladda/ladda.jquery.min.js') !!}

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

            //保存




        });
    </script>


    @include('Wechat::widgets.image_uploader_script')
    @include('Wechat::events.includes.create.script')
{{--@endsection--}}








