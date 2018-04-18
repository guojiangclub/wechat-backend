<script>
    new Vue({
        delimiters: ['{#', '#}'],
        el:'#app',
        data:{
            form:{

            },
            data:[],
            img:[],
            selected:[],
            pageSize:1,
            total:1,
            currentPage:1
        },
        methods:{
            handleCurrentChange:function(val) {
                this.currentPage = val;
                $('#loading').show();
                var that = this;
                that.data=[];
                $.ajax({
                    type:"get",
                    url:materialApi,
                    data:{'type':'image','pageSize':that.pageSize,'page':val},
                    success:function(res){
                        if(res.status){
                            $('#loading').hide();
                            that.data=res.data.data;
                            that.total=res.data.total;
                            that.pageSize=parseInt(res.data.per_page);
                            that.currentPage=res.data.current_page;
//                            console.log(res.data);
                        }
                    }
                });

            },

            Selected:function (event,index) {
                $('.img-box').removeClass('img-bg');
                $('.img-box').eq(index).toggleClass('img-bg');
            },

            Submit:function () {
                if($('.img-bg').length>0){
                    var type = $('.img-bg').data('type');
                    var media_id = $('.img-bg').data('media_id');
                    var url = $('.img-bg').data('url');
                    $('.editing img').attr('src',url);
                    $('.editing input[name="cover_id"]').val(media_id);
                    $('.editing input[name="cover_url"]').val(url);
                    $('.fm').attr('src',url);
                    $('#imgModal').modal('hide');
                }else{
                    toastr.error('请选择一个素材');
                }

            },

            content:function () {
                console.log(1);
            },

            getData:function () {
                $('#loading').show();
                var that = this;
                that.data=[];
                $.ajax({
                    type:"get",
                    url:materialApi,
                    data:{'type':'image','pageSize':that.pageSize},
                    success:function(res){
                        if(res.status){
                            $('#loading').hide();
                            that.data=res.data.data;
                            that.total=res.data.total;
                            that.pageSize=parseInt(res.data.per_page);
                            that.currentPage=res.data.current_page;
                        }

                    }
                });
            },



            one:function(){
                console.log('ok');
            }
        },
        mounted(){
            this.one();
        }

    })
</script>




