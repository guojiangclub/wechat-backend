<script>
    new Vue({
        delimiters: ['{#', '#}'],
        el:'.tab-content',
        data:{
            loading: true,
            codes:[],
            type:2,
            Keyword:'',
            pageSize:20,
            total:0,
            currentPage:1,
        },
        methods:{
            handleCurrentChange:function(val) {
                this.currentPage = val;
                var that = this;
                $.ajax({
                    type:"get",
                    url:CodesApi,
                    data:{'type':that.type,'pageSize':that.pageSize,'page':val,'key':that.Keyword},
                    success:function(res){
                        if(res.status){
                            that.total=parseInt(res.data.total);
                            that.pageSize=parseInt(res.data.per_page);
                            that.currentPage=parseInt(res.data.current_page);
                            that.codes=res.data.data;
                        }
                    }
                });

            },
            getData:function () {
                var that = this;
                that.data=[];
                var url=this.parseUrl();
                that.type=url.type;
                $.ajax({
                    type:"get",
                    url:CodesApi,
                    data:{'type':that.type,'pageSize':that.pageSize,'key':that.Keyword},
                    success:function(res){
                        if(res.status){
                            $('.tr-show').show()
                            that.total=parseInt(res.data.total);
                            that.pageSize=parseInt(res.data.per_page);
                            that.currentPage=parseInt(res.data.current_page);
                            that.codes=res.data.data;
                        }
                    }
                });

            },


            Expire:function (time) {
                var timestamp1 = new Date(time), timestamp2 = new Date();
                var d = timestamp1.getTime() - timestamp2.getTime()
                if(d<0){
                    var str='已过期';
                    return str;
                }
                return time;
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


            Delete:function (id) {
                var url = decodeURIComponent(deleteApi).replace('#', id);
                event.stopPropagation();
                this.$msgbox({
                            title: '提示',
                            message: '确认删除么？',
                            showCancelButton: true,
                            confirmButtonText: '确定',
                            cancelButtonText: '取消',
                            beforeClose: (action, instance, done) => {
                            // 提交
                            if (action === 'confirm') {
                    instance.confirmButtonLoading = true;
                    instance.confirmButtonText = '执行中...';
                    $.post(url, {
                        id: id
                    }, function (ret) {
                        console.log(ret);
                        if(ret.status){
                            done();
                            instance.confirmButtonLoading = false;
                            toastr.success('删除成功');
                            location.reload();
                        }
                    });
                }else{
                    done();
                    instance.confirmButtonLoading = false;
                }

            }
            }).then(action => {
//                    this.$message({
//                    type: 'info',
//                    message: '成功' + action
//                });
                });

            },

            Edit:function (id) {
                var url = decodeURIComponent(editApi).replace('#', id);
                window.location.href=url;
            },

            Scans:function (ticket) {
                var that=this;
                var ScansUrl = decodeURIComponent(ScansApi).replace('#', ticket);
                window.location.href=ScansUrl;
            },
            start:function(){
                this.getData();
            }
        },

        mounted(){
            this.start();
        }

    })
</script>




