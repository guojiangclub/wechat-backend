 {!! Html::style(env("APP_URL").'/assets/wechat-backend/libs/element/index.css') !!}
    {!! Html::style(env("APP_URL").'/assets/wechat-backend/libs/webuploader-0.1.5/webuploader.css') !!}
    {!! Html::style(env("APP_URL").'/assets/wechat-backend/libs/ladda/ladda-themeless.min.css') !!}
    {!! Html::style(env("APP_URL").'/assets/wechat-backend/css/upload.css') !!}
    <style>
        .el-tag__close{
            display: none;
        }
        .el-input__icon{
            display: none;
        }
        .el-input.is-disabled .el-input__inner{
            background: #ffffff;
        }

        .el-input__inner{
            border:1px #ffffff;
            background: #ffffff;
        }
    </style>

    @if(Session::has('message'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> 提示！</h4>
            {{ Session::get('message')}}
        </div>
    @endif

    {{--['article','image', 'voice', 'video','text'--}}
    <div class="tabs-container">
        <ul class="nav nav-tabs">
            @if(empty(request('m_type')))
                <li class="active"><a href="{{route('admin.wechat.events.index',['m_type'=>1])}}">回复文本消息
                    </a></li>
            @else
                <li class="{{ Active::query('m_type',1) }}"><a href="{{route('admin.wechat.events.index',['m_type'=>1])}}">回复文本消息
                    </a>
                </li>
            @endif
            <li class="{{ Active::query('m_type',2) }}">
                <a href="{{route('admin.wechat.events.index',['m_type'=>2])}}">回复图片消息
                </a>
            </li>

            <li class="{{ Active::query('m_type',3) }}">
                <a href="{{route('admin.wechat.events.index',['m_type'=>3])}}">回复图文消息
                </a>
            </li>

            <li class="{{ Active::query('m_type',4) }}">
                <a href="{{route('admin.wechat.events.index',['m_type'=>4])}}">回复视频消息
                    </a></li>

                <li class="{{ Active::query('m_type',6) }}">
                    <a href="{{route('admin.wechat.events.index',['m_type'=>6])}}">回复卡券信息
                    </a></li>
        </ul>

        @include('Wechat::events.includes.show')

    </div>
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/webuploader-0.1.5/webuploader.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/ladda/spin.min.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/ladda/ladda.min.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/toastr/toastr.min.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/ladda/ladda.jquery.min.js') !!}