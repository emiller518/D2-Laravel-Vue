<?php

namespace App\Repositories;

use App\Models\Basketball\PlayByPlay;
use DB;

class PlayByPlayRepository
{
    public function getPlayByPlayScore(int $gameID)
    {
        return PlayByPlay::Query()
            ->select('PlayTypeID', 'Half', 'PlayNum', 'Time', 'Seconds', 'HomeScore', 'AwayScore', 'Team',
                    DB::Raw('CASE WHEN Half = 1 THEN RIGHT(SEC_TO_TIME(1200 - Seconds), 5)
                            WHEN Half = 2 THEN RIGHT(SEC_TO_TIME(1200 - Seconds + 1200), 5)
                            ELSE RIGHT(SEC_TO_TIME(300 - Seconds + 2400), 5) END as Minutes'))
            ->where("GameID", "=", intval($gameID))
            ->where('PlayTypeID', '>=', 8)
            ->where('PlayTypeID', '<=', 14)
            ->orderBy('Half', 'asc')
            ->orderBy('PlayNum', 'Asc')
            ->get();
    }

}
