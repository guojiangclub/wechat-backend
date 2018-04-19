{{--@extends('wechat-backend::layouts.master')

@section ('title',  '公众号管理 | 添加公众号')


@section('breadcrumbs')
    <h2>添加公众号</h2>
    <ol class="breadcrumb">
        <li><a href="{{route('admin.wechat.index')}}"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li><a href="{{route('admin.wechat.account.index')}}"></i>公众号管理</a></li>
        <li class="active">添加公众号</li>
    </ol>
@endsection

@section('content')--}}

    <div class="ibox float-e-margins">
        <div class="ibox-content" style="display: block;">
            <div class="row">
                <div class="panel-body">
                    {!! Form::open( [ 'url' => [route('admin.wechat.account.store')], 'method' => 'POST', 'id' => 'create-account-form','class'=>'form-horizontal'] ) !!}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">公众号名称：</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="name" placeholder=""/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">公众号原始Id：</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="original_id" placeholder="请认真填写，错了不能修改。例如gh_gks84hksi90o"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">微信号：</label>
                        <div class="col-sm-8" >
                            <input type="text" class="form-control" name="wechat_account" placeholder="例如：dmpwechat"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">AppID：</label>
                        <div class="col-sm-8" >
                            <input type="text" class="form-control" name="app_id" placeholder="用于自定义菜单等高级功能"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">AppSecret：</label>
                        <div class="col-sm-8" >
                            <input type="text" class="form-control" name="app_secret" placeholder="用于自定义菜单等高级功能"/>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 control-label">公众号类型：</label>
                        <div class="col-sm-8" >
                            <select class="form-control" name="account_type">
                                <option value="1">订阅号</option>
                                <option value="2" selected>服务号</option>
                            </select>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-primary" type="submit">保存</button>
                            <a href="{{route('admin.wechat.account.index')}}" class="btn btn-danger">取消</a>
                        </div>

                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
{{--@stop

@section('after-scripts-end')--}}
    {!! Html::script('libs/formvalidation/dist/js/formValidation.min.js') !!}
    {!! Html::script('libs/formvalidation/dist/js/framework/bootstrap.min.js') !!}
    {!! Html::script('libs/formvalidation/dist/js/language/zh_CN.js') !!}
    <script>
        $(document).ready(function () {
            $('#create-account-form').formValidation({
                framework: 'bootstrap',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    name: {
                        validators: {
                            notEmpty: {
                                message: '请输入公众号名称'
                            }
                        }
                    },

                    original_id: {
                        validators: {
                            notEmpty: {
                                message: '请输入公众号原始Id'
                            },
                            regexp: {
                                regexp: /^[A-Za-z0-9_]+$/,
                                message: '数字或字母'
                            }
                        }
                    },

                    wechat_account: {
                        validators: {
                            notEmpty: {
                                message: '请输入微信号'
                            },
                            regexp: {
                                regexp: /^[A-Za-z0-9_]+$/,
                                message: '数字或字母'
                            }
                        }
                    },

                    app_id: {
                        validators: {
                            notEmpty: {
                                message: '请输入AppID（公众号）'
                            },
                            regexp: {
                                regexp: /^[A-Za-z0-9_]+$/,
                                message: '数字或字母'
                            }
                        }
                    },

                    app_secret: {
                        validators: {
                            notEmpty: {
                                message: '请输入AppSecret'
                            },
                            regexp: {
                                regexp: /^[A-Za-z0-9_]+$/,
                                message: '数字或字母'
                            }
                        }
                    },

                    account_type: {
                        validators: {
                            notEmpty: {
                                message: '请选择微信号类型'
                            }
                        }
                    },

                }
            }).on('success.form.fv', function (e) {
                // Prevent form submission
                e.preventDefault();

                // Get the form instance
                var $form = $(e.target);

                // Get the FormValidation instance
                var bv = $form.data('formValidation');

                // Use Ajax to submit form data
                $.post($form.attr('action'), $form.serialize(), function(result) {

                    if(!result.data){
                        swal({
                            title: "出错了！",
                            text: result.error,
                            type: "error"
                        }, function() {
//                            location = '/admin/wechat/account/create';
                        });
                    }else{
                        swal({
                            title: "保存成功！",
                            text: "",
                            type: "success"
                        }, function() {
                            location = '/admin/wechat/account';
                        });
                    }

                }, 'json');
            });
        })
    </script>
{{--@stop--}}


