<div class="ibox-content" style="display: block;border-top: hidden">
    <div class="box box-primary" >

        <div class="box-body table-responsive" style="margin-left: 20px">
            <table class="table table-hover table-bordered" >
                <tbody>
                <tr>
                    <th>关键字</th>
                    <th>规则说明</th>
                    <th>微信卡券ID</th>
                    <th>最后更新时间</th>
                    <th>操作</th>
                </tr>
                <!--tr-th end-->
                <tr  class="tr-show"  style="display:none;"  v-show="events.length"  v-for="(item,index) in events">
                    <td v-show="keybtn[item.id]">
                        <el-select class="col-sm-12"
                                   v-model="keybtn[item.id]"
                                   multiple
                                   disabled
                        >
                        </el-select>

                    </td>
                    <td v-show="keybtn[item.id]">{#item.rule#}</td>
                    <td v-show="keybtn[item.id]">{#item.value#}</td>
                    <td v-show="keybtn[item.id]">{#item.updated_at#}</td>
                    <td v-show="keybtn[item.id]" >
                                <span class="btn btn-xs btn-primary">
                                    <i data-toggle="tooltip" data-placement="top" class="fa fa-pencil-square-o" title="" @click="Edit(item.id)"  data-original-title="编辑"></i></span>
                        <span class="btn btn-xs btn-danger delete-event" @click="Delete(item.id)"
                        >
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


