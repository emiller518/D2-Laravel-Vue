<?php

namespace App\Http\Controllers\Basketball;

use App\Http\Controllers\Controller;
use App\Repositories\Basketball\PlayByPlayRepository;
use DB;


class PlayByPlayController extends Controller {

    public function __construct(PlayByPlayRepository $playByPlayRepository)
    {
        $this->PlayByPlayRepository = $playByPlayRepository;
    }

    public function gamePlayByPlay($gameID){
        return $this->PlayByPlayRepository->getPlayByPlayScore($gameID);
    }

}
