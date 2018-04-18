<?php

namespace iBrand\Wechat\Backend\Repository;

use App\Exceptions;
use iBrand\Wechat\Backend\Models\CardCode;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * MemberCard Repository.
 */
class CardCodeRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CardCode::class;
    }






}
