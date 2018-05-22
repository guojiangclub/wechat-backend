<div class="ibox-content" style="display: block;border-top: hidden">
    <div class="box box-primary" >

        <div class="box-body table-responsive" style="margin-left: 20px">
            <table class="table table-hover table-bordered" >
                <tbody>
                <tr>
                    <th>关键字</th>
                    <th>规则说明</th>
                    <th>图文标题(封面)</th>
                    <th>最后更新时间</th>
                    <th>操作</th>
                </tr>
                <!--tr-th end-->
                <tr class="tr-show"   v-show="events.length" style="display: none"  v-for="(item,index) in events">
                    <td v-if="keybtn[item.id]">
                        <el-select class="col-sm-12"
                                   v-model="keybtn[item.id]"
                                   multiple
                                   disabled
                        >
                        </el-select>
                    </td>
                    <td v-if="keybtn[item.id]">{#item.rule#}</td>

                    <td v-if="keybtn[item.id]&&item&&item.material&&item.material.cover_url&&item.material.title">
                          <span>{#item.material.title#}</span><br>
                          <img width="120" height="60"  :src=item.material.cover_url
                                 alt="">
                    </td>
                    <td v-else></td>

                    <td v-if="keybtn[item.id]">{#item.updated_at#}</td>

                    <td>
                        <span class="btn btn-xs btn-primary" >
                            <i data-toggle="tooltip" data-placement="top" class="fa fa-pencil-square-o" title=""  @click="Edit(item.id,3)"    data-original-title="编辑"></i>
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


