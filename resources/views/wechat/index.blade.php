<div class="ibox float-e-margins">
    <div class="ibox-content" style="display: block;">
        <div class="row">
            <div class="panel-body">



                <div class="col-md-6">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">粉丝曲线图</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <canvas id="myChart1" width="400" height="400"></canvas>
                            </div>
                            <!-- /.table-responsive -->
                        </div>

                    </div>
                </div>


                <div class="col-md-6">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">图文阅读曲线图</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <canvas id="myChart2" width="400" height="400"></canvas>
                            </div>
                            <!-- /.table-responsive -->
                        </div>

                    </div>
                </div>


                <div class="col-md-6">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">扫码曲线图</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <canvas id="myChart3" width="400" height="400"></canvas>
                            </div>
                            <!-- /.table-responsive -->
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<script>
    var fans_data_ref_date=[0,0,0,0,0,0,0];
    var fans_data_cumulate_user=[0,0,0,0,0,0,0];

    @if(isset($fans_data['ref_date']))
        fans_data_ref_date=[
        "{{$fans_data['ref_date'][0]}}",
        "{{$fans_data['ref_date'][1]}}",
        "{{$fans_data['ref_date'][2]}}",
        "{{$fans_data['ref_date'][3]}}",
        "{{$fans_data['ref_date'][4]}}",
        "{{$fans_data['ref_date'][5]}}",
        "{{$fans_data['ref_date'][6]}}",
        ]
    @endif
    @if(isset($fans_data['cumulate_user']))
        fans_data_cumulate_user=[
        "{{$fans_data['cumulate_user'][0]}}",
        "{{$fans_data['cumulate_user'][1]}}",
        "{{$fans_data['cumulate_user'][2]}}",
        "{{$fans_data['cumulate_user'][3]}}",
        "{{$fans_data['cumulate_user'][4]}}",
        "{{$fans_data['cumulate_user'][5]}}",
        "{{$fans_data['cumulate_user'][6]}}",
    ]
    @endif
</script>


<script>

    $(function () {
        var ctx = document.getElementById("myChart1").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: fans_data_ref_date,
                datasets: [{
                    label: '粉丝',
                    data: fans_data_cumulate_user,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    });
</script>


<script>
    var article_data_ref_date=[0,0,0];
    var article_data_int_page_read_count=[0,0,0];
        @if(isset($article_data['ref_date']))
            article_data_ref_date=[
        "{{$article_data['ref_date'][0]}}",
        "{{$article_data['ref_date'][1]}}",
        "{{$article_data['ref_date'][2]}}",

    ]
    @endif
            @if(isset($article_data['int_page_read_count']))
        article_data_int_page_read_count=[
        "{{$article_data['int_page_read_count'][0]}}",
        "{{$article_data['int_page_read_count'][1]}}",
        "{{$article_data['int_page_read_count'][2]}}",

    ]
    @endif
</script>


<script>

    $(function () {
        var ctx = document.getElementById("myChart2").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: article_data_ref_date,
                datasets: [{
                    label: '图文阅读数',
                    data: article_data_int_page_read_count,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    });
</script>



<script>
    var scan_data_ref_date=[0,0,0,0,0,0,0];
    var scan_data_count=[0,0,0,0,0,0,0];

    @if(isset($scan_data['ref_date']))
        scan_data_ref_date=[
        "{{$scan_data['ref_date'][0]}}",
        "{{$scan_data['ref_date'][1]}}",
        "{{$scan_data['ref_date'][2]}}",
        "{{$scan_data['ref_date'][3]}}",
        "{{$scan_data['ref_date'][4]}}",
        "{{$scan_data['ref_date'][5]}}",
        "{{$scan_data['ref_date'][6]}}",
    ]
    @endif
       @if(isset($scan_data['count']))
        scan_data_count=[
        "{{$scan_data['count'][0]}}",
        "{{$scan_data['count'][1]}}",
        "{{$scan_data['count'][2]}}",
        "{{$scan_data['count'][3]}}",
        "{{$scan_data['count'][4]}}",
        "{{$scan_data['count'][5]}}",
        "{{$scan_data['count'][6]}}",
    ]
    @endif
</script>


<script>

    $(function () {
        var ctx = document.getElementById("myChart3").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: scan_data_ref_date,
                datasets: [{
                    label: ' 二维码扫描数',
                    data: scan_data_count,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    });
</script>