(function() {
    $(document).ready(function () {

        //全选
        $('#CheckAll').on('ifChecked', function(event){
            $('.check-item').iCheck('check');
        });

        //取消全选
        $('#CheckAll').on('ifUnchecked', function(event){
            $('.check-item').iCheck('uncheck');
        });

        //弹出添加标签模态框
        $('#Add').on('click', function () {
            $('.confirm').data('id', '0');
            $('#AddTag .modal-title').text('添加标签');
            $('#AddTag').modal('show');
        });

        //添加标签
        $('.confirm').on('click', function () {
            var tagName = $('.tag-name').val();
            if (tagName === '') {
                toastr.error('分组名称不能为空');
            } else {
                if (window.doingPostGroup) return;
                window.doingPostGroup = true;
                var id = $(this).data('id');
                if (id == 0) {
                    $.post('http://localhost:8854/server/tag', {
                        tagName: tagName
                    }, function (ret) {
                        var data = {
                            id: ret.id,
                            tag_name: tagName
                        }
                        var html = $('#tagTable').html();
                        html = utils.convertTemplate(html, data);
                        $('#tagTableTbody').append(html);
                        $('#AddTag').modal('hide');
                        $('.tag-name').val('');

                        $('.check-item').iCheck({
                            checkboxClass: 'icheckbox_flat-green',
                            increaseArea: '20%' // optional
                        });
                        window.doingPostGroup = false;

                    });
                } else {
                    $.post('http://localhost:8854/server/tag?id= ' + id, {
                        tagName: tagName
                    }, function (ret) {
                        var data = {
                            id: ret.id,
                            tag_name: tagName
                        }
                        var html = $('#tagTable').html();
                        html = utils.convertTemplate(html, data);
                        $('#tagTableTbody').find("tr[data-id=" + id + "]").replaceWith(html);
                        $('#AddTag').modal('hide');
                        $('.group-name').val('');

                        $('.check-item').iCheck({
                            checkboxClass: 'icheckbox_flat-green',
                            increaseArea: '20%' // optional
                        });

                        window.doingPostGroup = false;
                    })
                }
            }
        });

        //修改标签名
        $('body').on('click', '.compile', function () {
            // debugger
            var tr = $(this).parents('tr');
            var id = tr.data('id');
            var name = tr.data('name');
            $('.confirm').data('id', id);
            $('.tag-name').val(name);
            $('#AddTag .modal-title').text('修改分组');
            $('#AddTag').modal('show');
        });

        //删除标签
        $('body').on('click', '.delete', function () {
            var tr = $(this).parents('tr');
            var id = tr.data('id');
            removeTags([id]);
        });
        $('#Delete').on('click', function () {
            var idList =[];
            $('.check-item').each(function () {
                if ($(this).is(':checked')) {
                    var id = $(this).parents('tr').data('id');
                    idList.push(id);
                }
            });

            if (!idList.length) {
                return toastr.error('请选择标签');
            }
            removeTags(idList);
        });
        function removeTags(idList) {
            $.post('http://localhost:8854/server/tag', {
                ids: idList
            }, function (ret) {
                for (var i = 0; i < idList.length; i++) {
                    var id = idList[i];
                    $('#tagTableTbody').find("tr[data-id=" + id + "]").remove();
                }
                $('#CheckAll').iCheck('uncheck');
            });
        }

        //搜索标签
        $('#search').on('click', function () {
            var text = $('.search-input').val().trim();
            $.post('http://localhost:8854/server/tag', {
                search: text
            }, function (ret) {
                var taglist = ret.tags;
                var html = '';
                taglist.forEach(function (tags) {
                    html += utils.convertTemplate(template, tags);
                })
                $('#tagTableTbody').html(html);

                $('.check-item').iCheck({
                    checkboxClass: 'icheckbox_flat-green',
                    increaseArea: '20%' // optional
                });
                window.doingPostGroup = false;

            });
        });
    })
}());