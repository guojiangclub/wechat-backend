    <style>
        .switchType2{
            width:100px;
            height:35px;
            position: relative;
            left: -8px;
            top:30px;
            z-index: 200000;
        }
        .switchType1{
            width:100px;
            height:35px;
            position: relative;
            left: -8px;
            top:30px;
            z-index: 200000;
        }
    </style>


    @if(Session::has('message'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> 提示！</h4>
            {{ Session::get('message')}}
        </div>
    @endif

    <div class="ibox-content" style="display: block;" id="app">
        <div class="row">
            <div class="panel-body">
                <div class="form-horizontal">
                    <div class="hint" style="margin-left:30px;" >
                        <p>
                            <i class="fa fa-info-circle"></i>注意<br>
                            1.临时二维码，是有过期时间的，最长可以设置为在二维码生成后的30天（即2592000秒）后过期，但能够生成较多数量<br>
                            2.永久二维码，是无过期时间的，但数量较少（目前为最多10万个）。永久二维码主要用于适用于帐号绑定、用户来源统计等场景<br>
                        </p>
                    </div>
                    <br>
                    <div class="form-group">
                        <span style="font-weight:800" class="col-sm-2 control-label text-right">*场景名称</span>
                        <div class="col-sm-8">
                            <input type="text" name="name" id=""  v-model="name"  class="form-control" placeholder="场景名称">
                        </div>
                    </div>
                    <div class="form-group">
                        <span style="font-weight:800"  class="col-sm-2 control-label text-right">关联关键字</span>
                        <div class="col-sm-8">
                            <input type="text" name="key" id="" v-model="key"   class="form-control" placeholder="关联关键字">
                        </div>
                    </div>
                    <div class="form-group data-show" style="display: none">
                        <span  style="font-weight:800"  class="col-sm-2 control-label text-right">*二维码类型</span>
                        <div class="col-sm-8 type-radio">
                                @if(!isset($data->type))
                                    <div class="switchType2" @click="switchType(2)"></div>
                                @endif
                                    <input  type="radio"  class="input2" name="type" data-type="2"
                                            @if(empty($id)) checked @endif    @if(isset($data->type)&&$data->type==2) checked   @endif
                                            @if(isset($data->type)) disabled @endif
                                    >永久二维码
                               @if(!isset($data->type))
                                    <div class="switchType1" @click="switchType(1)"></div>
                               @endif
                                    <input  type="radio" class="input1" name="type" data-type="1"
                                            @if(isset($data->type)&&$data->type==1) checked  @endif
                                            @if(isset($data->type)) disabled @endif
                                    >临时二维码

                    </div>
                    </div>

                    <div class="form-group"  style="display: none"   v-show="type==1?true:false">
                        <span style="font-weight:800" class="col-sm-2 control-label text-right">*过期时间(单位秒)</span>
                        <div class="col-sm-8">
                            <input type="number" name="expire_seconds" id=""  @if(isset($data->expire_seconds))  disabled @endif  v-model="expire_seconds"  class="form-control" placeholder="临时二维码过期时间最大30天（2592000秒）">
                        </div>
                    </div>

                    <div class="form-group"  style="display: none" v-show="type==2?true:false">
                        <span  style="font-weight:800"  class="col-sm-2 control-label text-right">*场景值</span>
                        <div class="col-sm-8">
                            <input type="text" name="scene_str" id=""  v-model="scene_str" @if(isset($data->scene_str))  disabled @endif     class="form-control" placeholder="字母">
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8 controls">
                            <button type="button" class="btn btn-primary" @click="store()" data-type="click">保存</button>
                        </div>
                    </div>

                 </div>
            </div>
        </div>
    </div>




    <script>
        var CodesList="{{route('admin.wechat.QRCode.index')}}"
        var storeApi="{{route('admin.wechat.QRCode.store')}}"

        var updateApi="{{route('admin.wechat.QRCode.update',['id'=>'#'])}}";
        var editId="{{isset($id)?$id:''}}";

        var editGetDataUrl="{{route('admin.wechat.QRCode.api.edit',['id'=>'#'])}}";
        // $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

    </script>
    @include('Wechat::QRCode.script')
    @include('wechat-backend::active')
