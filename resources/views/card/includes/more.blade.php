<div class="form-group">
    {!! Form::label('supply_bonus','显示积分(supply_bonus)：', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-9">
        <select class="form-control" name="especial[supply_bonus]">
            <option value="1">true</option>
            <option value="0" selected>false</option>
        </select>
        <input type="text" class="form-control" name="especial[bonus_url]" placeholder="请输入移动端积分页面链接" value="">
    </div>
</div>

<div class="form-group">
    {!! Form::label('supply_balance','是否支持储值(supply_balance)：', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-9">
        <select class="form-control" name="especial[supply_balance]">
            <option value="0">false</option>
        </select>
    </div>
</div>

<div class="form-group">
    {!! Form::label('prerogative','特权说明(prerogative)：', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-9">
        <textarea class="form-control" name="especial[prerogative]">折以上货品，消费1元获得1积分</textarea>
    </div>
</div>

<div class="form-group">
    {!! Form::label('custom_field1','会员信息类目,激活后显示(custom_field1)：', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-9">
        <select class="form-control" name="especial[custom_field1][name_type]">
            <option value="FIELD_NAME_TYPE_LEVEL">等级</option>
            <option value="FIELD_NAME_TYPE_COUPON">优惠券</option>
            <option value="FIELD_NAME_TYPE_STAMP">印花</option>
            <option value="FIELD_NAME_TYPE_DISCOUNT">折扣</option>
            <option value="FIELD_NAME_TYPE_ACHIEVEMEN">成就</option>
            <option value="FIELD_NAME_TYPE_MILEAGE">里程</option>
            <option value="FIELD_NAME_TYPE_SET_POINTS">集点</option>
            <option value="FIELD_NAME_TYPE_TIMS" selected>次数</option>
        </select>
        <input type="text" class="form-control" name="especial[custom_field1][name]" placeholder="名称" value="积分">
        <input type="text" class="form-control" name="especial[custom_field1][url]" placeholder="请输入移动端积分页面链接" value="">
    </div>
</div>

<div class="form-group">
    {!! Form::label('custom_field1','会员信息类目,激活后显示(custom_field2)：', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-9">
        <select class="form-control" name="especial[custom_field2][name_type]">
            <option value="FIELD_NAME_TYPE_LEVEL">等级</option>
            <option value="FIELD_NAME_TYPE_COUPON">优惠券</option>
            <option value="FIELD_NAME_TYPE_STAMP">印花</option>
            <option value="FIELD_NAME_TYPE_DISCOUNT">折扣</option>
            <option value="FIELD_NAME_TYPE_ACHIEVEMEN">成就</option>
            <option value="FIELD_NAME_TYPE_MILEAGE">里程</option>
            <option value="FIELD_NAME_TYPE_SET_POINTS">集点</option>
            <option value="FIELD_NAME_TYPE_TIMS">次数</option>
        </select>
        <input type="text" class="form-control" name="especial[custom_field2][name]" placeholder="名称" value="等级">
        <input type="text" class="form-control" name="especial[custom_field2][url]" placeholder="请输入移动端VIPEAK会员权益页面链接" value="">
    </div>
</div>

<div class="form-group">
    {!! Form::label('custom_field1','会员信息类目,激活后显示(custom_field3)：', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-9">
        <select class="form-control" name="especial[custom_field3][name_type]">
            <option value="FIELD_NAME_TYPE_LEVEL">等级</option>
            <option value="FIELD_NAME_TYPE_COUPON" selected>优惠券</option>
            <option value="FIELD_NAME_TYPE_STAMP">印花</option>
            <option value="FIELD_NAME_TYPE_DISCOUNT">折扣</option>
            <option value="FIELD_NAME_TYPE_ACHIEVEMEN">成就</option>
            <option value="FIELD_NAME_TYPE_MILEAGE">里程</option>
            <option value="FIELD_NAME_TYPE_SET_POINTS">集点</option>
            <option value="FIELD_NAME_TYPE_TIMS">次数</option>
        </select>
        <input type="text" class="form-control" name="especial[custom_field3][name]" placeholder="名称" value="优惠券">
        <input type="text" class="form-control" name="especial[custom_field3][url]" placeholder="请输入移动端优惠券页面链接" value="">
    </div>
</div>

<div class="form-group">
    {!! Form::label('activate_url','激活会员卡的url(activate_url)', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-9">
        <input type="text" class="form-control" name="especial[activate_url]" placeholder="请输入移动端会员卡激活页面链接" value="">
    </div>
</div>

<div class="form-group">
    {!! Form::label('custom_cell1','自定义会员信息类目，会员卡激活后显示(custom_cell1)：', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-9">
        <input type="text" class="form-control" name="especial[custom_cell1][name]" placeholder="名称" value="官方商城">
        <input type="text" class="form-control" name="especial[custom_cell1][tips]" placeholder="提示语">
        <input type="text" class="form-control" name="especial[custom_cell1][url]" placeholder="请输入移动端商城首页链接">
    </div>
</div>
