(function () {
    $(document).ready(function () {
        $('.action-select').on('change', function () {
            var options = $(this).val();
            $('#' + options).show();
            $('#' + options).siblings().hide();
        });
        // //文本
        // $('.confirm-text').on('click', function () {
        //     var text = '';
        //     $('.check-item').each(function () {
        //         if ($(this).is(':checked')) {
        //             var info = $(this).parents('tr').find('.td-text').html();
        //             text = info;
        //         }
        //     });
        //     selectType(text, function () {
        //         $('#textModal').modal('hide');
        //     });
        // });
        // //图片
        // $('.confirm-img').on('click', function () {
        //     var img = $('#imgModal .img-bg').html()
        //     selectType(img,function () {
        //         $('#imgModal').modal('hide');
        //     });
        // });
        // //图文
        // $('.confirm-img-text').on('click', function () {
        //     var img = $('#imageModal .img-bg').html()
        //     selectType(img,function () {
        //         $('#imageModal').modal('hide');
        //     });
        // });
        // //语音
        // $('.confirm-voice').on('click', function () {
        //     var img = $('#voiceModal .img-bg').html()
        //     selectType(img,function () {
        //         $('#voiceModal').modal('hide');
        //     });
        // });
        // //视频
        // $('.confirm-video').on('click', function () {
        //     var img = $('#videoModal .img-bg').html()
        //     selectType(img,function () {
        //         $('#videoModal').modal('hide');
        //     });
        // });
        //
        // $('.delete').on('click', function () {
        //     $(this).prev().css({'display': 'none'});
        //     $(this).css({'display': 'none'});
        //     $(this).prevAll('p').css({'display': 'block'});
        // });

        // function selectType(content, callback) {
        //     if (!content) {
        //         toastr.error('请选择对象');
        //     } else {
        //         $('.select.active p').css({'display': 'none'});
        //         $('.select.active .info-box').html(content);
        //         $('.select.active .info-box,.select.active .delete').css({'display': 'block'});
        //         if (callback && typeof callback === 'function') callback();
        //     }
        // };

        // $('.img-box').on('click', function () {
        //     $(this).parents('.img-list').find('.img-box').removeClass('img-bg');
        //     $(this).toggleClass('img-bg');
        // });

        // $('.submit button').on('click', function () {
        //     /*
        //      action_type: 配置动作类型 （站内信息 || 站内素材 || 自定义）
        //      menu： 一级菜单
        //      menu_name： 一级菜单名
        //      text_info： 站内信息填写的内容（URL || 关键词）
        //      id： 站内素材内容的ID
        //      type：发送的类型 （URL || 关键词 || 文本 || 图片 || 点击推事件　|| ...）
        //      no: 菜单编号（数值越小越靠前）
        //      */
        //     var action_type = $('.action-select').val();
        //     var menu = $('.one-select').val();
        //     var menu_name = $('.menu-name-input').val();
        //     var text_info = $('#' + action_type + ' .text-content').val();
        //     var id = $('.active').find('.info-box').children().data('id');
        //     var type = $('#' + action_type + ' .check-item input[type=radio]:checked').data('href');
        //     var no = $('.number').val();
        //     submit({
        //         action_type:action_type,
        //         menu:menu,
        //         menu_name:menu_name,
        //         text_info:text_info,
        //         id:id,
        //         type:type,
        //         no:no
        //     })
        // })
        
    //     function submit(options) {
    //         // debugger
    //         options = options || {};
    //         var action_type = options.action_type || '';
    //         var menu = options.menu || '';
    //         var menu_name = options.menu_name || '';
    //         var text_info = options.text_info || '';
    //         var id = options.id || '';
    //         var type = options.type || '';
    //         var no = options.no || '';
    //         switch (action_type) {
    //             case 'instationInfo':
    //             case 'custom' :
    //                 if (!text_info || !menu_name || !no) {
    //                    return toastr.error('请选择要发送的内容');
    //                 }
    //                 break;
    //             case 'instationMaterial' :
    //                 if (!id || !menu_name || !no) {
    //                     return toastr.error('请选择要发送的内容');
    //                 }
    //                 break;
    //         }
    //         $.post('http://localhost:8854/server/users', {
    //             action_type: action_type,
    //             menu: menu,
    //             menu_name: menu_name,
    //             text_info: text_info,
    //             type: type,
    //             id: id,
    //             no: no
    //         }, function (ret) {
    //             toastr.success('发送成功');
    //         });
    //     }
    })
}());