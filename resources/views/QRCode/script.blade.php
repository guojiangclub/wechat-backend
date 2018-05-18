<script>
    new Vue({
	    delimiters: ['{#', '#}'],
	    el: '#app',
	    data: {
		    type: 2,
		    editId: '',
		    loading: true,
		    name: '',
		    key: '',
		    expire_seconds: 2592000,
		    scene_str: ''
	    },
	    methods: {
		    getData: function () {
//                console.log(this.type);
		    },

		    store: function () {
			    var that = this;
			    if (that.name == "") {
				    toastr.error('请输入场景名称');
				    return;
			    }
			    if (that.type == 1 && that.expire_seconds == "") {
				    toastr.error('请输入过期时间');
				    return;
			    }
			    if (parseInt(that.expire_seconds) > 2592000 || parseInt(that.expire_seconds) < 60) {
				    toastr.error('过期时间60-2592000正整数');
				    return;
			    }

			    console.log(parseInt(that.expire_seconds));
			    if (that.type == 2 && that.scene_str == "") {
				    toastr.error('请输入场景值');
				    return;
			    }

			    var data = {
				    '_token': that._token,
				    'name': that.name,
				    'key': that.key,
			    }


			    if (editId == "") {
				    var url = storeApi;
			    } else {
				    var url = decodeURIComponent(updateApi).replace('#', parseInt(editId));
				    data.id = parseInt(editId);
			    }

			    switch (that.type) {
				    case 2:
					    data.scene_str = that.scene_str;
					    data.type = 2;
					    break;

				    case 1:
					    data.expire_seconds = that.expire_seconds;
					    data.type = 1;
					    break;
			    }

			    if(!data.key){
                    data.key='';
                }

                $.ajax({
				    type: "post",
				    url: url,
				    data: data,
				    success: function (res) {
					    if (res.status) {
						    swal({
							    title: "保存成功",
							    text: "",
							    type: "success"
						    }, function () {
							    location = decodeURIComponent(CodesList).replace('#', data.type) + "?type=" + data.type;
							    {{--$.pjax({url: '{{route('admin.wechat.QRCode.index')}}', container: '#pjax-container'})--}}
						    });
					    }
				    }
			    });
		    },


		    getEdit: function (id) {
			    var url = decodeURIComponent(editGetDataUrl).replace('#', id);
			    var that = this;
			    that.data = [];
			    $.ajax({
				    type: "get",
				    url: url,
				    success: function (res) {
					    if (res.status) {
						    that.type = res.data.type;
						    that.name = res.data.name;
						    that.key = res.data.key;
						    if (res.data.type == 2) {
							    that.scene_str = res.data.scene_str;
						    }
						    if (res.data.type == 1) {
							    that.expire_seconds = res.data.expire_seconds;
						    }

					    }
				    }
			    });
		    },


		    switchType: function (type) {
			    $('.type-radio input').iCheck('uncheck');
			    $('.type-radio .input' + type).iCheck('check');
			    this.type = type;
		    },

		    start: function () {
                var _token=window._token;
			    this._token = _token;
			    this.editId = editId;
			    if (editId !== "") {
				    this.getEdit(editId);
			    }
			    this.getData();
			    $('.data-show').show();
		    }
	    },

	    mounted() {
		    this.start();
	    }

    })
</script>




