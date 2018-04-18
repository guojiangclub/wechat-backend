<div class="ibox-content app"  style="display: block;border-top: hidden">
    <div class="box box-primary">
        <div class="box-body table-responsive" style="margin-left: 20px">
            <table class="table table-hover table-bordered" >
                <tbody>
                    <!--tr-th start-->
                    <tr >
                        <th>文本内容</th>
                        <th  class="col-sm-2">最后更新时间</th>
                        <th  class="col-sm-2">操作</th>
                    </tr>
                        <!--tr-th end-->
                        <tr class="data-show" style="display: none" v-show="data.length" v-for="(item,index) in data" :data-id="item.id">
                            <td>{#decodeURI(item.content)#}</td>
                            <td>{#item.updated_at#}</td>
                            <td>
                                <span class="btn btn-xs btn-primary" @click="Edit(item.id)">
                                    <i data-toggle="tooltip" data-placement="top" class="fa fa-pencil-square-o" title="" data-original-title="编辑"></i></span>
                                <span target="_blank" data-method="delete" class="btn btn-xs btn-danger"  @click="Del(item.id)">
                                    <i data-toggle="tooltip" data-placement="top"
                                       class="fa fa-trash"
                                       title="删除"></i></span>
                            </td>
                        </tr>


                </tbody>
            </table>
        </div>
    </div>

</div>


<!--分页-->
<div class="block pull-left" v-if="data.length" style="margin-left:30px;">
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

<div class="pull-right data-show-count" style="display: none;margin-right:180px;"  v-show="data.length">
    共 ：{#total#}  条
</div>

