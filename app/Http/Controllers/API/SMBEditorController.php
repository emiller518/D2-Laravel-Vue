<?php

namespace App\Http\Controllers\API;

use App\Repositories\SuperMegaBaseball\PlayerRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class SMBEditorController extends Controller
{
    /**
     * @var PlayerRepository
     */
    private $playerRepository;

    /**
     * @param PlayerRepository $playerRepository
     */
    public function __construct(PlayerRepository $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    public function update($playerID): bool
    {
        $this->playerRepository->update($playerID);
        return TRUE;

    }
}
