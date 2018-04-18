
<input name="selected-id" type="hidden" value="" v-model="selected">
<input name="selected-img" type="hidden" value="" v-model="data_img">
<input name="selected-title" type="hidden" value="" v-model="data_title">

<div class="col-sm-9 controls">
    <input type="button"  data-toggle="modal" @click="videoModal()" class="btn btn-info material_btn" value="视频素材" >
</div>

<div class="col-sm-9" style="margin-top:15px;" id="showVideo-box" v-show="type=='video'&&data_img&&data_title&&selected?true:false">
    <div  class="data-show-video data-show"  style="display:none;position:relative;border: 1px dashed #CCCCCC;width:300px;">
        <i class="fa fa-times-circle" id="delVideo" style="font-size: 20px;position: absolute;left:280px;" @click="delData()"></i>
        <div class="video_item" style="margin-left: 30px;">
            <h4>{#data_title#}</h4>
            <div class="video_area1" style="width:240px;">
                <video :src=data_img controls="controls">您的浏览器不支持 video 标签。</video>
            </div>
        </div>

    </div>
</div>


<!-- 图文模态框（Modal） -->
<div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="fa fa-times"  @click="ModalDel()"></i>
                </button>
                <p class="modal-title">
                    选择视频素材
                </p>
            </div>
            <div class="modal-body" style="margin-top: 20px;">
                <div class="have-material clearfix">

                    <div class="col-sm-4">
                        <div class="input-group date form_datetime form_datetime_stime">
                                        <span class="input-group-addon" style="cursor: pointer">
                                            <i class="fa fa-calendar"></i>&nbsp;&nbsp;最后更新时间</span>
                            <input type="text" style="width: 151px;"  class="form-control inline" name="stime"
                                   placeholder="开始 " readonly  >
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group date form_datetime form_datetime_etime">
                                        <span class="input-group-addon" style="cursor: pointer">
                                            <i class="fa fa-calendar"></i></span>
                            <input type="text" class="form-control" name="etime"
                                   placeholder="截止" readonly >
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                    </div>


                    <div class="seek" style="margin-right: 50px;">
                        <div class="row">
                            <div class="input-group">
                                <input type="text" class="form-control" :value="keyword"   placeholder="请输入搜索标题" v-model="keyword">
                                <span class="input-group-btn" @click="Search()">
                                <button class="btn btn-default" type="button" style="margin-right: 20px; height: 34px;">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                            <div class="input-group" style="margin-top: -34px;margin-left:220px;">
                                <button class="btn btn-default delSearch"   type="button" @click="delSearch()">
                                <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="loading" style="margin-left:400px;margin-top:120px;height:280px;">
                    <img src="{{env("APP_URL").'/assets/wechat-backend/img/loading.gif'}}" alt="">
                </div>

                <div class="no-material">
                    <img src="" alt="">
                    <p>您的视频素材库为空，<a href="#">请先添加素材</a></p>
                </div>
                <div class="have-material clearfix img-list">
                    <div class="col-lg-4 img-text" v-if="data.length"  v-for="(item,index) in data" style="border: 0" >
                        <div  class="img-box img-box-video"   :class="{'img-bg':item.id==real.selected?true:false}"  @click="videoSelected($event,index,item.id)"  :data-id=item.id :data-title=item.title  :data-type=item.type :data-url=item.source_url :data-media_id=item.media_id >
                        <div class="video_item" style="width:200px;margin-left: 30px;">
                            <h4>{#item.title#}</h4>
                            <p class="ctime colorless">{#item.created_at#}</p>
                            <div class="video_area1" style="width:200px;">
                                <video :src=item.source_url controls="controls">您的浏览器不支持 video 标签。</video>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--分页--}}
            <div class="block"  style="width:300px; margin-left:20px;padding:20px 0;" v-if="data.length">
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
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" @click="ModalDel()">关闭
                </button>
                <button type="button" class="btn btn-primary confirm-img-text" @click="videoSubmit()">
                确定
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
