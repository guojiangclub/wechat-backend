(function () {
    $(document).ready(function () {
        /* **************************** 分组模块 ********************************** */
        //获取焦点
        $('#AddGroup').on('shown.bs.modal', function () {
            $('.group-name')[0].focus();
        });

        //弹出分组模态框
        $('#add-group-button').on('click', function () {
            $('.confirm').data('id', '0');
            $('#AddGroup .modal-title').text('添加分组');
            $('#AddGroup').modal('show');
        });

        //添加分组
        $('.confirm').on('click', function () {
            var groupName = $('.group-name').val();
            if (groupName === '') {
                toastr.error('分组名称不能为空');
            } else {
                if (window.doingPostGroup) return;
                window.doingPostGroup = true;
                var id = $(this).data('id');
                if (id == 0) {
                    $.post('http://localhost:8854/server/group', {
                        groupName: groupName
                    }, function (ret) {
                        var data = {
                            id: ret.id,
                            num: ret.num,
                            group: groupName
                        }
                        var html = $('#fans-group').html();
                        html = utils.convertTemplate(html, data);
                        $('#group-ul').append(html);
                        $('#AddGroup').modal('hide');
                        $('.group-name').val('');
                        window.doingPostGroup = false;
                    });
                } else {
                    $.post('http://localhost:8854/server/group?id=' + id, {
                        groupName: groupName
                    }, function (ret) {
                        var data = {
                            id: ret.id,
                            num: ret.num,
                            group: groupName
                        }
                        var html = $('#fans-group').html();
                        html = utils.convertTemplate(html, data);
                        $('#group-ul').find("li[data-id=" + id + "]").replaceWith(html);
                        $('#AddGroup').modal('hide');
                        $('.group-name').val('');
                        window.doingPostGroup = false;
                    });
                }
            }
        });
        
        //修改组名
        $('body').on('click', '.compile',function () {
            var li = $(this).parents('li');
            var id = li.data('id');
            var name = li.data('group');
            $('.confirm').data('id', id);
            $('.group-name').val(name);
            $('#AddGroup .modal-title').text('修改分组');
            $('#AddGroup').modal('show');
        });

        //删除组名
        $('body').on('click', '.delete', function () {
            var li = $(this).parents('li');
            var id = li.data('id');
            $.post('http://localhost:8854/server/group?id=' + id,
                function (ret) {
                    $('#group-ul').find("li[data-id=" + id + "]").remove();
                    window.doingPostGroup = false;
                });
        });

        //切换分组
        $('body').on('click', '#group-ul li', function () {
            $(this).addClass('pitch');
            $(this).prevAll().removeClass('pitch');
            $(this).nextAll().removeClass('pitch');
            var id = $(this).data('id');
            getUsers({
                group_id: id,
                page: 1
            })
        });

        /* **************************** 用户列表模块 ********************************** */
        function getUsers(options) {
            options = options || {};
            var group_id = options.group_id || 0;
            var page = options.page || 1;
            var sort = options.sort || 'time';
            var search = options.search || '';
            var query = '?group=' + group_id + '&page=' + page + '&sort=' + sort + '&search=' + search;
            var url = 'http://localhost:8854/server/users' + query;
            $.get(url, function (ret) {
                var el = $('.user-list');
                var template = $('#user-list').html();
                var users = ret.users;
                var html = '';
                users.forEach(function (user) {
                    html += utils.convertTemplate(template, user);
                });
                el.html(html);
                var total = ret.pages.total;
                var current = ret.pages.current;
                var html = utils.paging(total, current);
                $('.pagination').html(html);
                window.history.replaceState(null, '', query)
            });
        };

        getUsers();
        //选中用户
        $('body').on('click', '.user-info-box', function () {
            $(this).toggleClass('opt');
        });
        //全选
        $('#all').on('ifChecked', function () {
            $('.user-info-box').addClass('opt');
        });

        //取消全选
        $('#all').on('ifUnchecked', function () {
            $('.user-info-box').removeClass('opt');
        });

        //设置用户组
        $('#set-group-button').on('click', function () {
            if ($('.user-info-box').hasClass('opt')) {
                var url = 'http://localhost:8854/server/groups';
                var el = $('.set-group');
                var template = $('#set-group').html();
                $.get(url, function (ret) {
                    var groups = ret.groups;
                    groups.forEach(function (group) {
                        var html = utils.convertTemplate(template, group);
                        el.append(html);
                    })
                });
                $('#SetGroup').modal('show');
            } else {
                toastr.error('请选择用户');
            }
        });
        $('#submit-set-group-info').on('click', function () {
            var user_id = [];
            var group_id = $('.set-group').val();
            $('.opt').each(function () {
                user_id.push($(this).data('id'));
            });
            $.post('http://localhost:8854/server/group', {
                userIdList: user_id,
                groupId: group_id
            }, function () {
                toastr.success('设置成功');
                $('#SetGroup').modal('hide');
                $('.user-info-box').removeClass('opt');
                $('#all').iCheck('uncheck');
            })
        });

        //设置标签
        $('#set-label-button').on('click', function () {
            if ($('.user-info-box').hasClass('opt')) {
                var url = 'http://localhost:8854/server/groups';
                var el = $('.set-label');
                var template = $('#set-group').html();
                $.get(url, function (ret) {
                    var groups = ret.groups;
                    groups.forEach(function (group) {
                        var html = utils.convertTemplate(template, group);
                        el.append(html);
                    })
                });
                $('#SetLabel').modal('show');
            } else {
                toastr.error('请选择用户');
            }
        });
        $('#submit-set-label-info').on('click', function () {
            var user_id = [];
            var group_id = $('.set-label').val();
            $('.opt').each(function () {
                user_id.push($(this).data('id'));
            });
            $.post('http://localhost:8854/server/group', {
                userIdList: user_id,
                groupId: group_id
            }, function () {
                var tag_text = $('.set-label').find("option:selected").text();

                $('.opt').find('.tag').text(tag_text);

                toastr.success('设置成功');
                $('#SetLabel').modal('hide');
                $('.user-info-box').removeClass('opt');
                $('#all').iCheck('uncheck');
            })
        });

        //排序
        $('.select-time').on('change', function () {
            var options = $(this).val();
            getUsers({
                sort: options
            });
        });

        //搜索
        $('#search').on('click', function () {
            var text = $('.search-input').val().trim();
            getUsers({
                search: text
            });
        });

        //分页
        $('body').on('click', '.pagination li', function () {
            var page = $(this).data('page');
            getUsers({
                id: 0,
                page: page
            });
        });
    });
}());