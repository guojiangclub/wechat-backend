@if(Session::has('message'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> 提示！</h4>
        {{ Session::get('message')}}
    </div>
@endif



<div class="tabs-container">
    <ul class="nav nav-tabs">
        <li @if(empty($type)) class="active" @endif>
            <a no-pjax href="{{route('admin.wechat.QRCode.count.scans',['ticket'=>request('ticket')])}}">全部 &nbsp;&nbsp;<span class="badge">{{$AllCount}}</span>
            </a>
        </li>
        <li class="{{ Active::query('type',2) }}">
            <a no-pjax href="{{route('admin.wechat.QRCode.count.scans',['ticket'=>request('ticket'),'type'=>2])}}">扫描&nbsp;&nbsp;<span class="badge">{{$DEFAULT_SCANS_Count}}</span>
            </a>
        </li>
        <li class="{{ Active::query('type',1) }}">
            <a no-pjax href="{{route('admin.wechat.QRCode.count.scans',['ticket'=>request('ticket'),'type'=>1])}}">关注&nbsp;&nbsp;<span class="badge">{{$FOLLOW_SCANS_Count}}</span>
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" role="tabpanel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-3" style="margin-left:28px;">
                        <div class="input-group">
                            <input type="text" class="form-control keyword" :value="keyword" placeholder="场景名称" v-model="keyword">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group date form_datetime_stime form_datetime">
                            <span class="input-group-addon" style="cursor: pointer">
                                <i class="fa fa-calendar"></i>&nbsp;&nbsp;扫描时间
                            </span>
                            <input type="text" style="width: 151px;" class="form-control inline" name="stime" placeholder="开始 " readonly>
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group date form_datetime_etime form_datetime">
                            <span class="input-group-addon" style="cursor: pointer">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input type="text" style="width:150px;" class="form-control" name="etime" placeholder="截止" readonly>
                            <span class="add-on"><i class="icon-th"></i></span>
                            <div class="btn btn-default col-sm-2" @click="Search()"><i class="fa fa-search"></i></div>
                            <div class="btn btn-default delSearch col-sm-2" @click="delSearch()"><i class="fa fa-trash"></i></div>


                            <div class="col-sm-2">
                                <a class="btn btn-primary ladda-button dropdown-toggle batch" data-toggle="dropdown"
                                   href="javascript:;" data-style="zoom-in">导出<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        {{--<a  class="route_name"  data-toggle="modal"--}}
                                            {{--data-target="#download_modal" data-backdrop="static" data-keyboard="false"--}}
                                            {{--data-link="{{route('admin.scans.getExportData',['type'=>'xls'])}}" id="all-xls"--}}
                                            {{--data-url="{{route('admin.export.index',['toggle'=>'all-xls'])}}"--}}
                                            {{--data-type="xls"--}}
                                            {{--data-route=""--}}
                                            {{--href="javascript:;">导出所有</a></li>--}}

                                    <li><a  class="route_name" data-toggle="modal-filter"
                                           data-target="#download_modal" data-backdrop="static" data-keyboard="false"
                                           id="filter-xls"
                                           data-url="{{route('admin.export.index',['toggle'=>'filter-xls'])}}"
                                           data-type_="xls"
                                           :data-link="route_name"
                                           href="javascript:;" @click="thauy">导出结果</a></li>

                                </ul>
                            </div>
                </div>
            </div>
        </div>





        <div class="row">
            @include('Wechat::scans.list')
        </div>
    </div>
</div>
</div>
</div>
<div id="download_modal" class="modal inmodal fade"></div>

<script>
    var getInfo = "{{route('admin.wechat.fans.info','#')}}";
    var ScansApi = "{{route('admin.wechat.QRCode.count.api.scans')}}";
    var loadUrl="{{route('admin.export.index',['toggle'=>'filter-xls'])}}";
    var type = "{{$type}}";
    var stime = "";
    var etime = "";
    var thats = this;
    $(function () {
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


    });

    function geturl(loadUrl, data) {

        var $this = $('.route_name'),
            href = $this.attr('href')

        var type = $('.route_name').data('type_');

        window.link_get_data_url=data;

        if (loadUrl) {
            var $target = $($this.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, '')));
            $target.modal('show');
            $target.html('').load(loadUrl, function () {
                $('.modal-body div').removeClass('row');

            });
        }
    }

</script>

@include('Wechat::scans.script')
@include('wechat-backend::active')