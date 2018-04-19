{{--@extends('wechat-backend::layouts.master')

@section ('title',  '微信管理 | 授权设置')

@section('breadcrumbs')
    <h2>授权设置</h2>
    <ol class="breadcrumb">
        <li><a href="{!!route('admin.wechat.index')!!}"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li>授权设置</li>
    </ol>
@endsection


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
                            <form method="post" action="{{route('admin.wechat.saveSettings')}}" class="form-horizontal"
                                  id="base-form">
                                {{csrf_field()}}

                                <div class="form-group"><label class="col-sm-3 control-label">*默认登录appid</label>
                                    <div class="col-sm-9"><input type="text" name="wechat_app_id" placeholder="" class="form-control"
                                                                 value="{{settings('wechat_app_id')}}"></div>
                                </div>

                                <div class="form-group"><label class="col-sm-3 control-label">*默认登录appsecret</label>
                                    <div class="col-sm-9"><input type="text" name="wechat_app_secret" placeholder="" class="form-control"
                                                                 value="{{settings('wechat_app_secret')}}"></div>
                                </div>

                                <div class="form-group"><label class="col-sm-3 control-label">*WECHAT_API_URL</label>
                                    <div class="col-sm-9"><input type="text" name="wechat_api_url" placeholder="" class="form-control"
                                                                  value="{{settings('wechat_api_url')}}"></div>
                                </div>

                                <div class="form-group"><label class="col-sm-3 control-label">*WECHAT_API_CLIENT_ID</label>
                                    <div class="col-sm-9"><input type="text" name="wechat_api_client_id" placeholder="" class="form-control"
                                                                  value="{{settings('wechat_api_client_id')}}"></div>
                                </div>

                                <div class="form-group"><label class="col-sm-3 control-label">*WECHAT_API_CLIENT_SECRET</label>
                                    <div class="col-sm-9"><input type="text" name="wechat_api_client_secret" placeholder="" class="form-control"
                                                                 value="{{settings('wechat_api_client_secret')}}"></div>
                                </div>


                                <div class="form-group"><label class="col-sm-3 control-label">MINI_PROGRAM_APP_ID</label>
                                    <div class="col-sm-9"><input type="text" name="mini_program_app_id" placeholder="" class="form-control"
                                                                 value="{{settings('mini_program_app_id')}}"></div>
                                </div>

                                <div class="form-group"><label class="col-sm-3 control-label">MINI_PROGRAM_SECRET</label>
                                    <div class="col-sm-9"><input type="text" name="mini_program_secret" placeholder="" class="form-control"
                                                                 value="{{settings('mini_program_secret')}}"></div>
                                </div>

                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-primary" type="submit">授权</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
            </div>

{{--@stop

@section('before-scripts-end')--}}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/jquery.form.min.js') !!}
    <script>
        $('#base-form').ajaxForm({
            beforeSubmit:function () {
                var wechat_app_id=$('input[name=wechat_app_id]').val();
                var wechat_api_url=$('input[name=wechat_api_url]').val();
                var wechat_api_client_id=$('input[name=wechat_api_client_id]').val();
                var wechat_api_client_secret=$('input[name=wechat_api_client_secret]').val();
                if(wechat_api_client_id=""|| wechat_app_id=="" || wechat_api_url=="" ||  wechat_api_client_secret=="" ){
                    swal("授权失败!",'*为必填信息', "error")
                    return false;
                }
            },
            success: function (result) {
                if (!result.status) {
                    swal("授权失败!", result.message, "error")
                } else {
                    swal({
                        title: "授权成功！",
                        text: "",
                        type: "success"
                    }, function () {
                        location = '{!!route('admin.wechat.account.index')!!}'
                    });
                }
            }

        });
    </script>
{{--@stop--}}
