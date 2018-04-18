$(document).ready(function () {
    if ([1, 0].sort(function(a, b){ return a > b }).toString() !== '0,1') {
        Array.prototype._sort = Array.prototype.sort;
        Array.prototype.sort = function(callback) {
            if (typeof callback !== 'function') {
                return this._sort();
            } else {
                return this._sort(function() {
                    var ret = callback.apply(null, arguments);
                    if (ret === true) {
                        ret = 1;
                    } else if (ret === false) {
                        ret = -1;
                    }

                    return ret;
                })
            }
        };
    }


    // 该数据为模拟数据, 需要从服务端获取
    var app = window.skuBuilder = {};
    // app.init();

    var skuList = app.skuList = {};                 // 最终的sku列表数据, 如果有sku值则为修改, 否则为新加
    var specList = app.specList = {};               // 规格列表选择数据
    var selections = app.selections = [];           // 所有选中的规格
    var batchInputs = app.batchInputs = {};         // 批量输入的数据

    app.saveData = function () {
        if (this.submiting) return;
        this.submiting = true;

        // 整理数据
        var data = {};

        // 提交数据
    };

    app.bindEvent = function () {
        var body = $('body');

        $('#sku-builder input:checkbox').on('ifToggled', function () {
            // debugger;
            var el = $(this);
            var uuid = el.data('uuid');
            if (!uuid) return;

            var parts = uuid.split('-');
            var check = el.is(':checked');
            var ready = true;
            for (var i=0, l=selections.length; i<l; i++) {
                var sel = selections[i];
                if (sel.id == parts[0]) {
                    if (check) {
                        sel.count++;
                        sel.list[parts[1]] = specList[uuid];
                    } else {
                        sel.count--;
                        delete sel.list[parts[1]];
                    }
                }
                if (sel.count === 0) ready = false;
            }

            app.updateImages();

            if (ready) {
                app.createTable();
            } else {
                app.clearTable();
            }
        });

        $('#save-sku').on('click', function () {
            app.saveData();
        });

        body.on('input propertychange', 'input[data-action=save]', function () {
            var el = $(this);
            var spec = el.parents('tr').data('spec');
            var name = el.data('name');
            var value = el.val();
            saveInput(spec, name, value);
        });

        body.on('input propertychange', 'input[data-action=batch]', function () {
            var el = $(this);
            var name = el.data('name');
            var value = el.val();

            batchInputs[name] = value;

            $('input[data-action=save][data-name=' + name + ']').each(function () {
                var $this = $(this);
                var spec = $this.parents('tr').data('spec');
                $this.val(value);

                saveInput(spec, name, value);
            });
        });

        body.on('input propertychange', 'input[data-action=update]', function () {
            var el = $(this);
            var id = el.data('id');
            var sid = el.data('sid');
            var value = el.val();

            specList[sid+ '-' + id].alias = value;
            $('[data-action=update-' + id + ']').text(value);
        });

        body.on('click', 'input[data-action=is_show]', function () {
            var el = $(this);
            var value = el.val() === '不启用' ? '启用' : '不启用';
            el.val(value);

            var spec = el.parents('tr').data('spec');
            var name = 'is_show';
            saveInput(spec, name, value);
        });

        body.on('change', 'input[name=upload_image]', function () {
            var el = $(this);
            var id = el.parents('tr').data('id');
            var sid= el.parents('tr').data('sid');
            var file = this.files[0];
            var form = new FormData();
            form.append('id', id);
            form.append('upload_image', file);

            $.ajax({
                url: postImgUrl,
                type: 'POST',
                data: form,
                dataType: 'JSON',
                cache: false,
                processData: false,
                contentType: false
            }).done(function(ret) {
                var url = ret.url;
                el.parents('tr').find('.block:first').html('<img width="50" src="' + url + '"><input type="hidden" name="spec_img['+ id +']" value="' + url + '">').removeClass('hidden');
                specList[sid+ '-' + id].image = url;

            }).fail(function () {

            });
        });

        function saveInput(spec, name, value) {
            skuList[spec] = skuList[spec] || {};
            skuList[spec][name] = value;
        }
    };

    var img_template = $('#template-img-tr').html();
    app.updateImages = function () {
        for (var i=0,l=selections.length;i<l;i++) {
            var sel = selections[i];
            if (sel.type == 2) {
                var tmpl = img_template;
                var html = '';
                for (var k in sel.list) {
                    if (!sel.list.hasOwnProperty(k)) continue;
                    // sel.list[k].block
                    if (sel.list[k].image) {
                        sel.list[k].class = '';
                        sel.list[k].imgTag = '<img width="50" src="' + sel.list[k].image +'"><input type="hidden" name="spec_img['+sel.list[k].id+']" value="' + sel.list[k].image +'">';
                    } else {
                        sel.list[k].class = ' hidden';
                    }

                    html += utils.convertTemplate(tmpl, sel.list[k], '');
                }

                var img_table = $('#image-table tbody');
                img_table.html(html);

                break;
            }
        }
    };

    var sku_table = $('#sku-table tbody');
    var sku_header = $('#sku-table thead tr').html();
    var sku_template = $('#template-sku-tr').html();
    app.clearTable = function () {
        sku_table.empty();
    };

    app.createTable = function () {
        var array = [];
        for (var i=0,l=selections.length;i<l;i++) {
            var sel = selections[i];
            var data = [];
            for (var k in sel.list) {
                if (!sel.list.hasOwnProperty(k)) continue;
                data.push(sel.list[k]);
            }
            array.push(data);
        }

        var html = this.createRows(array);
        sku_table.html(html);
    };

    app.createRows = function (array) {
        var tmpl = sku_template;
        var html = '';
        var rows = Cartesian(array);
        for (var i=0,p=rows.length; i<p; i++) {
            var rowHtml = '';
            var sku_ids = [];
            for (var j=0,q=rows[i].length; j<q; j++) {
                var count = 1;
                var item = rows[i][j];
                if (i===0 || rows[i-1][j].id !== item.id) {
                    for (var k=i+1;k<p;k++) {
                        if (rows[k][j].id === item.id) {
                            count++;
                        } else {
                            break;
                        }
                    }
                } else {
                    count = 0;
                }

                if (count) {
                    var text;
                    if (item.color) {
                        text = createColorBlock(item);
                    } else {
                        text = item.value;
                    }

                    rowHtml += '<td rowspan="' + count + '">' + text + '</td>';
                }

                sku_ids.push(item.id);
            }

            var spec = sku_ids.sort(order).join('-');
            skuList[spec] = skuList[spec] || {};

            var data = Object.assign({is_show: '不启用'}, skuList[spec], batchInputs);
            data.index = i;
            data.spec = spec;

            html += '<tr data-spec="' + spec + '">' + rowHtml + utils.convertTemplate(tmpl, data, '') + '</tr>';
        }

        return html;
    };

    app.loadData = function (res, callback) {
        var specs = res.specs || [];
        var skus = res.skus || {
                skuData: [],
                specData: {}
            };

        var header = '';
        var hasImage = false;
        var listHtml = '';
        var listTmpl = $('#template-spec-list').html();
        var itemTmpl = $('#template-spec').html();
        for (var i=0,l=specs.length; i<l; i++) {
            var sid = specs[i].id;
            var type = specs[i].type;
            var list = specs[i].list;
            var label = specs[i].label;

            var selItem = {
                id: sid,
                type: type,
                list: {},
                count: 0
            };

            header += '<th>' + label + '</th>';

            var html = '';
            for (var k=0,n=list.length; k<n; k++) {
                var id = list[k].id;
                var check = !!skus.specData[id];
                if (check) {
                    list[k] = Object.assign(list[k], skus.specData[id], {checked: 'checked'});

                    selItem.count++;
                    selItem.list[id] = list[k];
                }

                specList[sid + '-' + id] = list[k];
                var block = createColorBlock(list[k], true) || createNormalText(list[k]);
                var data = Object.assign(list[k], {sid: sid, block: block});

                html += utils.convertTemplate(itemTmpl, data, '');
            }

            var specItem = Object.assign(specs[i], {html: html});
            listHtml += utils.convertTemplate(listTmpl, specItem, '');

            if (type == 2) hasImage = true;

            selections.push(selItem);
        }

        if (hasImage) {
            listHtml += $('#template-img-table').html();
        }

        $('#sku-table thead tr').html(header + sku_header);

        $('#module-specs').html(listHtml);

        for (var j=0,m=skus.skuData.length; j<m; j++) {
            var spec = skus.skuData[j].specID.sort(order).join('-');
            skuList[spec] = skus.skuData[j];
        }

        if (callback && typeof callback === 'function') callback();
    };

    app.init = function (data) {
        this.skuList = skuList = {};                 // 最终的sku列表数据, 如果有sku值则为修改, 否则为新加
        this.specList = specList = {};               // 规格列表选择数据
        this.selections = selections = [];           // 所有选中的规格
        this.batchInputs = batchInputs = {};         // 批量输入的数据

        var that = this;
        this.loadData(data, function () {
            // $.iCheck({
            //     checkboxClass: 'icheckbox_flat-green',
            //     prefix: 'spec'
            // });

            $('#module-specs').find("input").iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
                increaseArea: '20%'
            });

            var ready = true;
            for (var i=0,l=selections.length; i<l; i++) {
                if (selections[i].count === 0) {
                    ready = false;
                    break;
                }
            }

            if (ready) {
                that.createTable();
                that.updateImages();
            }

            that.bindEvent();
        });
    };

    // 创始色块
    function createColorBlock(item, unlink) {
        if (item.color && item.id && item.value) {
            if (unlink) {
                return '<span class="color-block" style="background-color: #' + item.color.replace('#', '') + '"></span>' + item.value;
            }
            return '<span class="color-block" style="background-color: #' + item.color.replace('#', '') + '"></span>' +
                '<span data-action="update-' + item.id + '">' + (item.alias || item.value) + '</span>';
        } else {
            return ''
        }
    }

    function createNormalText(item) {
        if (item.id && item.value) {
            return '<span data-action="update-' + item.id + '">' + item.value + '</span>';
        } else {
            return '';
        }
    }

    // 追加并创建新数组
    function combine(a, b) {
        if (!(a instanceof Array)) {
            a = [a];
        }
        return a.concat(b);
    }
    //笛卡尔积
    function cartesian(a, b) {
        var ret = [];
        for (var i=0;i<a.length;i++) {
            for (var j=0;j<b.length;j++) {
                ret.push(combine(a[i], b[j]));
            }
        }
        return ret;
    }
    //多个一起做笛卡尔积
    function Cartesian(data){
        var len = data.length;
        switch (len) {
            case 0:
                return [];
            case 1:
                return data[0];
            default:
                var r = data[0];
                for (var i=1;i<len;i++) {
                    r = cartesian(r, data[i]);
                }
                return r;
        }
    }

    //比较数字大小
    function order(a, b) {
        return Number(a) > Number(b);
    }
});
