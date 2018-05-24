    @if (session()->has('flash_notification.message'))
        <div class="alert alert-{{ session('flash_notification.level') }}">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! session('flash_notification.message') !!}
        </div>
    @endif
    <div class="tabs-container">
        <ul class="nav nav-tabs">
            <li class="active"><a href="">我的模板
                    <span class="badge"></span></a></li>
        </ul>
        <div class="tab-content">

            <div id="tab-1" class="tab-pane active">
                <div class="panel-body">
                    {{--<div class="row">--}}
                        {{--<div class="col-md-12">--}}
                            {{--<div class="btn-group">--}}
                                {{--<a class="btn btn-primary "--}}
                                   {{--href="">添加模板</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    <div class="hr-line-dashed"></div>

                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <tbody>
                            <!--tr-th start-->
                            <tr>
                                <th>模板ID</th>
                                <th>标题</th>
                                <th>一级行业</th>
                                <th>二级行业</th>
                                <th>操作</th>
                            </tr>
                            <!--tr-th end-->
                            @if(count($notices)>0)
                                @foreach($notices as $item)
                                    <tr>
                                        <td>
                                            {{$item->template_id}}
                                        </td>
                                        <td>
                                            {{$item->title}}
                                        </td>
                                        <td>
                                            {{$item->primary_industry}}
                                        </td>
                                        <td>
                                            {{$item->deputy_industry}}
                                        </td>
                                        <td>
                                            <a class="btn btn-xs btn-primary" no-pjax
                                               href="{{route('admin.wechat.notice.show',$item->template_id)}}">
                                                <i data-toggle="tooltip" data-placement="top"
                                                   class="fa fa-eye"
                                                   title="详情"></i></a>

                                            <a no-pjax class="btn btn-xs btn-primary"
                                               href="{{route('admin.wechat.notice.sendOut.edit',$item->template_id)}}">
                                                <i data-toggle="tooltip" data-placement="top"
                                                   class="fa fa-share-alt"
                                                   title="发送模板消息"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">
                                            <span class="empty_tips">
                                                暂无模板
                                            </span>
                                    </td>
                                </tr>
                            @endif
                            </tbody>

                        </table>
                    </div><!-- /.box-body -->

                </div>
            </div>
        </div>
    </div>

    @include('wechat-backend::active')