{{--@extends('wechat-backend::layouts.master')

@section ('title',  '公众号管理 | 编辑公众号')

@section('breadcrumbs')
    <h2>编辑公众号</h2>
    <ol class="breadcrumb">
        <li><a href="{!!route('admin.wechat.index')!!}"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li><a href="{!!route('admin.wechat.account.index')!!}"></i>公众号管理</a></li>
        <li class="active">编辑公众号</li>
    </ol>
@endsection

@section('content')--}}
    @if (session()->has('flash_notification.message'))
        <div class="alert alert-{{ session('flash_notification.level') }}">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! session('flash_notification.message') !!}
        </div>
    @endif
    <div class="ibox float-e-margins">
        <div class="ibox-content" style="display: block;">
            <div class="row">
                <div class="panel-body">
                    {!! Form::open( [ 'url' => [route('admin.wechat.account.update',['id'=>$account->id])], 'method' => 'POST', 'id' => 'base-form','class'=>'form-horizontal'] ) !!}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">公众号名称：</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="name" placeholder="" value="{{$account->name}}"/>
                        </div>
                    </div>
                    {{--<div class="form-group">--}}
                        {{--<label class="col-sm-2 control-label">公众号原始Id：</label>--}}
                        {{--<div class="col-sm-8">--}}
                            {{--<input type="text" class="form-control" name="original_id" placeholder="请认真填写，错了不能修改。例如gh_gks84hksi90o"  value="{{$account->original_id}}"/>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="form-group">--}}
                        {{--<label class="col-sm-2 control-label">微信号：</label>--}}
                        {{--<div class="col-sm-8" >--}}
                            {{--<input type="text" class="form-control" name="wechat_account" placeholder="例如：dmpwechat" value="{{$account->wechat_account}}"  />--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<label class="col-sm-2 control-label">AppID：</label>--}}
                        {{--<div class="col-sm-8" >--}}
                            {{--<input type="text" class="form-control"   value="{{$account->app_id}}"  />--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">公众号类型：</label>
                        <div class="col-sm-8" >
                            <select class="form-control" name="account_type" disabled>
                                <option value="1">订阅号</option>
                                <option value="2" selected>服务号</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-8" >
                            <input type="checkbox"
                                   @if($account->main===1)
                                           checked
                                   @endif
                                   name="main" id="">&nbsp;&nbsp;主账号
                        </div>
                    </div>


                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-primary" type="submit">保存</button>
                            {{--<a href="{{route('admin.wechat.account.index')}}" class="btn btn-danger">取消</a>--}}
                        </div>

                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
{{--@stop

@section('after-scripts-end')--}}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/jquery.form.min.js') !!}
    <script>
        $('#base-form').ajaxForm({
            success: function (result) {
                if (!result.status) {
                    swal("保存失败!", result.error, "error")
                } else {
                    swal({
                        title: "保存成功！",
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


