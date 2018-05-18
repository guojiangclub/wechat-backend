<script>
    new Vue({
        delimiters: ['{#', '#}'],
        el:'.app',
        data:{
            copy:0,


            _token:'',
            m_type:1,
            selected:'',
            data:[],
            type:'image',
            keyword:'',
            pageSize:30,
            total:1,
            currentPage:1,
            stime:'',
            etime:'',
            state:true,
        },
        methods:{
            handleCurrentChange:function (val) {
                if(this.state){
                    this.currentPage = val;
                    this.state=false;
                    var that = this;
                    $.ajax({
                        type:"get",
                        url:materialApi,
                        data:{'type':that.type,'pageSize':that.pageSize,'page':val,'keyword':that.keyword,'stime':that.stime,'etime':that.etime},
                        success:function(res){
                            if(res.status){
                                that.data=res.data.data;
                                that.total=res.data.total;
                                that.pageSize=parseInt(res.data.per_page);
                                that.currentPage=res.data.current_page;
                                that.state=true;
                            }
                        }
                    });
                }
            },
            getData:function () {
                var that = this;
                that.data=[];
                $('.loading').show();
                $.ajax({
                    type:"get",
                    url:materialApi,
                    data:{'type':that.type,'pageSize':that.pageSize,'keyword':that.keyword,'stime':that.stime,'etime':that.etime},
                    success:function(res){
                        if(res.status){
                            that.data=res.data.data;
                            that.total=res.data.total;
                            that.pageSize=parseInt(res.data.per_page);
                            that.currentPage=res.data.current_page;
                            $('.loading').hide();
                            $('.data-show-count')
                                    .show();
                        }
                    }
                });
            },

// ----------------------------- 搜索----------------------------
            Search:function () {
                this.stime=stime;
                this.etime=etime;
                this.getData();
            },
            delSearch:function () {
                stime='';
                etime='';
                this.stime='';
                this.etime='';
                this.keyword='';
                this.getData();
            },

            Del:function (id) {
                    var url = decodeURIComponent(delApi).replace('#',id);
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
                            id: id,
                            '_token':this._token
                        }, function (ret) {
                            console.log(ret);
                            if(ret.status){
//                                var li = $(this).parents('li');
//                                $('.picture_list').find("li[data-id=" + id + "]").remove();
                                done();
                                instance.confirmButtonLoading = false;
                                toastr.success('删除成功');
                                window.location.reload();
                            }else{
                                done();
                                instance.confirmButtonLoading = false;
                                toastr.error(ret.message);
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

            copyURL:function (id) {
                 if(id==this.copy) return false;
                 this.copy=id;
                $('#copy'+id).zclip({
                    path: "{{url('assets/wechat-backend/libs/jquery.zclip/ZeroClipboard.swf')}}",
                    copy: function(){
                        return $(this).data('url');
                    },
                    afterCopy:function(){/* 复制成功后的操作 */
                        toastr.success('复制链接成功');
                        return false;
                    }
                });

            },


// ----------------------------- 搜索----------------------------

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

            decodeURI:function(str){
                return this.htmlspecialchars_decode(decodeURIComponent(str));
            },

            htmlspecialchars_decode:function (str){
                str = str.replace(/&amp;/g, '&');
                str = str.replace(/&lt;/g, '<');
                str = str.replace(/&gt;/g, '>');
                str = str.replace(/&quot;/g, "''");
                str = str.replace(/&#039;/g, "'");
                return str;
            },


            Edit:function (id) {
                var url = decodeURIComponent(editApi).replace('#', id);
                window.location.href=url;
            },

            EditArticle:function (id) {
                var url = decodeURIComponent(editArticleApi).replace('#', id);
                window.location.href=url;
            },

            start:function(){
                var _token=window._token;
                this._token=_token;
                this.type=type;
                this.getData();
            }
        },


        mounted(){
            $('.data-show').show();
            this.start();
        }

    })
</script>




