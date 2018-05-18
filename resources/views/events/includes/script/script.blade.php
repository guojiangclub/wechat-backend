<script>
    new Vue({
        delimiters: ['{#', '#}'],
        el:'.tab-content',
        data:{
            loading: true,
            events:[],
            m_type:1,
            Keyword:'',
            pageSize:20,
            total:0,
            currentPage:1,
            keybtn:[],
        },
        methods:{
            handleCurrentChange:function(val) {
                this.currentPage = val;
                this.keybtn=[];
                this.events=[];
                var that = this;
                $.ajax({
                    type:"get",
                    url:EventsApi,
                    data:{'m_type':that.m_type,'pageSize':that.pageSize,'page':val,'key':that.Keyword},
                    success:function(res){
                        if(res.status){
                            that.total=parseInt(res.data.total);
                            that.pageSize=parseInt(res.data.per_page);
                            that.currentPage=parseInt(res.data.current_page);
                            that.keybtnFn(res.data.data);
                            that.events=res.data.data;
                        }
                    }
                });

            },
            getData:function () {
                var that = this;
                that.data=[];
                var url=this.parseUrl();
                that.m_type=url.m_type;
                $.ajax({
                    type:"get",
                    url:EventsApi,
                    data:{'m_type':that.m_type,'pageSize':that.pageSize,'key':that.Keyword},
                    success:function(res){
                        if(res.status){
                            $('.tr-show').show();
                            that.total=parseInt(res.data.total);
                            that.pageSize=parseInt(res.data.per_page);
                            that.currentPage=parseInt(res.data.current_page);
                            that.keybtnFn(res.data.data);
                            that.events=res.data.data;
                        }
                    }
                });

            },

            keybtnFn:function (data) {
                var that = this;
                if(data.length){
                  for(var i in data){
                      if(data[i]['key']!==''){
                          var itemKey=data[i]['key'].split(" ") ;
                          that.keybtn[data[i]['id']]=itemKey;
                      }
                  }
                }
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
                        id: id,
                        _token:_token
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

            start:function(){
                this.getData();
            }
        },


    mounted(){
            this.start();
        }

    })
</script>




