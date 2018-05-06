{!! Html::style(env("APP_URL").'/assets/wechat-backend/libs/element/index.css') !!}
{!! Html::style(env("APP_URL").'/assets/wechat-backend/libs/ladda/ladda-themeless.min.css') !!}
{!! Html::style(env("APP_URL").'/assets/wechat-backend/libs/datepicker/bootstrap-datetimepicker.min.css') !!}
    <style>
        .el-checkbox__label {
            display: none;
        }
    </style>
@if (session()->has('flash_notification.message'))
    <div class="alert alert-{{ session('flash_notification.level') }}">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {!! session('flash_notification.message') !!}
        </div>
@endif
<div class="tabs-container">
        <ul class="nav nav-tabs">
            <li class="active"><a href="">发送模板消息
                    <span class="badge"></span></a></li>
        </ul>
        <div class="tab-content" id="app">
            <div id="tab-1" class="tab-pane active">
                <div class="panel-body">
                    {{--<div class="hr-line-dashed"></div>--}}
                    <div class="form-horizontal" id="base-form">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">例子：</label>

                            <div class="col-sm-4">
                                <textarea disabled="disabled" style="width: 100%;" rows="12">{{isset($notice['content'])?$notice['content']:''}}</textarea>
                            </div>

                            <div class="col-sm-4">
                                <textarea disabled="disabled" style="width: 100%;" rows="12">{{isset($notice['example'])?$notice['example']:''}}</textarea>
                            </div>
                        </div>


                        @if(count($name)>0)
                            <div class="form-group">
                            <label class="col-sm-2 control-label">模板ID</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="template_id" placeholder="" disabled value="{{$id}}" />
                            </div>
                        </div>
                            <div class="form-group">
                            <label class="col-sm-2 control-label">设置详情链接</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="url" placeholder="" value="http://baidu.com" />
                            </div>
                        </div>
                            @if(count($name)>0)
                                @foreach($name as $item)
                                    @if($item!=="remark")
                                        <div class="form-group">
                                        <label class="col-sm-2 control-label">{{$item}}</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control {{$item.'_input'}}" name="data[{{$item}}]" placeholder="" value=" 测试啊" />
                                        </div>
                                    </div>
                                    @elseif($item==="remark")
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">{{$item}}</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control {{$item.'_input'}}" name="data[{{$item}}]" id="" cols="30" rows="10">测试啊</textarea>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            <div class="form-group">
                                <label class="col-sm-2 control-label">设置接收者openId</label>
                                <div class="col-sm-9">
                                    {{ Widget::run('Fans','') }}
                                    {{--<input type="text" class="form-control" name="touser" placeholder="" value=""/>--}}
                                </div>
                            </div>

                        @endif
                     </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var FansApi = '{{route('admin.wechat.fans.api')}}';
        var sendOutApi = "{{route('admin.wechat.notice.sendOut')}}";
        var names = [];
        var stime = "";
        var etime = "";
        @if(count($name)>0)
            @foreach($name as $k=> $item)
                names.push("{{$item}}");
            @endforeach
        @endif

        $(function () {
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

        $.getScript('/assets/wechat-backend/libs/element/vue.js', function () {
            @include('Wechat::widgets.fans.script')
        });
    </script>