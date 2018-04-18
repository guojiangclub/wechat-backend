
@extends('store-backend::dashboard')
@section ('title', '微信卡券货架列表')
@section ('breadcrumbs')
    <h2>微信卡券货架列表</h2>
    <ol class="breadcrumb">
        <li><a href="{!!route('admin.store.index')!!}"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li>{!! link_to_route('admin.wechat.card.create', '微信卡券货架列表') !!}</li>
    </ol>

@stop


@section('content')

    @if(Session::has('message'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> 提示！</h4>
            {{ Session::get('message') }}
        </div>
    @endif

    <div class="tabs-container">
        <div class="tab-content">
            <div id="tab-1" class="tab-pane active">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a class="btn btn-primary " href="{{ route('admin.wechat.landingPage.create') }}">新建货架</a>
                            </div>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <tbody>
                            <!--tr-th start-->
                            <tr>
                                <th>名称</th>
                                <th>URL</th>
                                <th>关联卡券</th>
                                <th>操作</th>
                            </tr>
                            <!--tr-th end-->

                            @foreach ($landPage as $item)
                                <tr>
                                    <td>{{$item->title}}</td>
                                    <td>{{$item->url}}</td>
                                    <td>{!! $item->card !!}</td>
                                    <td>
                                        {{--<a--}}
                                                {{--class="btn btn-xs btn-primary"--}}
                                                {{--href="{{route('admin.positions.edit',['id'=>$item->id])}}">--}}
                                            {{--<i data-toggle="tooltip" data-placement="top"--}}
                                               {{--class="fa fa-pencil-square-o"--}}
                                               {{--title="编辑"></i></a>--}}


                                        {{--<a class="btn btn-xs btn-danger"--}}
                                           {{--href="#">--}}
                                            {{--<i data-toggle="tooltip" data-placement="top"--}}
                                               {{--class="fa fa-trash"--}}
                                               {{--title="删除"></i></a>--}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div>
            </div>
        </div>
    </div>
@endsection