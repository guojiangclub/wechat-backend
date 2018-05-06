<?php

/*
 * This file is part of ibrand/wechat-backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Backend\Repository;

use iBrand\Wechat\Backend\Models\Card;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Card Repository.
 */
class CardRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Card::class;
    }
}
