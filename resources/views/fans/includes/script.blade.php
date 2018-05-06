new Vue({
    delimiters: ['{#', '#}'],
    el:'#app',
    data:{
        _token:'',
        nickname:'',
        visible:false,
        fans:[],
        groups:[],
        groupId:0,
        pageSize:30,
        total:0,
        currentPage:1,
        info:[],
        fans_group:[],

        dialogVisible: false,

        checked:[],
        checkedAll:[],
        oldChecked:[],
        select_group:-1,
        count:0,
        checkedAll_status:false,

        inputVisible: false,
        inputValue: '',
        dynamicTags: ['标签一', '标签二', '标签三'],
    },
    methods:{

        handleCurrentChange:function(val) {
            this.InitializationData();
            this.currentPage = val;
            var that = this;
            $.ajax({
                type:"get",
                url:fansApi,
                data:{'groupId':that.groupId,'pageSize':that.pageSize,'page':val},
                success:function(res){
                    if(res.status){
                        that.fans=res.data.fans.data;
                        that.total=res.data.fans.total;
                        that.pageSize=parseInt(res.data.fans.per_page);
                        that.currentPage=res.data.fans.current_page;
                        that.groups=res.data.groups;
                        that.getAll();
                    }
                }
            });

        },

        createGroup:function () {
            var that = this;
            this.$prompt('标签组名称', '创建标签组', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                inputPattern:/^[\s\S]+$/,
                inputErrorMessage: '请输入标签组名',

            }).then(({ value }) => {
                if (window.doingPostGroup) return;
            window.doingPostGroup = true;
            $.post(storeFansGroup, {
                name: value,
            }, function (ret) {
                if(ret.status){
                    var group=[];
                    group['group_id']=ret.data.group_id;
                    group['title']=ret.data.name;
                    group['fan_count']=0;
                    that.groups.push(group);
                    window.doingPostGroup = false;
                    toastr.success('创建成功');
                }
            });
        }).catch(() => {
            });

        },

        delGroup:function (group_id){
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
                $.post(delFansGroup, {
                    group_id: group_id
                }, function (ret) {
                    if(ret.status){
                        var li = $(this).parents('li');
                        $('#group-ul').find("li[data-group_id=" + group_id + "]").remove();
                        done();
                        instance.confirmButtonLoading = false;
                        toastr.success('删除成功');
                        window.location.reload();
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


        editGroup:function (group_id,title) {
            event.stopPropagation();
            var that = this;
            this.$prompt('用户组名称', '编辑用户组', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                inputPattern:/^[\s\S]+$/,
                inputErrorMessage: '请输入用户组名',
                inputValue:title,
            }).then(({ value }) => {
                if (window.doingPostGroup) return;
            window.doingPostGroup = true;

            $.post(editFansGroup, {
                name: value,
                group_id:group_id
            }, function (ret) {
                if(ret.status){
                    var name=ret.data.name;
                    var li = $(this).parents('li');
                    $('#group-ul').find("li[data-group_id=" + group_id + "] .group-list-name").text(name);
                    window.doingPostGroup = false;
                    toastr.success('编辑成功');
                }
            });
        }).catch(() => {
            });

        },

        getData:function () {
            var that = this;
            that.data=[];
            $('#loading').show();
            $.ajax({
                type:"get",
                url:fansApi,
                data:{'groupId':that.groupId,'pageSize':that.pageSize,'nickname':that.nickname},
                success:function(res){
                    if(res.status){
                        $('.fans-list-show').show();
                        $('.group-li-show').show();
                        $('#loading').hide();
                        that.fans=res.data.fans.data;
                        that.total=res.data.fans.total;
                        that.pageSize=parseInt(res.data.fans.per_page);
                        that.currentPage=res.data.fans.current_page;
                        that.groups=res.data.groups;
                        that.getAll();
                    }
                }
            });

        },

        decodeURI:function(str){
            return decodeURIComponent(str)
        },




        switchGroup:function (group_id) {
            this.InitializationData();
            var that = this;
            that.groupId=group_id;
            that.data=[];
            $.ajax({
                type:"get",
                url:fansApi,
                data:{'groupId':that.groupId,'pageSize':that.pageSize,'nickname':that.nickname},
                success:function(res){
                    if(res.status){
                        that.fans=res.data.fans.data;
                        that.total=res.data.fans.total;
                        that.pageSize=parseInt(res.data.fans.per_page);
                        that.currentPage=res.data.fans.current_page;
                        that.groups=res.data.groups;
                        $('#group-ul').find("li[data-group_id=" + group_id + "] ").css('background','#f4f5f9');
                        $('#group-ul').find("li[data-group_id=" + group_id + "] ").siblings().css('background','#ffffff');
                        that.getAll();
                    }
                }
            });


        },

        switchShow:function (group_id) {

            if(group_id===0){
                return true;
            }else{
                return false;
            }
        },

        searchFans:function () {
            this.InitializationData();
            var that=this;
            $.ajax({
                type:"get",
                url:fansApi,
                data:{'groupId':that.groupId,'pageSize':that.pageSize,'nickname':that.nickname},
                success:function(res){
                    if(res.status){
                        that.fans=res.data.fans.data;
                        that.total=res.data.fans.total;
                        that.pageSize=parseInt(res.data.fans.per_page);
                        that.currentPage=res.data.fans.current_page;
                        that.groups=res.data.groups;
                        that.getAll();
                    }
                }
            });

        },


        searchFansAll:function () {
            this.InitializationData();
            var that=this;
            $.ajax({
                type:"get",
                url:fansApi,
                data:{'groupId':'all','pageSize':that.pageSize,'nickname':that.nickname},
                success:function(res){
                    if(res.status){
                        that.fans=res.data.fans.data;
                        that.total=res.data.fans.total;
                        that.pageSize=parseInt(res.data.fans.per_page);
                        that.currentPage=res.data.fans.current_page;
                        that.groups=res.data.groups;
                        that.getAll();
                        that.groupId='all';
                        $('#group-ul li').removeClass('Switch')
                        $('#group-ul').find("li").css('background','#ffffff');
                    }
                }
            });

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
                        that.dynamicTags=res.data.fans_group;

                    }
                }
            });
        },

        setGroup:function () {
            if(this.checked.length<=0){
                toastr.error('请选择粉丝');
                return false;
            }
            $('#SetGroup').modal('show');
        },

        submitSetGroupInfo:function () {
            if(this.select_group==-1){
                toastr.error('请选择用户组');
                return false;
            }
            $.ajax({
                type:"post",
                url:moveUsers,
                data:{'groupid':this.select_group,'_token':this._token,'openids':this.checked},
                success:function(res){
                    if(res.status){
                        toastr.success('设置成功');
                        window.location.reload();
                    }
                }
            });

        },

        handleClose:function(tag,openid, index) {

            this.dynamicTags.splice(index, 1);
            // console.log(tag);
            // console.log(openid);
            $.ajax({
                type:"post",
                url:moveTag,
                data:{'tag':tag,'_token':this._token,'open_id':openid},
                success:function(res){
                    console.log(res);
                }
            });


        },

        handleInputConfirm:function() {
            var inputValue = this.inputValue;
            if (inputValue) {
                this.dynamicTags.push(inputValue);
            }
            this.inputVisible = false;
            this.inputValue = '';
        },

        getAll:function () {
            var all=[];
            var dataFans=this.fans;
            if(dataFans.length>0){
                for(var i=0;i<dataFans.length;i++){
                    all[i]=dataFans[i].openid;
                }
            }
            this.checkedAll=all;
        },

        Location:function () {
            this.fans=[];
            this.getData();
        },

        checkedAllBox:function () {
            if(this.checkedAll_status){
                this.checked=this.checkedAll;
            }else{
                this.checked=[];
            }
        },

        InitializationData:function(){
            this.checked=[],
                    this.checkedAll=[],
                    this.checkedAll_status=false;
        },

        start:function(){
            var _token=$('meta[name="_token"]').attr('content');
            this._token=_token;
            this.getData();
        }
    },
    mounted(){
        this.start();
    }
})