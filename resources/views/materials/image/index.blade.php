<!-- 数据列表 -->
@section('after-styles-end')
    {!! Html::style(env("APP_URL").'/assets/wechat-backend/css/addmenu.css') !!}
@stop

<div class="data-table"  style="margin-top:20px;">
    <div class="loading" style="text-align: center;height: 400px;">
        <img src="{{env("APP_URL").'/assets/wechat-backend/img/loading.gif'}}" alt="">
    </div>
    <div class="table-striped">
        <ul class="picture_list">
            <li style="display:none;"></li>
                <li class="data-show" style="display: none" v-show="data.length" v-for="(item,index) in data" :data-id="item.id">
                    <div class="picture_item">
                        <i class="fa fa-times-circle pull-right" @click="Del(item.id)" style="font-size: 25px;"></i>
                        <span style="position: relative;top:10px;left:18px">{#item.updated_at#}</span>
                        <div class="main_img" style="width:220px;height:180px">
                            <a :href="item.source_url" target="_blank">
                                <img :src="item.source_url" style="width:100%;height: 100%">
                            </a>
                        </div>
                        <div class="picture_action">
                                <span :id="'copy'+item.id"   style="width: 100%" :data-url="item.source_url"   @click="copyURL(item.id)">复制链接</span>
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
    共 ：{#total#}  张
</div>






