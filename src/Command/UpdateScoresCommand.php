<?php

namespace App\Command;

use App\Entity\Entrant;
use App\Entity\Prediction;
use App\Service\ScoresUpdater;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateScoresCommand extends Command
{

    /**
     * @var ScoresUpdater
     */
    private $scoresUpdater;

    public function __construct(ScoresUpdater $scoresUpdater)
    {
        parent::__construct();

        $this->scoresUpdater = $scoresUpdater;
    }

    protected function configure()
    {
        $this->setName("app:scores");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->scoresUpdater->perform();
    }
}