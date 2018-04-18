<div class="form-group">
    {!! Form::label('cost_money_unit','消费金额。以分为单位：', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-9">
        <input type="text" class="form-control" name="especial[bonus_rule][cost_money_unit]" placeholder="" value="100">
    </div>
</div>

<div class="form-group">
    {!! Form::label('increase_bonus','对应增加的积分：', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-9">
        <input type="text" class="form-control" name="especial[bonus_rule][increase_bonus]" placeholder="" value="1">
    </div>
</div>

<div class="form-group">
    {!! Form::label('reduce_money','抵扣xx元（以分为单位）：', ['class' => 'col-lg-2 control-label']) !!}
    <div class="col-lg-9">
        <input type="text" class="form-control" name="especial[bonus_rule][reduce_money]" placeholder="" value="1">
    </div>
</div>