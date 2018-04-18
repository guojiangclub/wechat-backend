<script>
    new Vue({
        delimiters: ['{#', '#}'],
        el:'#app',
        data:{
            _token:'',
            status:'create',
            m_type:1,
            selected:'',
            data:[],
            type:'image',
            keyword:'',
            pageSize:12,
            total:1,
            currentPage:1,
            key:'',
            content:'',

            data_text:'',
            data_img:'',
            data_title:'',
            data_time:'',

            real:{
                selected:'',
                data_img:'',
                data_title:'',
                data_time:'',
                data_text:''
            },
            action:1,
            radio_type:1,
            state:true,

            stime:'',
            etime:'',


        },
        methods:{
// ----------------------------------------时间筛选
            decodeURI:function(str){
                return decodeURIComponent(str)
            },



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

// -----------------------------关闭模态框-----------------------------
            ModalDel:function () {
                var that=this;
                that.real.selected='';
                that.real.data_img='';
                that.real.data_title='';
                that.real.data_time='';
                that.keyword='';
                that.stime='';
                that.etime='';
            },
            // 删除数据
            delData:function () {
                var that=this;
                that.real.selected='';
                that.real.data_img='';
                that.real.data_title='';
                that.keyword='';
                that.selected='';
                that.data_text='';
                that.data_img='';
                that.data_title='';
                that.data_time='';
            },

            // -----------------------------文本模态框-----------------------------
            textModal:function () {
                $('#textModal').modal('show');
                this.type='text';
                this.getData();
            },
            Submit:function () {
                var that=this;
                if(that.real.selected!==''){
                    that.selected=that.real.selected;
                    var text=$('#'+that.real.selected+"text").text();
                    that.data_text=text;
                    if(that.data_text!=="")$('#textModal').modal('hide');
                }else{
                    toastr.error('请选择一个素材');
                }
            },

            //-------------------------------图片模态框----------------------------
            imageModal:function () {
                $('#imageModal').modal('show');
                if(this.type!=="image"){
                    this.selected='';
                    this.data_text='';
                    this.data_title='';
                    this.data_img='';
                    this.real.selected='';
                    this.real.data_text='';
                    this.real.data_title='';
                    this.real.data_img='';
                }
                this.type='image';
                this.getData();
            },
            imageSelected:function (event,index,id) {
                var img=$('.img-box-image').eq(index).data('url');
                var that=this;
                if(that.real.selected==""){
                    that.real.selected=id;
                    that.real.data_img=img;
                }else{
                    that.real.selected='';
                    that.real.data_img='';
                }
            },

            imageSubmit:function () {
                var that=this;
                if(that.real.selected!==''||that.real.data_img!==""){
                    that.selected=that.real.selected;
                    that.data_img=that.real.data_img;
                    $('#showImg-box').show();
                    $('#imageModal').modal('hide');
                }else{
                    toastr.error('请选择一个素材');
                }
            },

            //-------------------------------图文模态框----------------------------
            articleModal:function () {
                $('#articleModal').modal('show');
                if(this.type!=="article"){
                    this.selected='';
                    this.data_text='';
                    this.data_title='';
                    this.data_img='';
                    this.data_time='';
                    this.real.selected='';
                    this.real.data_text='';
                    this.real.data_title='';
                    this.real.data_img='';
                    this.real.data_time='';
                }
                this.type='article';
                this.getData();
            },

            articleSelected:function (event,index,id) {
                var img=$('.img-box-article').eq(index).data('url');
                var title=$('.img-box-article').eq(index).data('title');
                var time=$('.img-box-article').eq(index).data('time');
                var that=this;
                if(that.real.selected==""){
                    that.real.selected=id;
                    that.real.data_img=img;
                    that.real.data_title=title;
                    that.real.data_time=time;
                }else{
                    that.real.selected='';
                    that.real.data_img='';
                    that.real.data_title='';
                    that.real.data_time='';
                }
            },
            articleSubmit:function () {
                var that=this;
                if(that.real.selected!==''||that.real.data_img!==""||that.real.data_title!==""||that.real.data_time!==""){
                    that.selected=that.real.selected;
                    that.data_img=that.real.data_img;
                    that.data_title=that.real.data_title;
                    that.data_time=that.real.data_time;
                    $('#showArticle-box').show();
                    $('#articleModal').modal('hide');
                }else{
                    toastr.error('请选择一个素材');
                }
            },


            //-------------------------------视频模态框----------------------------
            videoModal:function () {
                $('#videoModal').modal('show');
                if(this.type!=="video"){
                    this.selected='';
                    this.data_text='';
                    this.data_title='';
                    this.data_img='';
                    this.real.selected='';
                    this.real.data_text='';
                    this.real.data_title='';
                    this.real.data_img='';
                }
                this.type='video';
                this.getData();
            },

            videoSelected:function (event,index,id) {
                var img=$('.img-box-video').eq(index).data('url');
                var title=$('.img-box-video').eq(index).data('title');
                var that=this;
                if(that.real.selected==""){
                    that.real.selected=id;
                    that.real.data_img=img;
                    that.real.data_title=title;
                }else{
                    that.real.selected='';
                    that.real.data_img='';
                    that.real.data_title='';
                }
            },
            videoSubmit:function () {
                var that=this;
                if(that.real.selected!==''||that.real.data_img!==""||that.real.data_title!==""){
                    that.selected=that.real.selected;
                    that.data_img=that.real.data_img;
                    that.data_title=that.real.data_title;
                    $('#showVideo-box').show();
                    $('#videoModal').modal('hide');
                }else{
                    toastr.error('请选择一个素材');
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

           mateChange:function () {
                if(this.action==1){
                    $('#custom').show();
                    $('#instationMaterial').hide();
                }else if(this.action==2){
                    $('#custom').hide();
                    $('#instationMaterial').show();
                }
            },

            start:function(){
                var _token=$('meta[name="_token"]').attr('content');
                this._token=_token;
                if(action==2){
                    this.action=2;
                    $('#custom').hide();
                    $('#instationMaterial').show();
                }
                this.data_img=data_img;
                this.data_time=data_time;
                this.data_title=data_title;
                this.type=data_type;
                this.selected=data_selected;

                this.real.selected=data_selected;
                this.real.data_img=data_img;
                this.real.data_time=data_time;
                this.real.data_title=data_title;

//                this.getData();

            }
        },


        mounted(){
            $('.data-show').show();
            this.start();
        }

    })
</script>




