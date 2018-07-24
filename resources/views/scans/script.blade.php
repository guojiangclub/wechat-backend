
<script>
new Vue({
    delimiters: ['{#', '#}'],
    el:'.tabs-container',
    data:{
        info:[],
        fans_group:[],
        stime:"",
        etime:"",
        loading: true,
        scans:[],
        type:'',
        keyword:'',
        limit:20,
        total:0,
        currentPage:1,
        ticket:'',
        route_name:'',
        loadUrl:''
    },
    methods:{
        handleCurrentChange:function(val) {
            this.route_name='';
            this.currentPage = val;
            var that = this;
            $.ajax({
                type:"get",
                url:ScansApi,
                data:{'limit':that.limit,'page':val,'type':that.type,'stime':that.stime,'etime':that.etime,'keyword':that.keyword},
                success:function(res){
                    if(res.status){
                        that.total=parseInt(res.data.scans.total);
                        that.limit=parseInt(res.data.scans.per_page);
                        that.currentPage=parseInt(res.data.scans.current_page);
                        that.scans=res.data.scans.data;
                        that.route_name=res.data.route_name;

                    }
                }
            });

        },
        thauy: function () {
            geturl(this.loadUrl ,this.route_name);
        },
        getData:function () {
            this.route_name='';
            var that = this;
            that.data=[];
            $.ajax({
                type:"get",
                url:ScansApi,
                data:{'limit':that.limit,'type':that.type,'stime':that.stime,'etime':that.etime,'keyword':that.keyword},
                success:function(res){
                    $('.tr-show').show();
                    if(res.status){
                        that.total=parseInt(res.data.scans.total);
                        that.limit=parseInt(res.data.scans.per_page);
                        that.currentPage=parseInt(res.data.scans.current_page);
                        that.scans=res.data.scans.data;
                        that.route_name=res.data.route_name;
                    }
                }
            });

        },
        decodeURI:function(str){
            return decodeURIComponent(str)
        },


        Search:function () {
            this.stime=stime;
            this.etime=etime;
            console.log(etime);
            this.getData();
        },

        delSearch:function () {
            stime="";
            etime="";
            this.stime='';
            this.etime='';
            this.keyword='';
            this.route_name='';
            $('.form_datetime_stime input').val('');
            $('.form_datetime_etime input').val('');
            $('.keyword').val('');
            this.getData();
        },

        // 解析Url
        parseUrl:function (url) {
            url = url || window.location.search.replace(/^\?/, '');
            var params = {};
            if (url) {
                url.split('&').forEach(function (part) {
                    var parts = part.split('=');
                    var name = parts.shift();
                    var value = parts.join('&');

                    if (/\[]$/.test(name)) {
                        name = name.replace(/\[]$/, '');
                        params[name] = params[name] || [];
                        params[name].push(value);
                    } else {
                        params[name] = value;
                    }
                })
            }
            return params;
        },

        getInfo:function (openid) {
            var url = decodeURIComponent(getInfo).replace('#', openid);
            $('#textModal').modal('show');
            var that=this;
            $.ajax({
                type:"get",
                url:url,
                data:{'openid':openid},
                success:function(res){
                    if(res.status){
                        $('.loading').hide();
                        that.info=res.data;
                        if(res.data.fans_group.length){
                            that.fans_group=res.data.fans_group[0];
                        }
                    }
                }
            });
        },

        // Url赋值
        stringifyUrl:function(params) {
            var urls = [];
            for (var name in params) {
                if (!params.hasOwnProperty(name)) continue;
                if (Object.prototype.toString.call(params[name]) === '[object Array]') {
                    params[name].forEach(function (value) {
                        urls.push(name + '[]=' + value);
                    });
                } else {
                    urls.push(name + '=' + params[name]);
                }
            }

            if (urls.length) {
                return '?' + urls.join('&');
            } else {
                return '';
            }
        },
        start:function(){
            this.type=type;
            this.stime=stime;
            this.etime=etime;
            this.loadUrl=loadUrl;
            this.getData();
        }
    },

    mounted(){
        this.start();
    }
});

</script>


