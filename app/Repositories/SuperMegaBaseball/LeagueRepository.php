<?php

namespace App\Repositories\SuperMegaBaseball;

use App\Models\SuperMegaBaseball\League\Conference;
use App\Models\SuperMegaBaseball\League\Division;
use App\Models\SuperMegaBaseball\League\League;
use App\Models\SuperMegaBaseball\Pivot\DivisionTeam;
use App\Models\SuperMegaBaseball\Team\Team;
use Illuminate\Support\Facades\DB;

class LeagueRepository
{
    public function getLeagues(): array
    {
        return League::query()
            ->select('name')
            ->get()
            ->toArray();
    }

    public function getTeamsInLeague($leagueName): array
    {
        return League::query()
            ->select(Team::TABLE . '.' . Team::FIELD_TEAM_NAME)
            ->leftJoin(Conference::TABLE, League::TABLE.'.'.League::FIELD_GUID, '=', Conference::TABLE.'.'.Conference::FIELD_LEAGUE_GUID)
            ->leftJoin(Division::TABLE, Conference::TABLE.'.'.Conference::FIELD_GUID, '=', Division::TABLE.'.'.Division::FIELD_CONFERENCE_GUID)
            ->leftJoin(DivisionTeam::TABLE, Division::TABLE.'.'.Division::FIELD_GUID, '=', DivisionTeam::TABLE.'.'.DivisionTeam::FIELD_DIVISION_GUID)
            ->leftJoin(Team::TABLE, Team::TABLE.'.'.Team::FIELD_GUID, '=', DivisionTeam::TABLE.'.'.DivisionTeam::FIELD_TEAM_GUID)
            ->where(League::TABLE.'.'.League::FIELD_NAME, '=', $leagueName)
            ->get()
            ->toArray();
    }

}
