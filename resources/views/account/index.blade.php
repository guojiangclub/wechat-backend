<div class="tabs-container">
    <ul class="nav nav-tabs">
        <li class="active"><a href="">公众号列表
                <span class="badge"></span></a></li>
    </ul>
    <div class="tab-content">

        <div id="tab-1" class="tab-pane active">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group">
                            @if(settings('wechat_api_client_id')&&settings('wechat_api_client_secret')&&settings('wechat_api_url'))
                            <a class="btn btn-primary" href="{{route('admin.wechat.platform.auth')}}">添加公众号</a>
                            @endif
                        </div>
                        <div class="btn-group">
                            <a class="btn btn-primary "
                               href="{{route('admin.wechat.init')}}">授权设置</a>
                        </div>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <tbody>
                        <!--tr-th start-->
                        <tr>
                            <th>公众号名称</th>
                            <th></th>
                            <th>APP_ID</th>
                            <th>类型</th>
                            <th>公众号验证状态</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        </tr>
                        <!--tr-th end-->
                        @if(count($accounts)>0)
                            @foreach($accounts as $item)
                                <tr>
                                    <td>{{$item->name}}</td>
                                    <td>
                                        @if($item->main==1)
                                          <span class="label label-danger">主账号</span>
                                        @endif</td>
                                    <td>{{$item->app_id}}</td>
                                    <td>
                                        @if($item->account_type ==1||$item->account_type ==0)
                                            订阅号
                                        @elseif($item->account_type ==2)
                                            服务号
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->verify_type_info<0)
                                           未验证
                                        @else
                                            已验证
                                        @endif
                                    </td>


                                    <td>{{$item->created_at->format('Y-m-d H:i:s')}}</td>
                                    <td>
                                        <a href="{{route('admin.wechat.management',['app_id'=>$item->app_id,'id'=>$item->id,'name'=>$item->name])}}"
                                           class="btn btn-success btn-xs">功能管理</a>
                                        <a href="{{route('admin.wechat.account.edit',['id'=>$item->id])}}"
                                           class="btn btn-success btn-xs">编辑</a>
                                        {{--<a href="#api_{{$item->id}}" class=" btn btn-info btn-xs"--}}
                                        {{--data-toggle="modal">接口</a>--}}

                                        {{--href="{{route('admin.wechat.account.destroy',['id'=>$item->id])}}--}}
                                        <a
                                        class="btn btn-danger btn-xs del" data-url="{{route('admin.wechat.account.destroy',['id'=>$item->id])}}">删除
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5">
                                        <span class="empty_tips">
                                            暂无公众号
                                        </span>
                                </td>
                            </tr>
                        @endif
                        </tbody>

                    </table>
                </div><!-- /.box-body -->

                <div class="pull-left">
                    {{--&nbsp;共{!! $accounts->count() !!} 条记录--}}
                </div>
                <div class="pull-right">
                    {{--{!! $accounts->render() !!}--}}
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    $('.del').on('click',function () {
        var postUrl=$(this).data('url');
        swal({
            title: "确定要删除该公众号吗?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "确认",
            cancelButtonText: '取消',
            closeOnConfirm: false
        }, function () {
            $.post(postUrl,{_token:_token},function (result) {
                if (!result.status) {
                    swal("删除失败!", result.message, "error")
                } else {
                    swal({
                        title: "删除成功！",
                        text: "",
                        type: "success"
                    }, function () {
                        location = '{{route('admin.wechat.account.index')}}';
                    });
                }
            })
        });
    });
</script>