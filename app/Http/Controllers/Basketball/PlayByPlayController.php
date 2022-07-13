<?php

namespace App\Http\Controllers;

use App\Repositories\PlayByPlayRepository;
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
