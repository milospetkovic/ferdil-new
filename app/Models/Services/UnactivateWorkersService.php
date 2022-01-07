<?php


namespace App\Models\Services;


use App\Models\Managers\WorkerManager;

class UnactivateWorkersService
{

    /**
     * @var WorkerManager
     */
    private $workerManager;

    public function __construct()
    {
        $this->workerManager = new WorkerManager();
    }

    public function unactivateWorkersIfConditionIsFulfilled()
    {
        $cntWorkers = $this->workerManager->unactivateWorkersIfConditionIsFulfilled();

        if ($cntWorkers) {
            $this->returnMessage = 'Ukupno '.$cntWorkers.' radnika je automatski deaktivirano.';
        } else {
            $this->returnMessage = 'Nema radnika koji ispunjavaju uslov za deaktivaciju.';
        }

        return $this->returnMessage;
    }

}