



    <input type="button" id="post0"  value="上传微信图片素材接口">
    <input type="button" id="get1"  value="获取会员卡颜色">
    <input type="button" id="post1"  value="创建会员卡">
    <input type="button" id="post2"  value="获取会员卡信息">
    <input type="button" id="post3"  value="获取会员卡二维码">
    <input type="button" id="post4"  value="获取会员卡code">
    <input type="button" id="post5"  value="编辑更新会员卡">
    <input type="button" id="post6"  value="激活会员卡">
    <input type="button" id="post7"  value="获取激活的会员info">
    <input type="button" id="post8"  value="更新库存">
    <input type="button" id="post9"  value="删除会员卡">
    <input type="button" id="post10"  value="指定会员卡失效">
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/jquery.zclip/jquery.js') !!}
    {!! Html::script(env("APP_URL").'/assets/wechat-backend/libs/jquery.form.min.js') !!}

<script>
    /**************************************************************************************/
    /**************************** 注释的参数为非必填参数 **********************************/
    /**************************************************************************************/
    /**************************** 获取会员卡颜色 **********************************/
    $(function () {
        $('#post0').click(function () {
            var data={
                path:"图片路径",
                url:"图片url",
            }
            var url="{{route('admin.wechat-api.upload.img')}}";
            $.ajax({
                type:"post",
                url:url,
                data:data,
                success:function(res){
                    console.log(res);
                }
            });

        }),







 /**************************** 获取会员卡颜色 **********************************/

           $('#get1').click(function () {
               var data={

               }
                var url="{{route('admin.wechat-api.member.card.colors')}}";
               $.ajax({
                   type:"get",
                   url:url,
                   data:data,
                   success:function(res){
                       console.log(res);
                   }
               });

           }),
/**************************** 创建会员卡 **********************************/
           $('#post1').click(function () {
               var data={
                   "base_info": {
                       "logo_url": "http://mmbiz.qpic.cn/mmbiz/iaL1LJM1mF9aRKPZJkmG8xXhiaHqkKSVMMWeN3hLut7X7hicFNjakmxibMLGWpXrEXB33367o7zHN0CwngnQY7zb7g/0",
                       "brand_name": "测试卡啊兄弟",
                       "code_type": "CODE_TYPE_BARCODE",
                       "title": "会员卡啊兄弟",
                       "color": "Color020",
                       "notice": "使用时向服务员出示此券",
// "service_phone": "020-88888888",
                       "description": "不可与其他优惠同享",
                       "date_info": {
                           "type": "DATE_TYPE_FIX_TERM",
                           "fixed_term":100

                       },
                       "sku": {
                           "quantity": 50000000
                       },
                       "get_limit": 1,

//                       "center_title":"买买买",
//                       "center_url":"http://www.baidu.com",
//
//
//                       "custom_url_name":"立即使用",
//                       "custom_url":"http://www.qq.com",
//                       "custom_url_sub_title":"6个汉字tips",
//
//                       "promotion_url_name":"更多优惠",
//                       "promotion_url":"http://www.qq.com",
//                       "promotion_url_sub_title":"卖场大优惠"



                   },
                   "especial": {

//  "background_pic_url":"http://mmbiz.qpic.cn/mmbiz/iaL1LJM1mF9aRKPZJkmG8xXhiaHqkKSVMMWeN3hLut7X7hicFNjakmxibMLGWpXrEXB33367o7zHN0CwngnQY7zb7g/0",
//                       "custom_field1": {
//                           "name": "会员积分",
//                           "url": "http://www.jifen.com"
//                       },
//
//
//                       "custom_field2": {
//                           "name": "会员等级",
//                           "url": "http://www.dengji.com"
//                       },
//
//                       "custom_field3": {
//                           "name": "会员优惠券",
//                           "url": "http://www.youhuiquan.com"
//                       },
//
//                       "custom_cell1": {
//                           "name": "会员中心",
//                           "tips": "激活后显示",
//                           "url": "http://www.qq.com"
//                       },


                       "prerogative": "test_prerogative",
                       "activate_url": "http://www.xxx.com"
                   },
                   _token:"{{ csrf_token()}}"
               }
               var url="{{route('admin.wechat-api.member.card.create')}}";
               $.ajax({
                   type:"post",
                   url:url,
                   data:data,
                   success:function(res){
                      console.log(res);
                   }
               });
           })

/**************************** 获取会员卡信息 **********************************/
           $('#post2').click(function () {
               var data={
                   "card_id":"poGxkwrMOjtcRKQ1RXAQKjq7twbg",
                   _token:"{{ csrf_token()}}"
               }
               var url="{{route('admin.wechat-api.member.card.info')}}";
               $.ajax({
                   type:"post",
                   url:url,
                   data:data,
                   success:function(res){
                       console.log(res);
                   }
               });
           })


/****************************获取会员卡二维码 **********************************/
           $('#post3').click(function () {
               var data={
                   "card_id":"poGxkwryU6NCx9KNdm7x6w526kqg",
                   _token:"{{ csrf_token()}}"
               }
               var url="{{route('admin.wechat-api.member.card.QRCode')}}";
               $.ajax({
                   type:"post",
                   url:url,
                   data:data,
                   success:function(res){
                       console.log(res);
                   }
               });
           })


/****************************获取会员卡code **********************************/
           $('#post4').click(function () {
               var data={
                   "card_id":"poGxkwjy-CXFnrmPG5yjMQ4_hXqU",
                   "open_id":"ooGxkwpof3XGVSRrwL6rOpBhcz0o",
                   _token:"{{ csrf_token()}}"
               }
               var url="{{route('admin.wechat-api.member.card.getCode')}}";
               $.ajax({
                   type:"post",
                   url:url,
                   data:data,
                   success:function(res){
                       console.log(res);
                   }
               });
           })


/**************************** 编辑更新会员卡 **********************************/
           $('#post5').click(function () {
               var data={
                   "card_id":"poGxkwnWkH7FHLniYc84vqDePKgk",
                   "base_info":{

                   },
                   "especial":{

                   },

                   _token:"{{ csrf_token()}}"
               }
               var url="{{route('admin.wechat-api.member.card.update')}}";
               $.ajax({
                   type:"post",
                   url:url,
                   data:data,
                   success:function(res){
                       console.log(res);
                   }
               });
           })


/****************************激活会员卡  **********************************/
           $('#post6').click(function () {
               var data={
                   "card_id":"poGxkws0fQHW8O4SyRPbDqA0y3jo",
                   "code":"997620142778",
                   "membership_number":"1234567819",
//                   "background_pic_url":"http://mmbiz.qpic.cn/mmbiz_png/xcZVicCwHPyUPGhaPWYwKKE3RYfblTomAE6mXtAVyg4dYummI9TmPC4c6XpEr9EGEu1MAM9wiaoyY5ichWY6UgCOg/0?wx_fmt=png",
//                   "activate_begin_time":"1493568000",
//                   "activate_end_time":"1525104000",
//                   "init_custom_field_value1":"0",
//                   "init_custom_field_value2":"VIP0",
//                   "init_custom_field_value3":"查看",
                   _token:"{{ csrf_token()}}"
               }
               var url="{{route('admin.wechat-api.member.card.membership.activate')}}";
               $.ajax({
                   type:"post",
                   url:url,
                   data:data,
                   success:function(res){
                       console.log(res);
                   }
               });
           })


/****************************获取激活的会员info  **********************************/
           $('#post7').click(function () {
               var data={
                   "card_id":"poGxkws0fQHW8O4SyRPbDqA0y3jo",
                   "code":"997620142778",
                   _token:"{{ csrf_token()}}"
               }
               var url="{{route('admin.wechat-api.member.card.membership.get')}}";
               $.ajax({
                   type:"post",
                   url:url,
                   data:data,
                   success:function(res){
                       console.log(res);
                   }
               });
           })


//           amount  100 添加100个库存
//           amount  -100 减少100个库存
 /**************************** 更新库存 **********************************/
           $('#post8').click(function () {
               var data={
                   "card_id":"poGxkws0fQHW8O4SyRPbDqA0y3jo",
                   "amount":10000,
                   _token:"{{ csrf_token()}}"
               }
               var url="{{route('admin.wechat-api.member.card.update.quantity')}}";
               $.ajax({
                   type:"post",
                   url:url,
                   data:data,
                   success:function(res){
                       console.log(res);
                   }
               });
           })


/**************************** 删除会员卡 **********************************/
           $('#post9').click(function () {
               var data={
                   "card_id":"poGxkwrMOjtcRKQ1RXAQKjq7twbg",
                   "amount":10000,
                   _token:"{{ csrf_token()}}"
               }
               var url="{{route('admin.wechat-api.member.card.delete')}}";
               $.ajax({
                   type:"post",
                   url:url,
                   data:data,
                   success:function(res){
                       console.log(res);
                   }
               });
           })



/**************************** 指定会员卡失效 **********************************/
           $('#post10').click(function () {
               var data={
                   "card_id":"poGxkwrMOjtcRKQ1RXAQKjq7twbg",
                   "code":"111",
                   _token:"{{ csrf_token()}}"
               }
               var url="{{route('admin.wechat-api.member.card.disable')}}";
               $.ajax({
                   type:"post",
                   url:url,
                   data:data,
                   success:function(res){
                       console.log(res);
                   }
               });
           })
       })


    </script>

