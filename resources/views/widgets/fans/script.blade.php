new Vue({
    delimiters: ['{#', '#}'],
    el:'#app',
    data:{
        select_group:0,
        groups:[],
        names:[],
        isIndeterminate:false,
        all:[],
        _token:'',
        state:false,
        status:'create',
        selected:[],
        data:[],
        keyword:'',
        pageSize:15,
        total:1,
        currentPage:1,
        real:{
            selected:[],
        },
        stime:'',
        etime:'',
        datasub:[],

    },
    methods:{
        handleCurrentChange:function (val) {
            if(this.state){
                this.isIndeterminate = false;
                this.currentPage = val;
                this.state=false;
                var that = this;
                $.ajax({
                    type:"get",
                    url:FansApi,
                    data:{'type':that.type,'pageSize':that.pageSize,'page':val,'nickname':that.keyword,'stime':that.stime,'etime':that.etime,'groupId':that.select_group},
                    success:function(res){
                        if(res.status){
                            that.data=res.data.fans.data;
                            that.total=res.data.fans.total;
                            that.pageSize=parseInt(res.data.fans.per_page);
                            that.currentPage=res.data.fans.current_page;
                            that.state=true;
                            that.groups=res.data.groups;
                        }
                    }
                });
            }
        },
        getData:function () {
            console.log(this.select_group);
            var that = this;
            that.data=[];
            $('.loading').show();
            $.ajax({
                type:"get",
                url:FansApi,
                data:{'type':that.type,'pageSize':that.pageSize,'nickname':that.keyword,'stime':that.stime,'etime':that.etime,'groupId':that.select_group},
                success:function(res){
                    if(res.status){
                        that.data=res.data.fans.data;
                        if(res.data.fans.data.length>0){
                            var item=res.data.fans.data;
                            for(var i=0;i<item.length;i++){
                                that.all[i]=item[i]['openid'];
                            }
                        }
                        that.total=res.data.fans.total;
                        that.pageSize=parseInt(res.data.fans.per_page);
                        that.currentPage=res.data.fans.current_page;
                        that.groups=res.data.groups;
                        $('.loading').hide();
                        that.state=true;
                    }
                }
            });
        },



        decodeURI:function(str){
            return decodeURIComponent(str)
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

// -----------------------------关闭模态框-----------------------------
        ModalDel:function () {
            $('.data-show').show();
            var that=this;
            that.real.selected='';
            that.keyword='';
            that.stime='';
            that.etime='';
        },
        // 删除数据
        delData:function () {
            var that=this;
            that.real.selected='';
            that.keyword='';
            that.selected='';

        },

        // -----------------------------文本模态框-----------------------------
        textModal:function () {
            $('#textModal').modal('show');
            this.type='text';
            this.getData();
        },

        Submit:function () {
            var that=this;
            console.log(that.real.selected);
            if(that.real.selected.length>0){
                that.selected=that.real.selected;
                $('#textModal').modal('hide');
            }else{
                toastr.error('请选择粉丝');
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


        Sendout:function () {
            var url=$('input[name=url]').val();
            var template_id=$('input[name=template_id]').val()
            if(url==''){
                toastr.error('详情链接不能为空');
                return;
            }else if(template_id==""){
                toastr.error('模板ID不能为空');
                return;
            }
            var input={};
            var names=this.names;
            for (var i=0;i<names.length;i++){
                var val=$('.'+names[i]+'_input').val();
                var title=names[i];
                console.log(names[i]);
                if(val==''){
                    toastr.error(title+'不能为空');
                    return;
                }
                input[title]=val;
            }

            if(this.selected.length<=0){
                toastr.error('请选择粉丝');
                return;
            }
            var data={
                template_id:template_id,
                url:url,
                touser:this.selected,
                data:input,
                _token:this._token,
            }

            $.ajax({
                type:"post",
                url:sendOutApi,
                data:data,
                success:function(res){
                    if(res.status){
                        swal({
                        title: "发送成功",
                        text: "",
                        type: "success"
                        }, function () {
                            location.reload();
                        });
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

        handleCheckAllChange:function () {
            this.real.selected = event.target.checked ? this.all : [];
            this.isIndeterminate = false;
        },

        handleCheckedCitiesChange:function(value) {
            var  checkedCount =this.real.selected .length;
            this.isIndeterminate = checkedCount > 0 && checkedCount < this.all.length;
        },


        start:function(){
            var _token=$('meta[name="_token"]').attr('content');
            this._token=_token;
            this.names= names;

        }
    },


    mounted(){
        $('.data-show').show();
        this.start();
    }

})