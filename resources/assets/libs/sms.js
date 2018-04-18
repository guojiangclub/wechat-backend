$(document).ready(function () {
    // 发送验证码
    $('.send-verifi').on('click', function () {
        var el = $(this);
        var target = el.data('target');
        var mobileReg = /(^(13\d|14[57]|15[^4\D]|17[13678]|18\d)\d{8}|170[^346\D]\d{7})$/;

        if(target == 'login'){ //  如果是登录
            $.ajax({
                type: 'POST',
                data: {
                    email: $('input[name="email"]').val(),
                    _token:_token
                },
                url: postUrl,
                success: function (res) {
                    if (res.status) {
                      $('input[name="mobile"]').val(res.data.mobile);
                        sendCode(el,res.data.mobile);
                    } else {
                        toastr.error(res.msg);
                    }
                },
                error: function () {
                    toastr.error('账号验证失败');
                }
            })

        } else {
            var mobile = $('input[data-type=' + target + ']').val();
            if (mobile == ''){
                toastr.error('请输入手机号码');
                return
            }
            if (!mobileReg.test(mobile)) {
                toastr.error('请输入正确的手机号码');
            } else {
                sendCode(el,mobile);
            }
        }


    });

    //发送验证码方法
    function sendCode(el,mobile) {
        if (el.data('status') != 0) {
            return
        }
        el.text('正在发送...');
        el.data('status', '1');
        $.ajax({
            type: 'POST',
            data: {
                mobile: mobile,
                access_token: _token
            },
            url: AppUrl+'/api/sms/verify-code?_token='+_token,
            success: function (data) {
                if (data.success) {
                    $('input[name="access_token"]').val(_token);                    
                    var total = 60;
                    var message = '请等待{#counter#}秒';
                    el.text(message.replace(/\{#counter#}/g, total));
                    var timer = setInterval(function () {
                        total--;
                        el.text(message.replace(/\{#counter#}/g, total));

                        if (total < 1) {
                            el.data('status', '0');
                            el.text('发送验证码');
                            clearInterval(timer);
                        }
                    },1000)
                } else {
                    el.data('status', '0');
                    el.text('发送验证码');
                    toastr.error('短信发送失败！');
                }
            },
            error: function () {
                el.data('status', '0');
                el.text('发送验证码');
                toastr.error('短信发送失败！');
            }
        })
    };

});
