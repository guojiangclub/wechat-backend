(function () {
    $(document).ready(function () {
        //文本
        $('.confirm-text').on('click', function () {
            var text = '';
            $('.check-item').each(function () {
                if ($(this).is(':checked')) {
                    var info = $(this).parents('tr').find('.td-text').html();
                    text = info;
                }
            });
            selectType(text, function () {
                $('#textModal').modal('hide');
            });
        });
        //图片
        $('.confirm-img').on('click', function () {
            var img = $('#imgModal .img-bg').html()
            selectType(img,function () {
                $('#imgModal').modal('hide');
            });
        });
        //图文
        $('.confirm-img-text').on('click', function () {
            var img = $('#imageModal .img-bg').html()
            selectType(img,function () {
                $('#imageModal').modal('hide');
            });
        });
        //语音
        $('.confirm-voice').on('click', function () {
            var img = $('#voiceModal .img-bg').html()
            selectType(img,function () {
                $('#voiceModal').modal('hide');
            });
        });
        //视频
        $('.confirm-video').on('click', function () {
            var img = $('#videoModal .img-bg').html()
            selectType(img,function () {
                $('#videoModal').modal('hide');
            });
        });

        $('.delete').on('click', function () {
            $(this).prev().css({'display': 'none'});
            $(this).css({'display': 'none'});
            $(this).prevAll('p').css({'display': 'block'});
        });

        function selectType(content, callback) {
            if (!content) {
                toastr.error('请选择对象');
            } else {
                $('.select.active p').css({'display': 'none'});
                $('.select.active .info-box').html(content);
                $('.select.active .info-box,.select.active .delete').css({'display': 'block'});
                if (callback && typeof callback === 'function') callback();
            }
        };
        function submit(value, id) {
            if (!id) {
                toastr.error('请选择要提交的内容');
            } else {
                $.post('http://localhost:8854/server/group', {
                    type: value,
                    id: id
                }, function (ret) {
                    //TODO
                    toastr.success('提交成功！');
                })
            }
        };

        $('.submit').on('click', function () {
           var type = $('input[name=radio]:checked').data('href');
           var id = $('.active').find('.info-box').children().data('id');

            submit(type,id);
        });
        
        $('.img-box').on('click', function () {
            $(this).parents('.img-list').find('.img-box').removeClass('img-bg');
            $(this).toggleClass('img-bg');
        });
    });
}());