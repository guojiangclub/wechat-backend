
<div id="instationMaterial" style="display: none">
    <div class="controls">
        <a class="check-item" id="text-checkbox">
            <input type="radio" name="radio" id="checkbox-text" data-type="1" >
            <label for="checkbox-1">
                文本
            </label>
        </a>
        <a class="check-item">
            <input type="radio" name="radio" id="checkbox-image" data-type="2" checked >
            <label for="checkbox-2">
                图片
            </label>
        </a>
        <a class="check-item">
            <input type="radio" name="radio" id="checkbox-article" data-type="3" >
            <label for="checkbox-3">
            图文
            </label>
        </a>
        {{--<a class="check-item">--}}
            {{--<input type="radio" name="radio" id="checkbox-4" data-href="voice">--}}
            {{--<label for="checkbox-4">--}}
            {{--语音--}}
            {{--</label>--}}
        {{--</a>--}}
        <a class="check-item">
            <input type="radio" name="radio" id="checkbox-video" data-type="4" >
            <label for="checkbox-5">
            视频
            </label>
        </a>
        </div>

        <div class="form-group" style="height: 99px;">
            <div class="col-sm-8 m_type m_type_text" id="m_type_1" style="position: relative">
                <br>
                {{ Widget::run('OneMaterial','','text') }}
                <textarea name="" id="" disabled style="width: 300px;height: 200px" v-if="type=='text'&&data_text&&selected?true:false">{#data_text#}</textarea>
                <i class="fa fa-times-circle" id="delImg" style="font-size: 20px;position: absolute;left:295px;" @click="delData()" v-if="type=='text'&&data_text&&selected?true:false"></i>
            </div>
            <div class="col-sm-8 m_type m_type_image" id="m_type_2" style="display: none" >
                <br>
                {{ Widget::run('OneMaterial','','image') }}
            </div>
            <div class="col-sm-8 m_type m_type_article" id="m_type_3"  style="display: none">
                <br>
                {{ Widget::run('OneMaterial','','article') }}
                </div>
            </div>
            <div class="col-sm-8 m_type m_type_video" id="m_type_4"  style="display: none">
                <br>
                {{ Widget::run('OneMaterial','','video') }}
                </div>
            </div>

        </div>

</div>







