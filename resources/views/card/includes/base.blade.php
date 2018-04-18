<div class="form-group">
    {!! Form::label('name','会员卡类型：', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-9">
        <select class="form-control" name="card_type">
            <option value="MEMBER_CARD">MEMBER_CARD</option>
        </select>
    </div>
</div>

<div class="form-group">
    {!! Form::label('name','会员卡背景图：', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-9">
        <input type="text" class="form-control" name="background_pic_url" placeholder="">
    </div>
</div>


<div class="form-group">
    {!! Form::label('logo_url','Logo：', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-9">
        <input type="text" class="form-control" name="base_info[logo_url]" placeholder="">
    </div>
</div>

<div class="form-group">
    {!! Form::label('brand_name','品牌名称(brand_name)：', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-9">
        <input type="text" class="form-control" name="base_info[brand_name]"  placeholder="">
    </div>
</div>

<div class="form-group">
    {!! Form::label('code_type','Code展示类型(code_type)：', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-9">
        <select class="form-control" name="base_info[code_type]">
            <option value="CODE_TYPE_TEXT">文本</option>
            <option value="CODE_TYPE_BARCODE" selected>一维码</option>
            <option value="CODE_TYPE_QRCODE">二维码</option>
            <option value="CODE_TYPE_ONLY_QRCODE">仅显示二维码</option>
            <option value="CODE_TYPE_ONLY_BARCODE">仅显示一维码</option>
            <option value="CODE_TYPE_NONE">不显示任何码型</option>
        </select>
    </div>
</div>

<div class="form-group">
    {!! Form::label('title','卡券名(title)：', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-9">
        <input type="text" class="form-control" name="base_info[title]"  placeholder="">
    </div>
</div>

<div class="form-group">
    {!! Form::label('color','券颜色(color)：', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-9">
        <input type="text" class="form-control" name="base_info[color]"  placeholder="" value="Color100">
    </div>
</div>

<div class="form-group">
    {!! Form::label('notice','卡券使用提醒(notice)：', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-9">
        <input type="text" class="form-control" name="base_info[notice]"  placeholder="" value="使用时向店员出示此券">
    </div>
</div>

<div class="form-group">
    {!! Form::label('description','卡券使用说明(description)：', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-9">
        <input type="text" class="form-control" name="base_info[description]"  placeholder="" value="全国VIPeak门店及官方商城可使用会员卡积分 在门店内购物时，请在结账前向店员出示会员卡累积积分">
    </div>
</div>

<div class="form-group">
    {!! Form::label('service_phone','客服电话(service_phone)：', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-9">
        <input type="text" class="form-control" name="base_info[service_phone]"  placeholder="" value="4008907600">
    </div>
</div>

<div class="form-group">
    {!! Form::label('sku','卡券库存的数量(quantity)：', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-9">
        <input type="text" class="form-control" name="base_info[sku][quantity]"  placeholder="上限为100000000" value="">
    </div>
</div>

<div class="form-group">
    {!! Form::label('get_limit','每人限领数量(get_limit)：', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-9">
        <input type="text" class="form-control" name="base_info[get_limit]" value="1">
    </div>
</div>

<div class="form-group">
    {!! Form::label('custom_url_name','自定义跳转名称(custom_url_name)：', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-9">
        <input type="text" class="form-control" name="base_info[custom_url_name]" value="适用门店">
        <input type="text" class="form-control" name="base_info[custom_url_sub_title]" placeholder="提示语" value="距离最近">
    </div>
</div>

<div class="form-group">
    {!! Form::label('custom_url','自定义跳转URL(custom_url)：', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-9">
        <input type="text" class="form-control" name="base_info[custom_url]" value="http://www.thenorthface.com.cn/store/">
    </div>
</div>