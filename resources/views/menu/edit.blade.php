<style>
    #text-checkbox{
        display: none;
    }
    #m_type_1{
        display: none;
    }
    #upload-img{
        display: none;
    }
    label{
           color:#676a6c;
       }
</style>
    <div class="ibox float-e-margins" id="app">
        <div class="ibox-content" style="display: block;">
            <div class="row">
                <div class="wrapper wrapper-content animated fadeInRight" id="AddMenu">
                    <div class="addmenu-box">
                        {{--<div class="hint">--}}
                            {{--<p>--}}
                                {{--<i class="fa fa-info-circle"></i>注意<br>--}}
                                {{--1.自定义菜单最多包括3个一级菜单，每个一级菜单最多包含5个二级菜单。<br>--}}
                                {{--2.编辑中的菜单不会马上被用户看到，请放心调试。<br>--}}
                            {{--</p>--}}
                        {{--</div>--}}
                        {!! Form::open(['route' => 'admin.wechat.menu.store', 'class' => 'form-horizontal',
                           'role' => 'form', 'method' => 'post','id'=>'base-form']) !!}
                        <div class="tab-content">

                            <div class="panel-body">
                                <div class="form-group">
                                    {!! Form::label('title', '*菜单名:' , ['class' => 'control-label pull-left col-sm-2']) !!}
                                    <div class="col-sm-10">
                                        <input type="text" name="name" id="" class="form-control" value="{{$menuinfo->name}}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('meta_keywords', '*配置动作:', ['class' => 'control-label pull-left col-sm-2']) !!}
                                    <div class="col-sm-10">
                                        <select name="template" class="form-control action-select" @change="mateChange()" v-model="action">
                                        <option value="1">自定义</option>
                                        <option value="2">站内素材</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="material" v-model="selected" id="">
                                    <input type="hidden" name="action" v-model="action" id=""
                                    @if($menuinfo->type==='media_id')  value="2"   @endif
                                    >
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-2">
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="operation-box">
                                            <div class="operation-item">
                                                <div id="myTabContents">

                                                    {{ Widget::run('Materials','') }}

                                                    <div id="custom" class="check-box"
                                                         @if($menuinfo->type!=="media_id")
                                                         style="display:block"
                                                         @else
                                                         style="display:none"
                                                         @endif
                                                    >
                                                        <div class="controls">
                                                            <a class="check-item">
                                                                <input type="radio" name="type" id="click"  value="click"  data-href="click"
                                                                     @if($menuinfo->type==='click')
                                                                       checked
                                                                     @endif
                                                                >
                                                                <label for="click">
                                                                    点击推事件
                                                                </label>
                                                            </a>
                                                            <a class="check-item">
                                                                <input type="radio" name="type" id="view"  data-href="view" value="view"
                                                                       @if($menuinfo->type==='view')
                                                                         checked
                                                                        @endif
                                                                >
                                                                <label for="view">
                                                                    跳转URL
                                                                </label>
                                                            </a>

                                                            <a class="check-item">
                                                                <input type="radio" name="type" id="miniprogram" data-href="miniprogram" value="miniprogram"
                                                                       @if($menuinfo->type==='miniprogram')
                                                                       checked
                                                                        @endif
                                                                >
                                                                <label for="miniprogram">
                                                                    小程序
                                                                </label>
                                                            </a>

                                                            {{--<a class="check-item">--}}
                                                                {{--<input type="radio" name="type" id="scancode_waitmsg" data-href="scancode_waitmsg" value="scancode_waitmsg">--}}
                                                                {{--<label for="scancode_waitmsg">--}}
                                                                    {{--扫码带提示--}}
                                                                {{--</label>--}}
                                                            {{--</a>--}}

                                                            {{--<a class="check-item">--}}
                                                                {{--<input type="radio" name="type"  id="pic_sysphoto" data-href="pic_sysphoto" value="pic_sysphoto">--}}
                                                                {{--<label for="pic_sysphoto">--}}
                                                                    {{--弹出系统拍照发图--}}
                                                                {{--</label>--}}
                                                            {{--</a>--}}

                                                            {{--<a class="check-item">--}}
                                                                {{--<input type="radio" name="type" id="pic_weixin" data-href="pic_weixin" value="pic_weixin">--}}
                                                                {{--<label for="pic_weixin">--}}
                                                                    {{--弹出微信相册发图器--}}
                                                                {{--</label>--}}
                                                            {{--</a>--}}

                                                            {{--<a class="check-item">--}}
                                                                {{--<input type="radio" name="type" id="pic_photo_or_album" data-href="pic_photo_or_album" value="pic_photo_or_album">--}}
                                                                {{--<label for="pic_photo_or_album">--}}
                                                                    {{--弹出拍照或者相册发图--}}
                                                                {{--</label>--}}
                                                            {{--</a>--}}

                                                            {{--<a class="check-item">--}}
                                                                {{--<input type="radio" name="type" id="location_select" data-href="location_select" value="location_select">--}}
                                                                {{--<label for="location_select">--}}
                                                                    {{--弹出地理位置选择器--}}
                                                                {{--</label>--}}
                                                            {{--</a>--}}
                                                        </div>

                                                        <div class="tab-content form-group no-mini"
                                                            @if($menuinfo->type==='view'||$menuinfo->type==='click')
                                                                style="display: block"
                                                            @else
                                                             style="display: none"
                                                            @endif

                                                        >
                                                            {!! Form::label('meta_keywords', '*请填写关联的关键字或URL:', ['class' => 'control-label pull-left col-sm-2']) !!}
                                                            <div class="col-sm-10">
                                                                <input type="text" name="key" class="form-control col-sm-11 hinge text-content" placeholder="非汉字/如果是URL必须是完整的地址如http://www.baidu.com"
                                                                       @if($menuinfo->type==='view'||$menuinfo->type==='click')
                                                                       value="{{$menuinfo->key}}"
                                                                       @endif
                                                                >
                                                            </div>
                                                        </div>


                                                        <div class="tab-content form-group mini"
                                                             @if($menuinfo->type=='miniprogram')
                                                             style="display: block"
                                                             @else
                                                             style="display: none"
                                                                @endif

                                                        >
                                                            {!! Form::label('meta_keywords', '小程序appid', ['class' => 'control-label pull-left col-sm-2']) !!}
                                                            <div class="col-sm-10">
                                                                <input type="text" name="appid" class="form-control col-sm-11 hinge text-content" placeholder="appid"
                                                                       @if($menuinfo->type=='miniprogram')
                                                                       value="{{$menuinfo->appid}}"
                                                                        @endif
                                                                >
                                                            </div>

                                                            {!! Form::label('meta_keywords', '小程序页面路径', ['class' => 'control-label pull-left col-sm-2']) !!}
                                                            <div class="col-sm-10" style="margin-top: 10px">
                                                                <input type="text" name="pagepath" class="form-control col-sm-11 hinge text-content" placeholder="小程序的页面路径"
                                                                       @if($menuinfo->type=='miniprogram')
                                                                       value="{{$menuinfo->pagepath}}"
                                                                        @endif
                                                                >
                                                            </div>

                                                        </div>


                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('meta_keywords', '*排序:（数值越大越靠前）', ['class' => 'control-label pull-left col-sm-2']) !!}
                                    <div class="col-sm-10">
                                        <input type="number"  name="sort" class="number form-control" placeholder="1-100正整数" value="{{$menuinfo->sort}}">
                                    </div>
                                </div>


                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8 controls">
                                        <input type="hidden" name="pid" value="{{request('pid')}}">
                                        <input type="hidden" name="mid" value="{{$menuinfo->id}}">
                                        <button type="button" class="btn btn-primary" id="menu" data-type="{{$menuinfo->type}}">保存</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    var materialApi="{{route('admin.wechat.material.api')}}";
