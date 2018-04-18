<!-- 数据列表 -->

<div class="data-table"  style="margin-left:30px;">
    <div class="loading" style="text-align: center;height: 400px;">
        <img src="{{env("APP_URL").'/assets/wechat-backend/img/loading.gif'}}" alt="">
    </div>
    <div class="table-striped">
        <ul class="material_list js-masonry data-show" style="display: none">
            <!-- 多图文- -->
                        <li class="appmsg_li"   v-show="data.length" v-for="(item,index) in data" v-if="item.is_multi">
                            <i class="fa fa-times-circle pull-right" @click="Del(item.id)" style="font-size: 25px;"></i>
                            <div class="appmsg_item">
                                <p class="title">
                                    {#item.created_at#}
                                </p>

                                    <div class="main_img" style="width:270px;height:150px;">
                                        <a :href="item.wechat_url" target="_blank">
                                            <img :src="item.cover_url"/>
                                        </a>
                                        <h6>
                                            {#item.title#}
                                        </h6>
                                    </div>

                                <p class="desc ellipsis">
                                    {#item.description#}
                                </p>
                            </div>

                                <div class="appmsg_sub_item" style="height:110px;" v-for="(citem,cindex) in item.childrens" >
                                    <p class="title ellipsis">{#citem.title#}</p>
                                    <div class="main_img">
                                        <a :href="citem.wechat_url" target="_blank">
                                            <img :src="citem.cover_url"/>
                                        </a>
                                    </div>
                                </div>

                            <div class="appmsg_action">
                                <span :id="'edit'+item.id"   style="width: 50%" @click="EditArticle(item.id)">编辑图文</span>
                                <span :id="'copy'+item.id"   style="width: 50%" :data-url="item.wechat_url"  @click="copyURL(item.id)">复制链接</span>
                            </div>
                        </li>

                    <!-- 单图文 -->
                        <li class="appmsg_li" v-else>
                            <i class="fa fa-times-circle pull-right" @click="Del(item.id)" style="font-size: 25px;"></i>
                            <div class="appmsg_item">
                                <h6 class="ellipsis"> {#item.created_at#}</h6>
                                <p class="title">{#item.title#}</p>
                                <div class="main_img" style="width:270px;height:150px;">
                                    <a :href="item.wechat_url" target="_blank">
                                        <img :src="item.cover_url"/>
                                    </a>

                                </div>
                                <p class="desc ellipsis">{#item.description#}</p>
                            </div>
                            <div class="appmsg_action">
                                <span :id="'edit'+item.id"   style="width: 50%" @click="EditArticle(item.id)">编辑图文</span>
                                <span :id="'copy'+item.id"   style="width: 50%" :data-url="item.wechat_url"  @click="copyURL(item.id)">复制链接</span>
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

