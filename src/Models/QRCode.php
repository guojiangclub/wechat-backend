<?php

/*
 * This file is part of ibrand/wechat-backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Backend\Models;

use iBrand\Shop\Backend\Model\Store;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

//use Prettus\Repository\Traits\TransformableTrait;

class QRCode extends Model
{
    use SoftDeletes;

    protected $table = 'we_qr_codes';

    protected $guarded = ['id'];

    public function Scna()
    {
        return $this->hasMany('\iBrand\Wechat\Backend\Models\Scan', 'ticket', 'ticket');
    }

    public function accounts()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function storelocator()
    {
        return $this->hasOne(Store::class, 'qr_code_id');
    }
}
