
<div class="form-group">
    <div class="col-sm-4">
        <button  data-style="expand-right"  class="btn btn-info material_btn" style="margin-left: 12px;" @click="textModal()">文本素材</button>
    </div>
</div>

<!-- 文本模态框（Modal） -->
<div class="modal fade" id="textModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="fa fa-times" @click="ModalDel()"></i>
                </button>
                <p class="modal-title">
                    选择文本素材
                </p>
            </div>
            <div class="modal-body" style="margin-top: 20px;">
                <div class="no-material">
                    {{--<img src="img/empty_content.png" alt="">--}}
                    <p>您的文本素材库为空，<a href="#">请先添加素材</a></p>
                </div>
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
                                <input type="text" class="form-control" :value="keyword"   placeholder="请输入搜索内容" v-model="keyword">
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
                    <div class="material-table clearfix">
                        <div class="loading" style="margin-left:400px;margin-top:120px;height:280px;">
                            <img src="{{env("APP_URL").'/assets/wechat-backend/img/loading.gif'}}" alt="">
                        </div>
                        <table class="table table-striped table-bordered table-hover" v-if="data.length">
                            <thead>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>素材文本内容</th>
                                <th>更新时间</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="data.length" v-for="(item,index) in data">
                                <td>
                                    <el-radio class="radio" v-model="real.selected"  :label=item.id  :data-id=item.id  :data-text=item.content ></el-radio>
                                </td>
                                <td class="no" style="line-height: 40px;">{#item.id#}</td>
                                <td class="td-text" style="line-height: 40px;"><span :id=item.id+'text'>{#decodeURI(item.content)#}</span></td>
                                <td class="td-text col-sm-3" style="line-height: 40px;">{#item.updated_at#}</td>
                            </tr>
                            </tbody>
                        </table>
                        {{--分页--}}
                        <div class="block pull-left"   style="width:300px; margin: 0 auto;padding: 10px 0;" v-if="data.length">
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
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" @click="ModalDel()">关闭
                </button>
                <button type="button" class="btn btn-primary confirm-text" @click="Submit()">
                确定
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>







