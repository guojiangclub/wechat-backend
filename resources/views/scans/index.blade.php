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
            <a href="{{route('admin.wechat.QRCode.count.scans',['ticket'=>request('ticket')])}}">全部 &nbsp;&nbsp;<span class="badge">{{$AllCount}}</span>
            </a>
        </li>
        <li class="{{ Active::query('type',2) }}">
            <a href="{{route('admin.wechat.QRCode.count.scans',['ticket'=>request('ticket'),'type'=>2])}}">扫描&nbsp;&nbsp;<span class="badge">{{$DEFAULT_SCANS_Count}}</span>
            </a>
        </li>
        <li class="{{ Active::query('type',1) }}">
            <a href="{{route('admin.wechat.QRCode.count.scans',['ticket'=>request('ticket'),'type'=>1])}}">关注&nbsp;&nbsp;<span class="badge">{{$FOLLOW_SCANS_Count}}</span>
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
                            <div class="btn btn-default" @click="Search()"><i class="fa fa-search"></i></div>
                        <div class="btn btn-default delSearch" @click="delSearch()"><i class="fa fa-trash"></i></div>
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

<script>
    var getInfo = "{{route('admin.wechat.fans.info','#')}}";
    var ScansApi = "{{route('admin.wechat.QRCode.count.api.scans')}}";
    var type = "{{$type}}";
    var stime = "";
    var etime = "";

    $(function () {
	    $('.form_datetime').datetimepicker({
		    format: "yyyy-mm-dd hh:ii"
	    });

	    $('.form_datetime_stime').on('changeDate', function (ev) {
		    stime = timeDate(ev.date);
	    });

	    $('.form_datetime_etime').on('changeDate', function (ev) {
		    etime = timeDate(ev.date);
	    });

	    function timeDate(d) {
		    var date = (d.getFullYear()) + "-" +
			    (d.getMonth() + 1) + "-" +
			    (d.getDate()) + " " +
			    (d.getHours()) + ":" +
			    (d.getMinutes());
		    return date;
	    }

    });

    $.getScript('/assets/wechat-backend/libs/element/vue.js', function () {
        @include('Wechat::scans.script')
    });
</script>