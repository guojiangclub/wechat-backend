/**
 * Created by admin on 2017/1/4.
 */
(function() {
    $(document).ready(function () {

        //弹出添加关键词模态框
        $('#Add').on('click', function () {
            $('.confirm').data('id', '0');
            $('#AddTag .modal-title').text('添加关键词');
            $('#AddTag').modal('show');
        });

        //弹出添加回复模态框
        $('#Addreverce').on('click', function () {
            $('.confirmreverce').data('id', '0');
            $('#Addreverces .modal-title').text('添加回复');
            $('#Addreverces').modal('show');
        });
        //弹出添加标签模态框
        $('#Addlabel').on('click', function () {
            $('.labelname').data('id', '0');
            $('#Addlabels .modal-title').text('添加回复');
            $('#Addlabels').modal('show');
        });

        //弹出等级设置模拟框
        $('#Addgrade').on('click', function () {
            $('.gradename').data('id', '0');
            $('#Addgrades .modal-title').text('设置等级');
            $('#Addgrades').modal('show');
        });


        //添加关键词
        $('.confirm').on('click', function () {
            var tagName = $('.tag-name').val();
            if (tagName === '') {
                toastr.error('关键词名称不能为空');
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
                        window.doingPostGroup = false;
                    })
                }
            }
        });
        //添加回复
        $('.confirmreverce').on('click', function () {
            var tagName = $('.reverce-name').val();
            if (tagName === '') {
                toastr.error('回复不能为空');
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
                            reverce_name: tagName
                        }
                        var html = $('#reverceTable').html();
                        html = utils.convertTemplate(html, data);
                        $('#recTableTbody').append(html);
                        $('#Addreverces').modal('hide');
                        $('.reverce-name').val('');
                        window.doingPostGroup = false;

                    });
                } else {
                    $.post('http://localhost:8854/server/tag?id= ' + id, {
                        tagName: tagName
                    }, function (ret) {
                        var data = {
                            id: ret.id,
                            reverce_name: tagName
                        }
                        var html = $('#reverceTable').html();
                        html = utils.convertTemplate(html, data);
                        $('#recTableTbody').find("tr[data-id=" + id + "]").replaceWith(html);
                        $('#Addreverces').modal('hide');
                        $('.reverce-name').val('');
                        window.doingPostGroup = false;
                    })
                }
            }
        });
        //添加标签
        $('.labelname').on('click', function () {
            var tagName = $('.label-name').val();
            if (tagName === '') {
                toastr.error('标签不能为空');
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
                            labels_name: tagName
                        }
                        var html = $('#labelTable').html();
                        html = utils.convertTemplate(html, data);
                        $('#labelTableTbody').append(html);
                        $('#Addlabels').modal('hide');
                        $('.label-name').val('');
                        window.doingPostGroup = false;

                    });
                } else {
                    $.post('http://localhost:8854/server/tag?id= ' + id, {
                        tagName: tagName
                    }, function (ret) {
                        var data = {
                            id: ret.id,
                            labels_name: tagName
                        }
                        var html = $('#labelTable').html();
                        html = utils.convertTemplate(html, data);
                        $('#labelTableTbody').find("tr[data-id=" + id + "]").replaceWith(html);
                        $('#Addlabels').modal('hide');
                        $('.label-name').val('');
                        window.doingPostGroup = false;
                    })
                }
            }
        });
        //添加等级

        $('.gradename').on('click', function () {
            var tagName = $('#selects').val();
            if (tagName === '') {
                toastr.error('标签不能为空');
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
                            grade_name: tagName
                        }
                        var html = $('#gradeTable').html();
                        html = utils.convertTemplate(html, data);
                        $('#gradeTableTbody').html(html);
                        $('#Addgrades').modal('hide');
                        window.doingPostGroup = false;

                    });
                } else {
                    $.post('http://localhost:8854/server/tag?id= ' + id, {
                        tagName: tagName
                    }, function (ret) {
                        var data = {
                            id: ret.id,
                            grade_name: tagName
                        }
                        var html = $('#gradeTable').html();
                        html = utils.convertTemplate(html, data);
                        $('#gradeTableTbody').find("tr[data-id=" + id + "]").replaceWith(html);
                        $('#Addgrades').modal('hide');
                        window.doingPostGroup = false;
                    })
                }
            }
        });




        //修改关键词
        $('body').on('click', '.compile', function () {
            // debugger
            var tr = $(this).parents('tr');
            var id = tr.data('id');
            var name = tr.data('name');
            $('.confirm').data('id', id);
            $('.tag-name').val(name);
            $('#AddTag .modal-title').text('修改关键词');
            $('#AddTag').modal('show');
        });

        //删除关键词
        $('body').on('click', '.delete', function () {
            var tr = $(this).parents('tr');
            var id = tr.data('id');
            removeTags([id], $('#tagTableTbody'));
        });

        //删除回复
        $('body').on('click', '.reverce-delete', function () {
            var tr = $(this).parents('tr');
            var id = tr.data('id');
            removeTags([id],$('#recTableTbody'));
        });


        //删除标签
        $('body').on('click', '.label-delete', function () {
            var tr = $(this).parents('tr');
            var id = tr.data('id');
            removeTags([id],$('#labelTableTbody'));
        });
        //删除等级
        $('body').on('click', '.grade-delete', function () {
            var tr = $(this).parents('tr');
            var id = tr.data('id');
            removeTags([id],$('#gradeTableTbody'));
        });

        function removeTags(idList,names) {
            $.post('http://localhost:8854/server/tag', {
                ids: idList
            }, function (ret) {
                for (var i = 0; i < idList.length; i++) {
                    var id = idList[i];
                    names.find("tr[data-id=" + id + "]").remove();
                }
            });
        }


    })
}());