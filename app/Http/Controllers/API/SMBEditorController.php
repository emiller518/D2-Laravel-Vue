<?php

namespace App\Http\Controllers\API;

use App\Factories\JsonAPIResponseFactory;
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
     * @param Request $request
     */
    public function __construct(PlayerRepository $playerRepository, Request $request)
    {
        $this->playerRepository = $playerRepository;
        $this->request          = $request;
    }

    public function updateStats($playerID): bool
    {
        $optionKey = $this->request->get('optionKey');
        $optionValue = $this->request->get('optionValue');

        $this->playerRepository->updateStats($playerID, $optionKey, $optionValue);
        return TRUE;

    }

    public function updateVisuals($playerID): bool
    {
        $optionKey = (int)$this->request->get('optionKey');
        $optionValue = (string)$this->request->get('optionValue');

        $this->playerRepository->updateVisuals($playerID, $optionKey, $optionValue);
        return TRUE;

    }

}
