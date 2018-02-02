<?php
namespace App\Service;

use App\Entity\Entrant;
use App\Entity\Prediction;
use Doctrine\ORM\EntityManagerInterface;

class ScoresUpdater
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {

        $this->em = $em;
    }

    public function perform()
    {
        $predictionsRepo = $this->em->getRepository(Prediction::class);
        $entrantsRepo = $this->em->getRepository(Entrant::class);

        /** @var Prediction $prediction */
        foreach($predictionsRepo->findAll() as $prediction) {
            $diff = abs($prediction->getPredictedPosition() - $prediction->getClub()->getPosition());
            $prediction->setPositionDifference($diff);
            if ($diff <= 10) {
                $prediction->setPoints(10 - $diff);
            }
        }

        $this->em->flush();

        /** @var Entrant $entrant */
        foreach($entrantsRepo->findAll() as $entrant) {
            $score = 0;
            foreach($entrant->getPredictions() as $prediction) {
                $score += $prediction->getPoints();
            }
            $entrant->setScore($score);
        }

        $this->em->flush();
    }
}