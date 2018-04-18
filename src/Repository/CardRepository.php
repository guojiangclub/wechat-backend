<?php

namespace iBrand\Wechat\Backend\Repository;

use App\Exceptions;
use iBrand\Wechat\Backend\Models\Card;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Card Repository.
 */
class CardRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Card::class;
    }






}
