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
        pageSize:20,
        total:0,
        currentPage:1,
        ticket:'',
    },
    methods:{
        handleCurrentChange:function(val) {
            this.currentPage = val;
            var that = this;
            $.ajax({
                type:"get",
                url:ScansApi,
                data:{'pageSize':that.pageSize,'page':val,'type':that.type,'stime':that.stime,'etime':that.etime,'keyword':that.keyword},
                success:function(res){
                    if(res.status){
                        that.total=parseInt(res.data.total);
                        that.pageSize=parseInt(res.data.per_page);
                        that.currentPage=parseInt(res.data.current_page);
                        that.scans=res.data.data;
                    }
                }
            });

        },
        getData:function () {
            var that = this;
            that.data=[];
            console.log(that.type);
            $.ajax({
                type:"get",
                url:ScansApi,
                data:{'pageSize':that.pageSize,'type':that.type,'stime':that.stime,'etime':that.etime,'keyword':that.keyword},
                success:function(res){
                    $('.tr-show').show();
                    if(res.status){
                        that.total=parseInt(res.data.total);
                        that.pageSize=parseInt(res.data.per_page);
                        that.currentPage=parseInt(res.data.current_page);
                        that.scans=res.data.data;
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
            this.getData();
        }
    },

    mounted(){
        this.start();
    }
});