</script>

<script>
    @if($menuinfo->type==='view'||$menuinfo->type==='click'||$menuinfo->type==='miniprogram')
       $('#m_type_2').show();
    @endif

    var action="{{isset($material['data_type'])?2:1}}";
    var data_title="{{isset($material['data_title'])?$material['data_title']:''}}";
    var data_time="{{isset($material['data_time'])?$material['data_time']:''}}";
    var data_img="{{isset($material['data_img'])?$material['data_img']:''}}";
    var data_type="{{isset($material['data_type'])?$material['data_type']:''}}";
    var data_selected="{{isset($material['data_selected'])?$material['data_selected']:''}}"
    var stime="";
    var etime="";
</script>

@include('Wechat::widgets.material.js.materials_js')

<script>
    $(function () {
        // $('input').iCheck({
        //     checkboxClass: 'icheckbox_square-green',
        //     radioClass: 'iradio_square-green',
        //     increaseArea: '20%' // optional
        //
        // })

        LoadCSS('{{env("APP_URL").'/assets/wechat-backend/libs/icheck/custom.css'}}');
        LoadCSS('{{env("APP_URL").'/assets/wechat-backend/css/reply.css'}}');
        LoadCSS('{{env("APP_URL").'/assets/wechat-backend/libs/datepicker/bootstrap-datetimepicker.min.css'}}');

        $.getScript('{{env("APP_URL").'/assets/wechat-backend/libs/datepicker/bootstrap-datetimepicker.js'}}',function () {
            $.fn.datetimepicker.dates['zh-CN'] = {
                days: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六", "星期日"],
                daysShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六", "周日"],
                daysMin:  ["日", "一", "二", "三", "四", "五", "六", "日"],
                months: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
                monthsShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
                today: "今天",
                suffix: [],
                meridiem: ["上午", "下午"]
            };
            $('.form_datetime').datetimepicker({
                minView: 0,
                format: "yyyy-mm-dd hh:ii",
                autoclose: 1,
                language: 'zh-CN',
                weekStart: 1,
                todayBtn: 1,
                todayHighlight: 1,
                startView: 2,
                forceParse: 0,
                showMeridian: true,
                minuteStep: 1,
                maxView: 4
            });
            //            开始
            $('.form_datetime_stime').on('changeDate',function (ev) {
                stime=timeDate(ev.date);
            })
//            截止
            $('.form_datetime_etime').on('changeDate',function (ev) {
                etime=timeDate(ev.date);
            })
            function timeDate (d) {
                var date = (d.getFullYear()) + "-" +
                    (d.getMonth() + 1) + "-" +
                    (d.getDate()) + " " +
                    (d.getHours()) + ":" +
                    (d.getMinutes());
                return date;
            }
        })




        $('.delSearch').click(function () {
            $('.form_datetime input').val('');
        });

    if(data_type){
        $('.m_type_'+data_type).show();
        $('#checkbox-'+data_type).iCheck('check');

    }

        $('#base-form').submit(function () {
            return false;
        })

    $('#instationMaterial .check-item input').on('ifChecked', function(event){
        var type=$(this).data('type');
        $('#upload-img').hide();
        $('.m_type').hide();
        $('#m_type_'+type).show();
    });

    $('input[name=type]').on('ifChecked', function(event){
        var type=$(this).data('href');

        if(type=='miniprogram'){
            $('.mini').show()
            $('.no-mini').hide();$('input[name=key]').val('');
        }else{
            $('.no-mini').show();$('input[name=appid]').val('');$('input[name=pagepath]').val('');
            $('.mini').hide()
        }

        var menu=$('#menu');
        menu.data('type',type);
    });


    $('#menu').click(function () {
        var name=$('input[name=name]').val();
        var sort=$('input[name=sort]').val();
        var action=$('input[name=action]').val();
        var key=$('input[name=key]').val();
        var media_id=$('input[name=material]').val();
        var pid=$('input[name=pid]').val();
        var mid=$('input[name=mid]').val();
        var type=$(this).data('type');

        var appid=$('input[name=appid]').val();
        var pagepath=$('input[name=pagepath]').val();


        if(name==''){
            toastr.error('请输入菜单名');
            return false;
        }else if(action==1&&key==''&&type!='miniprogram'){
            toastr.error('请输入关联的KEY或URL');
            return false;
        }else if(action==2&&media_id==''){
            toastr.error('请选择相关素材');
            return false;
        }else if(sort==''||parseInt(sort)<0||parseInt(sort)>100){
            toastr.error('1-100正整数');
            return false;
        }

        var data={
            name:name,
            key:key,
            type:type,
            sort:sort,
            pid:pid,
            id:mid,
            _token:_token
        }


        if(type=='miniprogram'){
            if(action==1&&appid==''){
                toastr.error('请输入小程序appid');
                return false;
            }else if(action==1&&pagepath==''){
                toastr.error('小程序页面路径');
                return false;
            }

            data.appid=appid;
            data.pagepath=pagepath;

        }


        if(action==2){
            data.type='media_id';
            data.key=media_id;
        }

        $.ajax({
            type:"post",
            url:"{{route('admin.wechat.menu.update')}}",
            data:data,
            success:function(res){
                if(res.status){
                    swal({
                        title: "保存成功！",
                        text: "",
                        type: "success"
                    }, function () {
                        location = '{!!route('admin.wechat.menu.index')!!}'
                    });
                }else{
                    swal({
                        title: "保存失败！",
                        text:res.message,
                        type: "error"
                    });
                }
            }
        });

    })

})
</script>
@include('wechat-backend::active')