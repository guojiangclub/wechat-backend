@extends('store-backend::dashboard')
@section ('title','微信卡券货架管理')
@section('after-styles-end')
    {!! Html::style(env("APP_URL").'/assets/backend/libs/webuploader-0.1.5/webuploader.css') !!}
@stop
{{--@section('page-header')
    <h1>
        产品品牌管理
        <small>添加品牌</small>
    </h1>
@endsection--}}

@section ('breadcrumbs')

    <h2>添加货架</h2>
    <ol class="breadcrumb">
        <li><a href="{!!route('admin.store.index')!!}"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li class="">{!! link_to_route('admin.brand.index', '微信卡券管理') !!}</li>
        <li class="active">添加货架</li>
    </ol>

@stop

@section('content')
    <div class="tabs-container">

        {!! Form::open( [ 'url' => [route('admin.wechat.landingPage.store')], 'method' => 'POST','id' => 'base-form','class'=>'form-horizontal'] ) !!}
        <div class="tab-content">
            <div id="tab-1" class="tab-pane active">
                <div class="panel-body">

                    <div class="form-group">
                        {!! Form::label('page_title','货架标题：', ['class' => 'col-lg-2 control-label']) !!}
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="page_title" placeholder="">
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('can_share','是否可分享：', ['class' => 'col-lg-2 control-label']) !!}
                        <div class="col-lg-9">
                            <select class="form-control" name="can_share">
                                <option value="1">是</option>
                                <option value="0">否</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        {!! Form::label('banner','banner图：', ['class' => 'col-lg-2 control-label']) !!}
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="banner" placeholder="">
                        </div>
                    </div>


                    <div class="form-group">
                        {!! Form::label('scene','投放页面的场景：', ['class' => 'col-lg-2 control-label']) !!}
                        <div class="col-lg-9">
                            <select class="form-control" name="scene">
                                <option value="SCENE_NEAR_BY"> 附近 </option>
                                <option value="SCENE_MENU">自定义菜单</option>
                                <option value="SCENE_QRCODE">二维码</option>
                                <option value="SCENE_ARTICLE"> 公众号文章 </option>
                                <option value="SCENE_H5">h5页面</option>
                                <option value="SCENE_IVR">自动回复</option>
                                <option value="SCENE_CARD_CUSTOM_CELL">卡券自定义cell</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('card_list','指定卡券：', ['class' => 'col-lg-2 control-label']) !!}
                        <div class="col-lg-9" id="cardBox">
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <select class="form-control" name="card_id[]">
                                        @foreach($card as $item)
                                            <option value="{{$item->id}}"> {{$item->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" placeholder="缩略图URL" name="thumb[]">
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="col-lg-offset-5 btn btn-w-m btn-danger" onclick="delRules(this)">删除</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" id="add-condition" type="button">添加卡券</button>


                </div>
            </div>

        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group">
            <div class="col-sm-4 col-sm-offset-2">
                <button class="btn btn-primary" type="submit">保存</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>


    <script type="text/x-template" id="discount_template">
        <div class="form-group">
            <div class="col-sm-3">
                <select class="form-control" name="card_id[]">
                    @foreach($card as $item)
                        <option value="{{$item->id}}"> {{$item->title}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-7">
                <input type="text" class="form-control" placeholder="缩略图URL" name="thumb[]">
            </div>
            <div class="col-sm-2">
                <button type="button" class="col-lg-offset-5 btn btn-w-m btn-danger" onclick="delRules(this)">删除</button>
            </div>
        </div>
    </script>

@endsection

@section('before-scripts-end')
    {!! Html::script(env("APP_URL").'/assets/backend/libs/jquery.form.min.js') !!}
    {!! Html::script(env("APP_URL").'/assets/backend/libs/webuploader-0.1.5/webuploader.js') !!}

@stop

@section('after-scripts-end')
    <script>
        //删除操作
        function delRules(_self){
            $(_self).parent().parent().remove();
        }

        //添加层级
        var discont_html = $('#discount_template').html();
        $('#add-condition').click(function() {
            $('#cardBox').append(discont_html);
        });


        $(function () {
            $('#base-form').ajaxForm({
                success: function (result) {
                    swal({
                        title: "保存成功！",
                        text: "",
                        type: "success"
                    }, function() {
                        location = '{{route('admin.wechat.landingPage.index')}}';
                    });
                }
            });
        })
    </script>
@stop
