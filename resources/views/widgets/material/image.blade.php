
<input name="selected-id" type="hidden" value="" v-model="selected">
<input name="selected-img" type="hidden" value="" v-model="data_img">
<div class="col-sm-9 controls">
    <input type="button"  data-toggle="modal" @click="imageModal()"    class="btn btn-info material_btn" value="图片素材" >
    <div id="upload-img"  class="pull-left col-sm-4">
        <span id="imguping"  data-style="expand-right"  class="but ladda-button " type="submit" disabled ><span id="scspan">上传图片</span></span>
    </div>
</div>

<div class="col-sm-9" style="margin-top:15px;" id="showImg-box"  v-if="type=='image'&&data_img&&selected?true:false">
    <div style="position:relative">
        <i class="fa fa-times-circle" id="delImg" style="font-size: 20px;position: absolute;left:280px;" @click="delData"></i>
        <img id="showImg" :src=data_img width="300" height="200"  alt="" style="border: 1px dashed #CCCCCC">
    </div>
</div>



<!-- 图片模态框（Modal） -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="fa fa-times" @click="ModalDel()"></i>
                </button>
                <p class="modal-title">
                    选择图片素材
                </p>
            </div>
            <div class="modal-body" style="margin-top: 20px;">
                <div class="have-material clearfix">
                    <div class="col-sm-4">
                        <div class="input-group date form_datetime form_datetime_stime">
                                        <span class="input-group-addon" style="cursor: pointer">
                                            <i class="fa fa-calendar"></i>&nbsp;&nbsp;上传时间</span>
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
                            <div class="input-group" style="margin-left:160px;">
                                {{--<input type="text" class="form-control" :value="keyword"   placeholder="请输入搜索标题" v-model="keyword">--}}
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
                <img src="{{env("APP_URL").'/assets/wechat-backend/img/loading.gif'}}" alt="" class="loading" style="margin-left: 400px;">
                <div class="no-material">
                    <img src="" alt="">
                    <p>您的图片素材库为空，<a href="#">请先添加素材</a></p>
                </div>
                <div class="have-material clearfix img-list">
                    <div class="col-lg-3 img-warp" v-if="data.length"  v-for="(item,index) in data">
                        <div :id=item.id+"img-box"  class="img-box img-box-image"    :class="{'img-bg':item.id==real.selected?true:false}"    @click="imageSelected($event,index,item.id)" :data-id=item.id  :data-type=item.type :data-url=item.source_url :data-media_id=item.media_id >
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
            <button type="button" class="btn btn-default" data-dismiss="modal" @click="ModalDel()">关闭
            </button>
            <button type="button" class="btn btn-primary confirm-img" @click="imageSubmit()">
            确定
            </button>
        </div>
    </div><!-- /.modal-content -->
    </div>
</div>
