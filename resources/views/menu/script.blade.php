<script>
    new Vue({
        delimiters: ['{#', '#}'],
        el:'#app-menu',
        data:{},
        methods:{

            Delete:function (p,id) {
//                    var url = decodeURIComponent(deleteApi).replace('#', id);
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

                            $.post(p, {_token:_token
                            }, function (ret) {
                                console.log(ret);
                                if(ret.status){
                                    done();
                                    instance.confirmButtonLoading = false;
                                    toastr.success(ret.message);
                                    $('#second-menu-'+id).remove()
                                }else{
                                    toastr.error(ret.message);
                                }

                            });

                            done();
                            instance.confirmButtonLoading = false;

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


        },
        mounted(){

        }

    })
</script>