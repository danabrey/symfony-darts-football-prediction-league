<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EntrantPredictionRepository")
 */
class Prediction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Team")
     */
    private $club;

    /**
     * @ORM\ManyToOne(targetEntity="Entrant", inversedBy="predictions")
     */
    private $entrant;

    /**
     * @ORM\Column(type="integer")
     */
    private $predictedPosition = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $positionDifference = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $points = 0;

    /**
     * @return mixed
     */
    public function getClub()
    {
        return $this->club;
    }

    /**
     * @param mixed $club
     */
    public function setClub($club): void
    {
        $this->club = $club;
    }

    /**
     * @return mixed
     */
    public function getPredictedPosition()
    {
        return $this->predictedPosition;
    }

    /**
     * @param mixed $predictedPosition
     */
    public function setPredictedPosition($predictedPosition): void
    {
        $this->predictedPosition = $predictedPosition;
    }

    /**
     * @return mixed
     */
    public function getPositionDifference()
    {
        return $this->positionDifference;
    }

    /**
     * @param mixed $positionDifference
     */
    public function setPositionDifference($positionDifference): void
    {
        $this->positionDifference = $positionDifference;
    }

    /**
     * @return mixed
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param mixed $points
     */
    public function setPoints($points): void
    {
        $this->points = $points;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getEntrant()
    {
        return $this->entrant;
    }

    /**
     * @param mixed $entrant
     */
    public function setEntrant($entrant): void
    {
        $this->entrant = $entrant;
    }

    public function __toString()
    {
        return sprintf("%s %s (currently %s)", $this->getClub()->getName(), $this->getPredictedPosition(), $this->getClub()->getPosition());
    }
}
