<?php

namespace App\Command;

use App\Entity\Prediction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateScoresCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure()
    {
        $this->setName("app:scores");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $predictionsRepo = $this->em->getRepository(Prediction::class);

        /** @var Prediction $prediction */
        foreach($predictionsRepo->findAll() as $prediction) {
            $diff = abs($prediction->getPredictedPosition() - $prediction->getClub()->getPosition());
            $prediction->setPositionDifference($diff);
            if ($diff <= 10) {
                $prediction->setPoints(10 - $diff);
            }
        }

        $this->em->flush();
    }
}