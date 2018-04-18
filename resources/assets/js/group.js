(function () {
   $(document).ready(function () {
       $('.appoint').css({'display':'none'});
       $('.select-type').change(function () {
           var type = $(this).val();
           var typeid = $('.info-li.active').find('a').attr('href');
           if (type == 'OpenID') {
               $(typeid + ' .appoint').css({'display':'block'});
               $(typeid +' .object-box').css({'display':'none'});
           } else {
               $(typeid +' .appoint').css({'display':'none'});
               $(typeid + ' .object-box').css({'display':'block'});
           }
       });

       //文本
       $('.confirm-text').on('click', function () {
           var text = '';
           $('.check-item').each(function () {
               if ($(this).is(':checked')) {
                   var info = $(this).parents('tr').find('.td-text').text();
                   text = info;
               }
           });
           selectType(text, function () {
               $('#textModal').modal('hide');
           }, text);
       });
       //图片
       $('.confirm-img').on('click', function () {
           var img = $('#imgModal .img-bg').html()
           selectType(img,function () {
               $('#imgModal').modal('hide');
           })
       });
       //图文
       $('.confirm-img-text').on('click', function () {
           var img = $('#imageModal .img-bg').html()
           selectType(img,function () {
               $('#imageModal').modal('hide');
           })
       });
       //语音
       $('.confirm-voice').on('click', function () {
           var img = $('#voiceModal .img-bg').html()
           selectType(img,function () {
               $('#voiceModal').modal('hide');
           })
       });
       //视频
       $('.confirm-video').on('click', function () {
           var img = $('#videoModal .img-bg').html()
           selectType(img,function () {
               $('#videoModal').modal('hide');
           })
       });

       $('.delete').on('click', function () {
           $(this).prev().css({'display': 'none'});
           $(this).css({'display': 'none'});
           $(this).prevAll('p').css({'display': 'block'});
       });

       function selectType(content, callback,text) {
           if (!content) {
               toastr.error('请选择对象');
           } else {
               var id = $('.info-li.active').find('a').attr('href');
               $(id + ' .select.active p').css({'display': 'none'});
               $(id + ' .select.active .info-box').html(content);
               $(id + ' .text-content').val(text);
               $(id + ' .select.active .info-box,.select.active .delete').css({'display': 'block'});
               if (callback && typeof callback === 'function') callback();
           }
       };

       $('.img-box').on('click', function () {
           $(this).parents('.img-list').find('.img-box').removeClass('img-bg');
           $(this).toggleClass('img-bg');
       });

       //指定OpenID
       $('.confirm-user').on('click', function () {
           var userid= '';
           var name = '';
           var typeid = $('.info-li.active').find('a').attr('href');
           $('.click-item').each(function () {
               if ($(this).is(':checked')) {
                   var user_id = $(this).parents('tr').data('id');
                   var user_name = $(this).parents('tr').data('name');
                   userid = user_id;
                   name = user_name;
               }
           });
           if (!userid) {
               toastr.error('请选择用户！');
           } else {
               $(typeid + ' .user span').html(name);
               $(typeid + ' .user span').attr('data-userid', userid);
               $('#userModal').modal('hide');
           }
       });

       //提交群发（高级群发）
       $('.submit').on('click', function () {
           /*
            typeid: 群发方式（高级群发 || 客服群发）
            type： 发送消息的类型（文本 || 图片 || ...）
            id: 发送消息内容的ID
            text：文本框中的内容
            groupid：发送方式为用户组发送时，群发对象的id
            sendtype： 发送方式（按用户组发送 || 指定openid发送）
            userid： 发送方式为指定openid时，指定的用户的id
            */
           var typeid = $('.info-li.active').find('a').attr('href');
           var type = $('input[name=radio2]:checked').data('href');
           var id = $('.active').find('.info-box').children().data('id');
           var text = $(typeid + ' .text-content').val();
           var groupid = $(typeid + ' .select-group').val();
           var sendtype = $(typeid + ' .select-type').val();
           var userid = $(typeid + ' .user span').data('userid');
           submit({
               typeid: typeid,
               type: type,
               id: id,
               text: text,
               groupid: groupid,
               sendtype: sendtype,
               userid: userid
           });
       });

       //提交群发 （客服群发）
       $('.submit-kf').on('click', function () {
           /*
            typeid: 群发方式（高级群发 || 客服群发）
            type： 发送消息的类型（文本 || 图片 || ...）
            id: 发送消息内容的ID
            text：文本框中的内容
            groupid：发送方式为用户组发送时，群发对象的id
            sendtype： 发送方式（按用户组发送 || 指定openid发送）
            userid： 发送方式为指定openid时，指定的用户的id
            */
           var typeid = $('.info-li.active').find('a').attr('href');
           var type = $('input[name=radio]:checked').data('href');
           var id = $('.active').find('.info-box').children().data('id');
           var text = $(typeid + ' .text-content').val();
           var groupid = $(typeid + ' .select-group').val();
           var sendtype = $(typeid + ' .select-type').val();
           var userid = $(typeid + ' .user span').data('userid');
           submit({
               typeid: typeid,
               type: type,
               id: id,
               text: text,
               groupid: groupid,
               sendtype: sendtype,
               userid: userid
           });
       });

       function submit(options) {
           options = options || {};
           var typeid = options.typeid || '';
           var type = options.type || '';
           var id = options.id || '';
           var text = options.text || '';
           var groupid = options.groupid || '';
           var sendtype = options.sendtype || '';
           var userid = options.userid || '';

           if (!id && !text) {
               toastr.error('请选择要发送的内容');
           } else {
               $.post('http://localhost:8854/server/users', {
                   typeid: typeid,
                   type: type,
                   id: id,
                   text: text,
                   groupid: groupid,
                   sendtype: sendtype,
                   userid: userid
               }, function (ret) {
                   toastr.success('发送成功');
               });
           }
       }
   });
})();