<?php

namespace iBrand\Wechat\Backend\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class LandPage extends Model
{
    use SoftDeletes;

    protected $table = 'we_land_page';

    protected $guarded = ['id'];

    public function getCardAttribute()
    {
        $cardTitle = '';
        foreach ($this->card_id as $item)
        {
            $card = Card::find($item);
            $cardTitle = $cardTitle. '<br>' . $card->title;
        }

        return $cardTitle;
    }

    public function getCardIdAttribute($value)
    {
        return explode(',', $value);
    }

    public function setCardIdAttribute($value)
    {
        $this->attributes['card_id'] = implode(',', $value);
    }


}
