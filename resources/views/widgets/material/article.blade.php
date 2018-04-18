



<input name="selected-id" type="hidden" value="" v-model="selected">
<input name="selected-img" type="hidden" value="" v-model="data_img">
<input name="selected-title" type="hidden" value="" v-model="data_title">

<div class="col-sm-9 controls">
    <input type="button"  data-toggle="modal" @click="articleModal()" class="btn btn-info material_btn" value="图文素材" >
</div>

<div style="width:300px;margin-top:50px;" id="showArticle-box" v-if="type=='article'&&data_img&&data_title&&selected?true:false">
    <div style="position:relative;border: 1px dashed #CCCCCC;">
        <i class="fa fa-times-circle" id="delArticle" style="font-size: 20px;position: absolute;left:280px;" @click="delData()"></i>
        <h4 style="margin-left:30px;">{#data_title#}</h4>
        <p style="margin-left:30px;">{#data_time#}</p>
        <img id="showArticle" :src=data_img width="240" height="128"  alt="" style="margin-left:30px;" >
    </div>
</div>



<!-- 图文模态框（Modal） -->
<div class="modal fade" id="articleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index:1800;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="fa fa-times"></i>
                </button>
                <p class="modal-title">
                    选择图文素材
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
                    <p>您的图文素材库为空，<a href="#">请先添加素材</a></p>
                </div>

                <div class="have-material clearfix img-list">
                            <div class="col-lg-4 img-text" v-if="data.length"  v-for="(item,index) in data" style="border: 0;height: 200px;" >
                                <div class="img-box-article img-box" :class="{'img-bg':item.id==real.selected?true:false}"       @click="articleSelected($event,index,item.id)"   :data-time=item.updated_at   :data-id=item.id :data-title=item.title  :data-type=item.type :data-url=item.cover_url :data-media_id=item.media_id >
                                {{--<h4>{#item.title#}</h4>--}}
                                {{--<img :src=item.cover_url width="262.22" height="150">--}}
                                <div class="video_item" style="width:210px;margin-left: 20px;">
                                    <h4>{#item.title#}</h4>
                                    <p class="ctime colorless">{#item.updated_at#}</p>
                                    <div>
                                        <img :src=item.cover_url style="width: 230px;height: 120px;">
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
                {{--分页--}}
                <div class="block" style="width:300px; margin: 0 auto;padding: 50px 0;" v-if="data.length">
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
                <button type="button" class="btn btn-primary confirm-img-text" @click="articleSubmit()">
                    确定
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>




