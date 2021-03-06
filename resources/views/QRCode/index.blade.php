
    @if(Session::has('message'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> 提示！</h4>
            {{ Session::get('message')}}
        </div>
    @endif

    <div class="tabs-container">
        <ul class="nav nav-tabs">
            @if(empty(request('type')))
                <li class="active"><a no-pjax href="{{route('admin.wechat.QRCode.index',['type'=>2])}}">永久二维码&nbsp;<span class="badge">{{$forever_count}}</span>                    </a></li>
            @else
                <li class="{{ Active::query('type',2) }}"><a no-pjax href="{{route('admin.wechat.QRCode.index',['type'=>2])}}">永久二维码 &nbsp; <span class="badge">{{$forever_count}}</span>
                    </a>
                </li>
            @endif
            <li class="{{ Active::query('type',1) }}">
                <a no-pjax href="{{route('admin.wechat.QRCode.index',['type'=>1])}}">临时二维码 &nbsp;<span class="badge">{{$temporary_count}}</span>
                </a>
            </li>
        </ul>

        <div class="tab-content" >
            <div class="tab-pane active" role="tabpanel" >
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-10">
                            <a class=" btn-primary btn btn-sm" style="margin-left:30px;" no-pjax href="{{route('admin.wechat.QRCode.create')}}">创建二维码</a>
                        </div>
                        <div class="input-group col-md-2">
                            <input type="text" class="form-control search-input" placeholder="场景名称" name="key" value="" v-model="Keyword">
                            <span class="input-group-btn">
                                <button  style="margin-right:20px;height: 34px;" class="btn btn-default" id="search" type="button" @click="getData()">
                                                <i class="fa fa-search" ></i>
                                </button>
                        </span>

                        </div>
                    </div>

                    <div class="row">
                        @if($type==2)
                          @include('Wechat::QRCode.includes.forever')
                        @else
                            @include('Wechat::QRCode.includes.temporary')
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>



    <script>
        var ScansApi="{{route('admin.wechat.QRCode.scans',['ticket'=>'#'])}}"
        var CodesApi="{{route('admin.wechat.QRCode.api')}}"
        var deleteApi="{{route('admin.wechat.QRCode.delete',['id'=>'#'])}}"
        var editApi="{{route('admin.wechat.QRCode.edit',['id'=>'#'])}}";
        var type="{{$type}}";
    </script>

    @include('Wechat::QRCode.includes.script')
    @include('wechat-backend::active')



