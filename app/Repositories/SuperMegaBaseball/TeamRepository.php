<?php

namespace App\Repositories\SuperMegaBaseball;

use App\Models\SuperMegaBaseball\League\League;
use App\Models\SuperMegaBaseball\Team\Team;
use Illuminate\Support\Facades\DB;

class TeamRepository
{
    public function getLeagues(): array
    {
        return Team::query()
            ->select('name')
            ->get()
            ->toArray();
    }

}
