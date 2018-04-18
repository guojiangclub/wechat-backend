<div class="ibox-content" style="display: block;border-top: hidden">
    <div class="box box-primary" >

        <div class="box-body table-responsive" style="margin-left: 20px">
            <table class="table table-hover table-bordered" >
                <tbody>
                <tr>
                    <th>场景名称</th>
                    <th>关联关键字</th>
                    <th>过期时间（秒）</th>
                    <th>场景ID</th>
                    <th>二维码</th>
                    <th>url</th>
                    <th>生成时间</th>
                    <th>到期时间</th>
                    <th>操作</th>
                </tr>
                <!--tr-th end-->
                <tr  class="tr-show"  style="display:none"     v-show="codes.length"  v-for="(item,index) in codes">
                    <td>{#item.name#}</td>
                    <td>{#item.key#}</td>
                    <td>{#item.expire_seconds#}</td>
                    <td>{#item.scene_id#}</td>
                    <td>
                        <a target="_blank" :href=item.qr_code_url>查看</a>
                    </td>
                    <td>{#item.url#}</td>
                    <td>{#item.created_at#}</td>
                    <td>
                        {#Expire(item.expire_time)#}
                    </td>
                    <td>
                        <a class="btn btn-xs btn-primary" href="javascript:;">
                            <i data-toggle="tooltip" data-placement="top" class="fa fa-pencil-square-o" title="" @click="Edit(item.id)"  data-original-title="编辑"></i></a>

                        <a target="_blank" data-method="delete" class="btn btn-xs btn-danger delete-event" @click="Delete(item.id)"
                        href="javascript:;">
                        <i data-toggle="tooltip" data-placement="top"
                           class="fa fa-trash"
                           title="删除"></i></a>

                        <a class="btn btn-xs btn-primary" href="javascript:;">
                            <i data-toggle="tooltip" data-placement="top" class="fa fa-eye" title="" @click="Scans(item.ticket)"  data-original-title="查看"></i></a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <!--分页-->
        <div class="block pull-right" v-if="codes.length">
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


