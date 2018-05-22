
    <div id="app-tu">
        <div class="ibox float-e-margins">
            <div class="ibox-content" style="display: block;">
                <div class="row">
                    <div class="panel-body">
                        <div class="hint" style="margin-left:30px;" >
                            <p>
                                <i class="fa fa-info-circle"></i>注意<br>
                                1.图文封面图片格式支持jpeg,jpg,png;不支持动态GIF图片<br>
                                2.图文内容上传的图片会自动同步到微信服务器，请勿使用过大的图片；<br>
                                3.修改图文，微信服务器有延迟稍等片刻调试查看
                            </p>
                        </div>
                        <div class="tab-content" style="margin-left:50px;display: none" >
                            <!-- 表单 -->
                            <div id="form" class="form-horizontal form-center">
                                <div class="material_form ">
                                    <div class="preview_area" style="width:300px;">
                                        <form data-index='0' class="appmsg_item edit_item editing" data-form="0" >
                                            <p class="time">{#time#}</p>
                                            <div class="main_img" style="width:265px;">
                                                <img id="fm-0" :src="form[0].img?form[0].img:'{{env("APP_URL").'/assets/wechat-backend/img/no_cover_pic.png'}}'" data-coverid="0"/>
                                                <h6 class="title">{#form[0].title#}</h6>
                                            </div>
                                            <p class="intro"></p>
                                            <div class="hover_area" style="width: 298px;"><a href="javascript:;" @Click="editTop()">编辑</a></div>
                                        </form>


                                        <div   v-if="add.length"   v-for="(item,index) in add" class="appmsg_sub_item edit_item" style="height:110px;" data-form="item">

                                            <div >
                                                <p class="title" >{#form[item].title#}</p>
                                                <div class="main_img">
                                                    <img :id="'list'+item"   :src="list_img[item]?list_img[item]:'{{env("APP_URL").'/assets/wechat-backend/img/no_cover_pic.png'}}'" data-coverid="0">
                                                </div>
                                                <div class="hover_area"><a href="javascript:;" @click="editMag(form[item].index,index)">编辑</a>
                                                    {{--<a href="javascript:;"   @click="Delete(form[item].index,form[item].id)" :data-id="form[item].id">删除</a>--}}
                                                </div>
                                            </div>

                                        </div>

                                        {{--<div  v-if="del.length"   v-for="item in del" class="appmsg_sub_item edit_item" style="height:110px;">--}}

                                        {{--<div >--}}
                                        {{--<p class="title">{#item#}</p>--}}
                                        {{--<div class="main_img">--}}
                                        {{--<img src="{{env("APP_URL").'/assets/wechat-backend/img/no_cover_pic.png'}}" data-coverid="0">--}}
                                        {{--</div>--}}
                                        {{--<div class="hover_area"><a href="javascript:;" @click="editMag(index)">编辑</a>--}}
                                        {{--<a href="javascript:;"   @click="delMag(item)">删除</a>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}

                                        {{--</div>--}}




                                        <div class="appmsg_edit_action" style="display:none">
                                            <a href="javascript:;" @Click="addMsg" class="btm btm-info">添加</a>
                                        </div>

                                    </div>


                                    <div class="edit_area" style="width:600px;display: none">
                                        <em class="area_arrow" style='background: url("{{env("APP_URL").'/assets/wechat-backend/img/area_arrow.png'}}") no-repeat;'></em>
                                        <ul class="tab-pane in appmsg_edit_group">

                                            {{--<button type="button" class="btn btn-primary" name="keep" @click=" keepBtn()"  >--}}
                                            {{--保存--}}
                                            {{--</button>--}}


                                            <li class="form-item cf form-group">
                                                <label class="col-sm-2 control-label item-label">*标题：</label>
                                                <div class="col-sm-9 controls" style="margin-left: 10px;">
                                                    <input type="text" class="form-control"  @change="changeMag()"   name="title" v-model="show_data.title" placeholder=""/>
                                                </div>
                                            </li>

                                            <input type="hidden" name="index" v-model="index" id="">
                                            <input type="hidden" name="getImage" @click="getImage()">

                                            <li class="form-item cf form-group">
                                                <label class="col-sm-2 control-label item-label">作者：</label>
                                                <div class="col-sm-9 controls" style="margin-left: 10px;">
                                                    <input type="text" class="form-control " name="author"  v-model="show_data.author"   placeholder=""/>
                                                </div>




                                            <li class="form-item cf form-group">
                                                <label class="col-sm-2 control-label item-label">外链：</label>
                                                <div class="col-sm-9 controls" style="margin-left: 10px;">
                                                    <input type="text" class="form-control" name="link"   v-model="show_data.content_url"  placeholder="即点击“阅读原文”后的URL（例子：http://baidu.com）"/>
                                                </div>
                                                <input type="hidden" name="cover" v-model="show_data.cover_media_id"/>
                                            </li>

                                            <li class="form-item cf form-group">
                                                <label class="col-sm-2 control-label item-label">*封面:</label>
                                                <span class="need_flag" style="color: #cccccc;">&nbsp;&nbsp;&nbsp;*</span><span class="check-tips" style="color: #cccccc;">推荐尺寸图片<span class="picSize" style="color: #cccccc;"
                                                    >900X500</span></span>
                                                <div class="controls uploadrow2 col-sm-9" data-max="1" title="" rel="p_cover" style="margin-left: 14px;">

                                                    <div class="upload-img-box" rel="img" style="display:block">
                                                        <div class="upload-pre-item2"><img  class="fm" width="100" height="100" :src="show_data.img?show_data.img:'{{env("APP_URL").'/assets/wechat-backend/img/no_cover_pic_s.png'}}'">
                                                            <em class="edit_img_icon">&nbsp;</em>
                                                        </div>
                                                    </div>
                                            </li>


                                            <li  class="form-item cf form-group" style="position: relative">
                                                <div class="col-sm-9 controls" style="position: absolute;top: -50px;left:250px;">
                                                    <input type="button"  data-toggle="modal" @click="getDataImage" class="btn btn-primary" value="图片素材" style="margin-left:75px;">
                                                    <div id="upload-img"  class="pull-left col-sm-4">
                                                        <span id="imguping"  data-style="expand-right"  class="but ladda-button " type="submit" disabled ><span id="scspan">上传封面</span></span>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="form-item cf form-group">
                                                <label class="item-label col-sm-2 control-label"></label>
                                                <div class="contros col-sm-9">
                                                    <i class="fa switch fa-toggle-on"   @click="show_cover(1)"    v-show="form[index].show_cover"  title="切换状态"  value="true"  style="font-size: 25px;"></i>
                                                    <i class="fa switch fa-toggle-off"  @click="show_cover(0)"    v-show="!form[index].show_cover?true:false"  title="切换状态" value="false"  style="font-size: 25px;"></i>
                                                    <span style="color: #CCCCCC">  &nbsp;&nbsp;封面是否在正文中显示</span>
                                                </div>
                                            </li>


                                            <li class="form-item cf form-group">
                                                <label class="item-label col-sm-2 control-label">摘要:</label>
                                                <span class="check-tips">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                <div class="contros col-sm-9">
                                                    <textarea  v-model="show_data.description"  class="form-control" name="p_intro" rows="6"  placeholder="仅有单图文消息才有摘要，多图文此处留空"></textarea>
                                                </div>
                                            </li>


                                            <li class="form-item cf form-group">
                                                <label class="item-label col-sm-2 control-label">*正文:</label>
                                                <div class="contros col-sm-9">
                                                    <span class="check-tips">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                    <script id="p_content" name="p_content" type="text/plain"></script>
                                                </div>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden"  id="getInfo"  value="" @click="getArticle()">
                        <div class="col-md-7 col-md-offset-5">
                            <button type="submit" class="btn btn-success submit-btn " id="release" @click="Release">发布</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- 图片模态框（Modal） -->
        <div class="modal fade" id="imgModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="fa fa-times"></i>
                        </button>
                        <p class="modal-title">
                            选择图片素材
                        </p>
                    </div>
                    <div class="modal-body">
                        <img src="{{env("APP_URL").'/assets/wechat-backend/img/loading.gif'}}" alt="" id="loading" style="margin-left: 400px;">
                        <div class="no-material">
                            <img src="" alt="">
                            <p>您的图片素材库为空，<a href="#">请先添加素材</a></p>
                        </div>
                        <div class="have-material clearfix img-list">
                            <div class="col-lg-3 img-warp" v-show="data.length"  v-for="(item,index) in data">
                                <div class="img-box" @click="Selected($event,index)" :data-id=item.id  :data-type=item.type :data-url=item.source_url :data-media_id=item.media_id >
                                <img :src=item.source_url>
                            </div>
                        </div>
                    </div>
                    {{--分页--}}
                    <div class="block" style="width:300px; margin: 0 auto;padding: 10px 0;" v-if="data.length">
                        <span class="demonstration"></span>
                        <el-pagination
                        @current-change="handleCurrentChange"
                        layout="prev, pager, next"
                        :total="total"
                        :current-page="currentPage"
                        :page-size="pageSize"
                        >
                        </el-pagination>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                    </button>
                    <button type="button" class="btn btn-primary confirm-img" @click="Submit()">
                    确定
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>


    </div>

    <script>
        var materialApi="{{route('admin.wechat.material.api')}}";
        var storeArticle="{{route('admin.wechat.material.store_article')}}";
        var locationUrl="{{route('admin.wechat.material.index',['type'=>4])}}";
        var GetArticle="{{route('admin.wechat.material.edit.article.api',$id)}}";

        var UpdateArticle="{{route('admin.wechat.material.update.article')}}";

        var materialDelete="{{route('admin.wechat.material.article.delete','#')}}";


        var formIndex=0;
        var formIndexOld=0;

        var aid="{{$id}}";



        var cur=0;
        var UEObj;
    </script>
    @include('vendor.ueditor.assets')

            <!-- 先引入 Vue -->
    {{--@include('wechat-backend::materials.article.image_script')--}}
    <script>
        var img='';
        var mid='';
    </script>
    <script>
        function in_array(stringToSearch, arrayToSearch) {
            for (s = 0; s < arrayToSearch.length; s++) {
                thisEntry = arrayToSearch[s].toString();
                if (thisEntry == stringToSearch) {
                    return true;
                }
            }
            return false;
        }
        //  图文上传
        $(document).ready(function () {
            // 初始化Web Uploader
            var uploader = WebUploader.create({
                auto: true,
                swf: '{{url('libs/webuploader-0.1.5/Uploader.swf')}}',
                server: '{{route('admin.wechat.upload',['_token'=>csrf_token()])}}',
                pick: '#upload-img',
                fileVal: 'file',
                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,bmp,png',
                    mimeTypes: 'image/*'
                }
            })

            // 当有文件被添加进队列的时候
            uploader.on( 'fileQueued', function( file ) {
                $('#scspan').text('');
                $('#imguping').ladda().ladda('start');
            })

            //上传成功
            uploader.on( 'uploadSuccess', function( file,data) {
                $('#imguping').ladda().ladda('stop');
                $('#scspan').text('上传封面');
                mid=data.media_id;
                img=data.source_url;
                $('input[name=getImage]').trigger("click");

            });
        })
    </script>

    <script>
        $(function(){
            var ue = UE.getEditor('p_content', {
                initialFrameHeight: 550,
                allowDivTransToP:false
            });
            UEObj=ue;
            setTimeout("$('.edit_area').show();$('#getInfo').trigger('click');",2000);
            $('.tab-content').show();

        });
    </script>


    <script>
        new Vue({
            delimiters: ['{#', '#}'],
            el:'#app-tu',
            data:{
                max:8,
                time:'',
                cid:[],
                _token:'',
                list_img:{
                },
                data:[],
                img:[],
                selected:[],
                pageSize:15,
                total:1,
                currentPage:1,

                length:0,

                index:0,

                oldIndex:0,

                top:[0,200,310,420,530,640,750,860,970],

                del:[1,2,3,4,5,6,7],

                add:[],

                media_id:{},


                msg_sub_item_data:[
                    {index:0,title:"",image:''},
                    {index:1,title:"",image:''},
                    {index:2,title:"",image:''},
                    {index:3,title:"",image:''},
                    {index:4,title:"",image:''},
                    {index:5,title:"",image:''},
                    {index:6,title:"",image:''},
                    {index:7,title:"",image:''},
                ],


                form:[
                    {index:0,title:"这是标题",author:'',description:'',content:'',cover_media_id:'',content_url:'',img:'',show_cover:0,id:''},
                    {index:1,title:"",author:'',description:'',content:'',cover_media_id:'',content_url:'',img:'',show_cover:0,id:''},
                    {index:2,title:"",author:'',description:'',content:'',cover_media_id:'',content_url:'',img:'',show_cover:0,id:''},
                    {index:3,title:"",author:'',description:'',content:'',cover_media_id:'',content_url:'',img:'',show_cover:0,id:''},
                    {index:4,title:"",author:'',description:'',content:'',cover_media_id:'',content_url:'',img:'',show_cover:0,id:''},
                    {index:5,title:"",author:'',description:'',content:'',cover_media_id:'',content_url:'',img:'',show_cover:0,id:''},
                    {index:6,title:"",author:'',description:'',content:'',cover_media_id:'',content_url:'',img:'',show_cover:0,id:''},
                    {index:7,title:"",author:'',description:'',content:'',cover_media_id:'',content_url:'',img:'',show_cover:0,id:''},
                ],

                show_data:{
                    id:0,title:"这是标题",author:'',description:'',content:'',cover_media_id:'',content_url:'',img:''
                }


            },

            methods:{
                editTop:function () {
                    $('.picSize').text('900X500');
                    var oldIndex=this.index;
                    this.keep();

                    this.oldIndex=oldIndex;
                    this.index=0;
                    $('.edit_area').css("margin-top",0);

                    var data=this.form[0]
                    this.show_data= {
                        id: 0,
                        title: data.title,
                        author: data.author,
                        description: data.description,
                        content: data.content,
                        cover_media_id: data.cover_media_id,
                        content_url: data.content_url,
                        img: data.img
                    }

                    this.show_data.content=UEObj.setContent(data.content);

                },



                // 添加
                addMsg:function(){

                    var curCount = $('.edit_item').length;
                    if(curCount>=this.max){
                        $('.appmsg_edit_action').hide();
                        toastr.error('最多只可以增加'+this.max+'条图文信息');
                        return false;
                    }

                    this.add.push(this.del[0]);

                    var del=this.del[0];

                    this.removeByValue(this.del,del);


                },


                editMag:function (p,key) {

                    $('.picSize').text('200X200');
                    var oldIndex=this.index;
                    this.oldIndex=oldIndex;
                    this.index=p;
                    $('.edit_area').css("margin-top",this.top[key+1]);
                    var data=this.form[p];
                    var old_data=this.form[oldIndex];

                    //保存数据
                    old_data.title=this.show_data.title;
                    old_data.author=this.show_data.author;
                    old_data.description=this.show_data.description;
                    old_data.cover_media_id=this.show_data.cover_media_id;
                    old_data.content_url=this.show_data.content_url;
                    old_data.img=this.show_data.img;
                    old_data.content=UEObj.getContent();


                    this.show_data={
                        id:0,title:data.title,author:data.author,description:data.description,content:data.content,cover_media_id:data.cover_media_id,content_url:data.content_url,img:data.img,show_cover:0,
                    }


//                    编辑器
                    UEObj.setContent(this.show_data.content);


                },


                changeMag:function () {

                    var data=this.form[this.index];

                    data.title=this.show_data.title;

                },


                removeByValue:function (arr, val) {
                    for(var i=0; i<arr.length; i++) {
                        if(arr[i] == val) {
                            arr.splice(i, 1);
                            break;
                        }
                    }
                },

                delMag:function(p){
                    var add=this.add;
                    this.removeByValue(add,p)
                    if(!in_array(p,this.del)){
                        this.del.push(p)
                    }else{
                        this.removeByValue(this.del,p)
                    }

                    $('.edit_area').css("margin-top",this.top[0]);
                    this.index=0;
                    var data=this.form[0];
                    this.show_data={
                        id:0,title:data.title,author:data.author,description:data.description,content:data.content,cover_media_id:data.cover_media_id,content_url:data.content_url,img:data.img
                    }

                    UEObj.setContent(data.content);
                    //删除内容
                    var data=this.form[p];
                    //保存数据
                    data.title='';
                    data.author='';
                    data.description='';
                    data.cover_media_id='';
                    data.content_url='';
                    data.img='';
                    data.content='';
                },

                showDate:function () {
                    var data=this.show_data


                },

//                上传成功
                getImage:function () {
                    var data=this.form[this.index];
                    this.show_data.img=img;
                    this.show_data.cover_media_id=mid;
                    data.img=img;
                    data.cover_media_id=mid;
                    this.list_img[this.index]=img;
                    this.keep();

                },


//                保存
                keep:function () {
                    var data=this.form[this.index];
                    //保存数据
                    data.title=this.show_data.title;
                    data.author=this.show_data.author;
                    data.description=this.show_data.description;
                    data.cover_media_id=this.show_data.cover_media_id;
                    data.content_url=this.show_data.content_url;
                    data.img=this.show_data.img;
                    data.content=UEObj.getContent();
                },


                keepBtn:function () {
                    var data=this.form[this.index];
                    //保存数据
                    data.title=this.show_data.title;
                    data.author=this.show_data.author;
                    data.description=this.show_data.description;
                    data.cover_media_id=this.show_data.cover_media_id;
                    data.content_url=this.show_data.content_url;
                    data.img=this.show_data.img;
                    data.content=UEObj.getContent();
                    toastr.success('保存成功');
                },




                // 图片素材

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
                        var data=this.form[this.index];

                        this.show_data.img=url;
                        this.show_data.cover_media_id=media_id;
                        data.img=url;
                        data.cover_media_id=media_id;
                        this.list_img[this.index]=url;
                        this.keep();

                        $('#imgModal').modal('hide');
                    }else{
                        toastr.error('请选择一个素材');
                    }

                },
                getDataImage:function () {
                    $("#imgModal").modal('show');
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
                                console.log(that.data);
                            }
                        }
                    });
                },

                Delete:function (p,id) {
                    var that=this;
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

                        var url = decodeURIComponent(materialDelete).replace('#', id);

                        $.post(url, {
                            id: id,
                            '_token':this._token
                        }, function (ret) {

                            if(ret.status){
//                                var li = $(this).parents('li');
//                                $('.picture_list').find("li[data-id=" + id + "]").remove();
                                done();
                                that.delMag(p)
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

                // 发布
                Release:function(){
                    this.keep();
                    if($('#release').hasClass('disabled')) return false;

                    var add=this.add;
                    var data=[];
                    if(add.length==0){
                        if(this.form[0].title==""){
                            toastr.error('主图文缺少标题');
                            return false;
                        }else if(this.form[0].cover_media_id==""){
                            toastr.error('主图文缺少封面');
                            return false;
                        }else if(this.form[0].content==""){
                            toastr.error('主图文缺少内容');
                        }

                        data[0]=this.form[0];
                    }

                    if(add.length>0){

                        if(this.form[0].title==""){
                            toastr.error('主图文缺少标题');
                            return false;
                        }else if(this.form[0].cover_media_id==""){
                            toastr.error('主图文缺少封面');
                            return false;
                        }else if(this.form[0].content==""){
                            toastr.error('主图文缺少内容');
                            return false;
                        }

                        data[0]=this.form[0];

                        for(var i=0;i<add.length;i++){
                            if(this.form[add[i]].title==""){
                                toastr.error('子图文缺少标题');
                                return false;
                            }else if(this.form[add[i]].cover_media_id==""){
                                toastr.error('子图文缺少封面');
                                return false;
                            }else if(this.form[add[i]].content==""){
                                toastr.error('子图文缺少内容');
                                return false;
                            }
                            data[add[i]]=this.form[add[i]];
                        }

                    }


                    $('#release').addClass('disabled');

                    var newData={
                            'data':data,
                            'id':aid,
                            'cid':this.cid,
                            '_token':this._token,
                        }

                    $.ajax({
                        type:"post",
                        url:UpdateArticle,
                        data:newData,
                        success:function(res){
                            $('#release').removeClass('disabled');

                            if(res.status){
                                swal({
                                    title: "发布成功",
                                    text: "",
                                    type: "success"
                                }, function () {
                                    location = locationUrl;
                                });
                                $('input[tabindex=3]').hide();
                            }
                        }
                    });

                },


                getArticle:function () {
                    var that = this;
                    that.data=[];
                    $('.loading').show();
                    $.ajax({
                        type:"get",
                        url:GetArticle,
                        success:function(res){
                            if(res.status){
                                var newData=res.data;
                                    that.time=newData.created_at;
                                    that.form[0].author=newData.author?newData.author:'';
                                    that.form[0].description=newData.description?newData.description:'';
                                    that.form[0].content=newData.content?newData.content:'';
                                    that.form[0].cover_media_id=newData.cover_media_id?newData.cover_media_id:'';
                                    that.form[0].img=newData.cover_url?newData.cover_url:'';
                                    that.form[0].title=newData.title?newData.title:'';
                                    that.form[0].content_url=newData.content_url?newData.content_url:'';
                                    that.form[0].show_cover=newData.show_cover_pic?newData.show_cover_pic:0;

                                     that.cid[0]=newData.id?newData.id:"";

                                    var data=that.form[0];
                                     that.show_data={
                                        id: 0,
                                        title: data.title,
                                        author: data.author,
                                        description: data.description,
                                        content: data.content,
                                        cover_media_id: data.cover_media_id,
                                        content_url: data.content_url,
                                        img: data.img
                                    }
                                    UEObj.setContent(data.content);

                                    var childrens=newData.childrens;
                                    that.max=childrens.length+1;

                                    if(childrens.length>0){
                                        for(var i=0;i<childrens.length;i++){
                                            that.form[i+1].author=childrens[i].author?childrens[i].author:'';
                                            that.form[i+1].description=childrens[i].description?childrens[i].description:'';
                                            that.form[i+1].content=childrens[i].content?childrens[i].content:'';
                                            that.form[i+1].cover_media_id=childrens[i].cover_media_id?childrens[i].cover_media_id:'';
                                            that.form[i+1].img=childrens[i].cover_url?childrens[i].cover_url:'';
                                            that.form[i+1].title=childrens[i].title?childrens[i].title:'';
                                            that.form[i+1].content_url=childrens[i].content_url?childrens[i].content_url:'';
                                            that.form[i+1].show_cover=childrens[i].show_cover_pic?childrens[i].show_cover_pic:0;
                                            that.form[i+1].id=childrens[i].id?childrens[i].id:0;

                                            that.addMsg();
                                            that.list_img[i+1]=that.form[i+1].img
                                            that.cid[i+1]=childrens[i].id?childrens[i].id:'';


                                        }
                                    }



                            }
                        }
                    });

                },


                show_cover:function (status) {
                    var show=status?0:1;
                    this.form[this.index].show_cover=show;
                },


                status:function(){
                    var _token=window._token;
                    this._token=_token;

                }
            },
            mounted(){
                $('.appmsg_edit_action').hide();
//                this.getData();
                this.status();

            }

        })
    </script>