<div class="ibox-content" style="display: block;border-top: hidden">
    <div class="box box-primary" >

        <div class="box-body table-responsive" style="margin-left: 20px">
            <table class="table table-hover table-bordered" >
                <tbody>
                <tr>
                    <th>关键字</th>
                    <th>规则说明</th>
                    <th>视频</th>
                    <th>最后更新时间</th>
                    <th>操作</th>
                </tr>
                <!--tr-th end-->
                    <tr  class="tr-show"  style="display: none;"  v-show="events.length"  v-for="(item,index) in events">
                        <td v-if="keybtn[item.id]">
                            <el-select class="col-sm-12"
                                       v-model="keybtn[item.id]"
                                       multiple
                                       disabled
                            >
                            </el-select>
                        </td>
                        <td v-if="keybtn[item.id]">{#item.rule#}</td>

                        <td v-if="keybtn[item.id]&&item&&item.material&&item.material.source_url&&item.material.title">
                            <div class="video_area1" style="width:200px;">
                                <span>{#item.material.title#}</span>
                                <video  :src=item.material.source_url
                                        controls="controls">您的浏览器不支持 video 标签。</video>
                            </div>
                        </td>
                        <td v-else></td>


                        <td v-if="keybtn[item.id]">{#item.updated_at#}</td>

                        <td v-if="keybtn[item.id]">
                            <span class="btn btn-xs btn-primary" >
                                <i data-toggle="tooltip" data-placement="top" class="fa fa-pencil-square-o" title=""  @click="Edit(item.id,4)"    data-original-title="编辑"></i>
                            </span>
                            <span target="_blank" class="btn btn-xs btn-danger"  @click="Delete(item.id)"
                            href="javascript:;">
                            <i data-toggle="tooltip" data-placement="top"
                               class="fa fa-trash"
                               title="删除"></i></span>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        <!--分页-->
        <div class="block pull-right" v-if="events.length">
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


