@if(empty(request('m_type'))||request('m_type')==1)
    <div class="tab-content" >
        <div class="tab-pane active" role="tabpanel" >
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12" style="margin-left:30px;">
                        <p>
                            <i class="fa fa-info-circle"></i>注意<br>
                            1.新用户关注公众号时默认回复信息，请设置关键字为"关注自动回复"<br>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <a class=" btn-primary btn btn-sm"  style="margin-left:30px;" no-pjax href="{{route('admin.wechat.events.create',['m_type'=>1])}}">创建文本消息</a>
                    </div>
                    <div class="input-group col-md-2">
                        <input type="text" class="form-control search-input" placeholder="关键字" name="key" value="" v-model="Keyword"  >
                        <span class="input-group-btn">
                                <button  @click="getData()" style="margin-right:20px;height: 34px;" class="btn btn-default" id="search" type="button">
                                                <i class="fa fa-search" ></i>
                                </button>
                        </span>

                    </div>
                </div>
                <div class="row">
                    @include('Wechat::events.includes.text.index')
                </div>
            </div>
        </div>
    </div>

        <script>
            var EventsApi='{{route('admin.wechat.events.api')}}';
            var deleteApi="{{route('admin.wechat.events.delete',['id'=>'#'])}}";
            var editApi="{{route('admin.wechat.events.edit',['id'=>'#'])}}";
            var updateApi="{{route('admin.wechat.events.update',['id'=>'#'])}}";

        </script>
        @include('Wechat::events.includes.script.script')

@endif




@if(request('m_type')==2)
    <div class="tab-content">
        <div  class="tab-pane active" role="tabpanel" >
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12" style="margin-left:30px;">
                        <p>
                            <i class="fa fa-info-circle"></i>注意<br>
                            1.新用户关注公众号时默认回复信息，请设置关键字为"关注自动回复"<br>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <a class=" btn-primary btn btn-sm" style="margin-left:30px;"  no-pjax href="{{route('admin.wechat.events.create',['m_type'=>2])}}">创建图片消息</a>
                    </div>
                    <div class="input-group col-md-2">
                        <input type="text" class="form-control search-input" placeholder="关键字" name="key" value="" v-model="Keyword"  >
                        <span class="input-group-btn">
                                <button   @click="getData()" style="margin-right:20px;height: 34px;" class="btn btn-default" id="search" type="button">
                                                <i class="fa fa-search"></i>
                                </button>
                        </span>
                    </div>
                </div>
                <div class="row">
                    @include('Wechat::events.includes.image.index')
                </div>
            </div>
        </div>
    </div>

        <script>
            var EventsApi='{{route('admin.wechat.events.api')}}';
            var deleteApi="{{route('admin.wechat.events.delete',['id'=>'#'])}}";
            var editApi="{{route('admin.wechat.events.edit',['id'=>'#'])}}";
            var updateApi="{{route('admin.wechat.events.update',['id'=>'#'])}}";
        </script>
        @include('Wechat::events.includes.script.script')

@endif


@if(request('m_type')==3)
    <div class="tab-content">
        <div  class="tab-pane active" role="tabpanel" >
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12" style="margin-left:30px;">
                        <p>
                            <i class="fa fa-info-circle"></i>注意<br>
                            1.新用户关注公众号时默认回复信息，请设置关键字为"关注自动回复"<br>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <a class=" btn-primary btn btn-sm" style="margin-left:30px;" no-pjax  href="{{route('admin.wechat.events.create',['m_type'=>3])}}">创建图文消息</a>
                    </div>
                    <div class="input-group col-md-2">
                        <input type="text" class="form-control search-input" placeholder="关键字" name="key" value=""   >
                        <span class="input-group-btn">
                                <button  style="margin-right:20px;height: 34px;" class="btn btn-default" id="search" type="button">
                                                <i class="fa fa-search"></i>
                                </button>
                        </span>
                    </div>
                </div>
                <div class="row">
                    @include('Wechat::events.includes.article.index')
                </div>
            </div>
        </div>
    </div>

    <script>
        var EventsApi='{{route('admin.wechat.events.api')}}';
        var deleteApi="{{route('admin.wechat.events.delete',['id'=>'#'])}}";
        var editApi="{{route('admin.wechat.events.edit',['id'=>'#'])}}";
        var updateApi="{{route('admin.wechat.events.update',['id'=>'#'])}}";
    </script>
    @include('Wechat::events.includes.script.script')


@endif


@if(request('m_type')==4)
    <div class="tab-content">
        <div class="tab-pane active" role="tabpanel" >
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12" style="margin-left:30px;">
                        <p>
                            <i class="fa fa-info-circle"></i>注意<br>
                            1.新用户关注公众号时默认回复信息，请设置关键字为"关注自动回复"<br>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <a class=" btn-primary btn btn-sm" style="margin-left:30px;" no-pjax  href="{{route('admin.wechat.events.create',['m_type'=>4])}}">创建视频消息</a>
                    </div>
                    <div class="input-group col-md-2">
                        <input type="text" class="form-control search-input" placeholder="关键字" name="key" value=""   >
                        <span class="input-group-btn">
                                <button  style="margin-right:20px;height: 34px;" class="btn btn-default" id="search" type="button">
                                                <i class="fa fa-search"></i>
                                </button>
                        </span>
                    </div>
                </div>
                <div class="row">
                    @include('Wechat::events.includes.video.index')
                </div>
            </div>
        </div>
    </div>

        <script>
            var EventsApi='{{route('admin.wechat.events.api')}}';
            var deleteApi="{{route('admin.wechat.events.delete',['id'=>'#'])}}";
            var editApi="{{route('admin.wechat.events.edit',['id'=>'#'])}}";
            var updateApi="{{route('admin.wechat.events.update',['id'=>'#'])}}";
        </script>
        @include('Wechat::events.includes.script.script')

@endif


@if(request('m_type')==6)
    <div class="tab-content">
        <div class="tab-pane active" role="tabpanel" >
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12" style="margin-left:30px;">
                        <p>
                            <i class="fa fa-info-circle"></i>注意<br>
                            1.新用户关注公众号时默认回复信息，请设置关键字为"关注自动回复"<br>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <a class=" btn-primary btn btn-sm" style="margin-left:30px;" no-pjax href="{{route('admin.wechat.events.create',['m_type'=>6])}}">创建卡券消息</a>
                    </div>
                    <div class="input-group col-md-2">
                        <input type="text" class="form-control search-input" placeholder="关键字" name="key" value=""   >
                        <span class="input-group-btn">
                                <button  style="margin-right:20px;height: 34px;" class="btn btn-default" id="search" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                        </span>
                    </div>
                </div>
                <div class="row">
                    @include('Wechat::events.includes.card.index')
                </div>
            </div>
        </div>
    </div>

    <script>
        var EventsApi='{{route('admin.wechat.events.api')}}';
        var deleteApi="{{route('admin.wechat.events.delete',['id'=>'#'])}}";
        var editApi="{{route('admin.wechat.events.edit',['id'=>'#'])}}";
        var updateApi="{{route('admin.wechat.events.update',['id'=>'#'])}}";
    </script>
    @include('Wechat::events.includes.script.script')

@endif
