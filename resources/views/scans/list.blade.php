<div class="ibox-content" style="display: block;border-top: hidden">
    <div class="box box-primary" >

        <div class="box-body table-responsive" style="margin-left: 20px">
            <table class="table table-hover table-bordered" >
                <tbody>
                <tr>
                    <th>粉丝昵称</th>
                    <th>关联关键字</th>
                    <th>场景名称</th>
                    <th>二维码类型</th>
                    <th>动作</th>
                    <th>场景ID或场景值</th>
                    <th>扫描时间</th>
                </tr>
                <!--tr-th end-->
                <tr  class="tr-show"   v-show="scans.length" style="display: none"  v-for="(item,index) in scans">
                    <td v-if="item.fans && item.fans.nickname" @click="getInfo(item.fans.openid)">{#decodeURI(item.fans.nickname)#}</td>
                    <td v-else></td>
                    <td v-if="item.qr_code && item.qr_code.key">{#item.qr_code.key#}</td>
                    <td v-else></td>
                    <td>{#item.name#}</td>
                    <td v-if="item.qr_code && item.qr_code.type">
                        {#item.qr_code.type==2?"永久二维码":"临时二维码"#}
                    </td>
                    <td v-else></td>
                    <td>
                        {#item.type==1?"关注":"扫描"#}
                    </td>
                    <td>{#item.key#}</td>
                    <td>{#item.created_at#}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <!--分页-->

        <div class="block pull-left" v-show="scans.length">
            <div class="row" style="margin-left:28px;">
                共&nbsp;{#total#}&nbsp;条
            </div>
        </div>

        <div class="block pull-right" v-if="scans.length">
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

<div class="modal fade" id="textModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="margin-bottom: 10px;">
                    <i class="fa fa-times"></i>
                </button>
                <div class="have-material clearfix">
                    <div class="material-table clearfix">
                        <div class="loading" style="margin-left:400px;margin-top:120px;height:280px;">
                            <img src="{{env("APP_URL").'/assets/wechat-backend/img/loading.gif'}}" alt="">
                        </div>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="col-md-6">OpenId</th>
                                <td class="td-text">{#info.openid#}</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th class="col-md-6">昵称</th>
                                <td class="td-text">{#decodeURI(info.nickname)#}</td>
                            </tr>
                            </tbody>

                            <thead>
                            <tr>
                                <th class="col-md-6" >头像</th>
                                <td class="td-text" v-if="info.avatar">
                                    <a :href="info.avatar" target="-_blank">
                                        <img :src="info.avatar" alt="" width="50" height="50">
                                    </a>
                                </td>
                                <td class="td-text"  v-else></td>
                            </tr>
                            </thead>
                            <tbody>
                            {{--<tr>--}}
                                {{--<th class="col-md-6">性别</th>--}}
                                {{--<td class="td-text">{#info.sex#}</td>--}}
                            {{--</tr>--}}
                            </tbody>

                            <thead>
                            <tr>
                                <th class="col-md-6">地区</th>
                                <td class="td-text" ><span>{#info.country#}</span>&nbsp;&nbsp;&nbsp;<span>{#info.city#}</span></td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th class="col-md-6">关注时间</th>
                                <td class="td-text" ><span>{#info.subscribed_at#}</span></td>
                            </tr>
                            </tbody>


                            <thead>
                            {{--<tr>--}}
                                {{--<th class="col-md-6">最后活跃时间</th>--}}
                                {{--<td class="td-text"  v-if="info.last_online_at">{#info.last_online_at#}</td>--}}
                                {{--<td class="td-text"  v-else></td>--}}
                            {{--</tr>--}}
                            </thead>
                            <tbody>
                            <tr>
                                <th class="col-md-6">用户组</th>
                                <td class="td-text"  v-if="fans_group">{#fans_group.title#}</td>
                                <td class="td-text"  v-else></td>
                            </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

@include('wechat-backend::active')


