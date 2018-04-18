<div class="data-table" style="margin-top:20px;">
        <div class="loading" style="text-align: center;height: 400px;">
            <img src="{{env("APP_URL").'/assets/wechat-backend/img/loading.gif'}}" alt="">
        </div>
        <div class="table-striped">
            <ul class="picture_list">
                <li class="data-show" style="display: none" v-show="data.length" v-for="(item,index) in data" :data-id="item.id">
                    <div class="picture_item">
                        <div class="video_item" style="width:220px;">
                            <i class="fa fa-times-circle pull-right" @click="Del(item.id)" style="font-size: 25px;"></i>
                            <p class="title ellipsis">{#item.title#}</p>
                            <p class="ctime colorless">{#item.updated_at#}</p>
                            <div class="video_area1" style="width:200px;">
                                <video  :src="item.source_url" controls="controls">您的浏览器不支持 video 标签。</video>
                            </div>
                            <p>{#item.description#}</p>
                        </div>
                        <div class="picture_action">
                            <span :id="'copy'+item.id"   style="width: 100%" :data-url="item.wechat_url"   @click="copyURL(item.id)">复制链接</span>
                        </div>
                    </div>
                </li>
            </ul>
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