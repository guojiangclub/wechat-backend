<div class="col-lg-4 fans-list-show" style="display:none;" v-show="fans.length"  v-for="(item,index) in fans">
    <el-checkbox  v-show="fans.length&&index<3"  :id="'allck'+index"  @change="checkedAllBox"   v-model="checkedAll_status">全选</el-checkbox>
    <div class="user-info-box"  :data-id=item.id  :data-openid=item.openid>
            <div class="info-box-sidebar" @click="getInfo(item.openid)">
              <img v-if="item.avatar?true:false" :src=item.avatar alt="">
            </div>

            <el-checkbox-group v-model="checked" class="pull-right">
                <el-checkbox  :label="item.openid"></el-checkbox>
            </el-checkbox-group>

            <div class="info-box-content">
                <div class="info-box-nicks" style="  font-size: 16px;"  @click="getInfo(item.openid)">
                    {#decodeURI(item.nickname)#}
                     {{--<el-radio class="radio" v-model="selected"  :label=item.id  :data-id=item.id  :data-openid=item.openid ></el-radio>--}}
                </div>
            <div class="text-auto-hide">

            <i class="fa fa-user"></i>
            <span>注册会员 ：</span>
                {#!item.unionid?'否':''#}
                {#item.user&&item.user.mobile#}
            </div>
            <div class="text-auto-hide">
            <i class="fa fa-male"></i>
            <span>性别 ：</span>
                {#item.sex#}
            </div>
            {{--<div class="text-auto-hide">--}}
            {{--<i class="fa fa-users"></i>--}}
            {{--<span>分组 ：</span>--}}
            {{--111--}}
            {{--</div>--}}
            <div class="text-auto-hide">
                <i class="fa fa-star-o"></i>
                <span>关注时间 ：</span>
                {#item.subscribed_at#}
            </div>
        </div>
    </div>
</div>





