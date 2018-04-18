
@if(empty(request('type'))||request('type')==1)
    <div class="tab-content app">
        <div id="image" class="tab-pane active" role="tabpanel" >
            <div class="panel-body">
                <div class="hint" style="margin-left:30px;" >
                    <p>
                        <i class="fa fa-info-circle"></i>注意<br>
                        1.图片素材上传格式支持jpeg，jpg，png，bmp，gif最大不超过2M。上限为5000<br>
                        2.拉取微信原有图片素材请点击下载按钮，耐心等待完成。<br>
                        3.删除图片素材同步删除微信服务端图片素材，请谨慎操作.<br>
                    </p>
                </div>
                <div class="row data-show" style="display: none">
                    <div class="col-md-2" style="margin-left:30px;" >
                        <button id="pullImage" data-style="expand-right"  class="btn btn-info ladda-button">同步图片</button>
                    </div>
                    <div class="col-md-7">
                        <div id="upload-img"  class="pull-left"  style="margin-left:-75px;">
                            <span id="imguping" data-style="expand-right"  class="ladda-button">上传图片</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @include('Wechat::materials.image.index')
                </div>
            </div>
        </div>
    </div>
@endif


@if(request('type')==2)
    <div class="tab-content app">
        <div id="video" class="tab-pane active" role="tabpanel" >
            <div class="panel-body">
                <div class="hint" style="margin-left:30px;" >
                    <p>
                        <i class="fa fa-info-circle"></i>注意<br>
                        1.视频素材上传格式支持mp4最大不超过10M。上限为1000<br>
                        2.删除视频素材同步删除微信服务端视频素材，请谨慎操作<br>
                    </p>
                </div>
                <div class="row">
                    <div class="col-md-11">
                        <a class=" btn-primary btn btn-sm" style="margin-left:30px;"  href="{!!route('admin.wechat.material.create_video')!!}">添加视频</a>
                    </div>
                </div>
                <div class="row">
                    @include('Wechat::materials.video.index')
                </div>
            </div>
        </div>
    </div>

@endif


@if(request('type')==3)
    <div class="tab-content app">
        <div id="video" class="tab-pane active" role="tabpanel" >
            <div class="panel-body">
                <div class="row data-show" style="display: none">
                    <div class="col-md-11">
                        <a class=" btn-primary btn btn-sm" style="margin-left:30px;"  href="{!!route('admin.wechat.material.create_voice')!!}">添加音频</a>
                    </div>
                </div>
                <div class="row">
                    @include('Wechat::materials.voice.index')
                </div>
            </div>
        </div>
    </div>
@endif


@if(request('type')==4)
    <div class="tab-content app">
        <div id="video" class="tab-pane active" role="tabpanel" >
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-11">
                        <a class=" btn-primary btn btn-sm" style="margin-left:30px;"  href="{!!route('admin.wechat.material.create_article')!!}">添加图文</a>
                    </div>
                </div>
                <div class="row">
                    @include('Wechat::materials.article.index')
                </div>
            </div>
        </div>
    </div>
@endif


@if(request('type')==5)
    <div class="tab-content app">
        <div id="video" class="tab-pane active" role="tabpanel" >
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-11">
                        <a class=" btn-primary btn btn-sm" style="margin-left:30px;"  href="{!!route('admin.wechat.material.create_text')!!}">添加文本</a>
                    </div>
                </div>
                <div class="row">
                    @include('Wechat::materials.text.index')
                </div>
            </div>
        </div>
    </div>
    <script>
        var editApi="{{route('admin.wechat.material.edit_text','#')}}"
    </script>
@endif

