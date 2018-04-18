@extends('backend::layouts.default')

@section('sidebar-menu')
    <li class="{{ Active::pattern('admin/wechat/account*') }}">
        <a href="#"><i class="fa fa-gear"></i>
            <span class="nav-label">公众号管理</span>
            <span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            <li class="{{ Active::pattern('admin/wechat/account') }}"><a
                        href="{{route('admin.wechat.account.index')}}">公众号列表</a>
            </li>
        </ul>
    </li>

    @if(Session::has('account_app_id')&&Session::has('account_id')&&Session::has('account_name'))
        <li class="{{ Active::pattern('admin/wechat/base*') }}">
            <a href="#"><i class="fa fa-gear"></i>
                <span class="nav-label">基础功能</span>
                <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse">
                <li class="{{ Active::pattern('admin/wechat/base/menu*') }}"><a
                            href="{{route('admin.wechat.menu.index')}}">自定义菜单</a>
                </li>
                <li class="{{ Active::pattern('admin/wechat/base/events*') }}"><a
                            href="{{route('admin.wechat.events.index')}}">自动回复</a>
                </li>

            </ul>
        </li>

        <li class="{{ Active::pattern('admin/wechat/fans*')}}">
            <a href="{{route('admin.wechat.fans.index')}}"><i class="fa fa-gear"></i>
                <span class="nav-label">粉丝管理</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level collapse">
                <li class=""><a
                            href="{{route('admin.wechat.fans.index')}}">粉丝列表</a>
                </li>
            </ul>
        </li>


        <li class="{{ Active::pattern('admin/wechat/material*')}}">
            <a href="{{route('admin.wechat.material.index')}}"><i class="fa fa-gear"></i>
                <span class="nav-label">素材管理</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level collapse">
                <li class=""><a
                            href="{{route('admin.wechat.material.index',['type'=>1])}}">图片素材</a>
                </li>
                <li class=""><a
                            href="{{route('admin.wechat.material.index',['type'=>2])}}">视频素材</a>
                </li>
                <li class=""><a
                            href="{{route('admin.wechat.material.index',['type'=>4])}}">图文素材</a>
                </li>
                <li class=""><a
                            href="{{route('admin.wechat.material.index',['type'=>5])}}">文本素材</a>
                </li>
            </ul>
        </li>

        <li class="{{ Active::pattern('admin/wechat/notice*')}}">
            <a href="{{route('admin.wechat.notice.index')}}"><i class="fa fa-gear"></i>
                <span class="nav-label">模板消息</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level collapse">
                <li class=""><a
                            href="{{route('admin.wechat.notice.index')}}">我的模板</a>
                </li>
            </ul>
        </li>



        <li class="{{ Active::pattern('admin/wechat/QRCode*')}}">
            <a href="{{route('admin.wechat.QRCode.index')}}"><i class="fa fa-gear"></i>
                <span class="nav-label">二维码管理</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level collapse">
                <li class=""><a
                            href="{{route('admin.wechat.QRCode.index')}}">二维码列表</a>
                </li>
                <li class=""><a
                            href="{{route('admin.wechat.QRCode.count.scans')}}">扫码统计</a>
                </li>
            </ul>
        </li>


    @endif

@endsection

@section('before-scripts-end')
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/element/vue.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/element/index.js') !!}
@endsection

