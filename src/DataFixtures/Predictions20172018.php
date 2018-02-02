<?php
// src/DataFixtures/AppFixtures.php
namespace App\DataFixtures;

use App\Command\ScrapeLeagueTablesCommand;
use App\Entity\Entrant;
use App\Entity\Prediction;
use App\Entity\Team;
use App\Service\ScoresUpdater;
use App\Service\Scrape;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Predictions20172018 extends Fixture
{

    /**
     * @var Scrape
     */
    private $scrape;
    /**
     * @var ScoresUpdater
     */
    private $scoresUpdater;

    public function __construct(Scrape $scrape, ScoresUpdater $scoresUpdater)
    {
        $this->scrape = $scrape;
        $this->scoresUpdater = $scoresUpdater;
    }

    private const PREDICTIONS = [
        [
            "name" => "Richard Garrett",
            "predictions" => [
                "MNU",
                "MNC",
                "CHE",
                "LIV",
                "BUR",
                "WAT",
                "HUD",
                "AVL",
                "WOL",
                "MID",
                "MIL",
                "BAR",
                "BRT",
                "WIG",
                "BLA",
                "CHA",
                "OLD",
                "WAL",
                "SHR",
                "LUT",
                "COV",
                "LIN",
                "MOR",
                "CRA",
            ]
        ],
        [
            "name" => "Trevor Ballard",
            "predictions" => [
                "MNC",
                "ARS",
                "MNU",
                "CHE",
                "BRI",
                "BUR",
                "HUD",
                "MID",
                "AVL",
                "DER",
                "BOL",
                "IPS",
                "BRT",
                "BLA",
                "BRA",
                "FLE",
                "WIM",
                "GIL",
                "SHR",
                "LUT",
                "MAN",
                "EXE",
                "YEO",
                "MOR",
            ]
        ],
        [
            "name" => "Richard Reveley",
            "predictions" => [
                "CHE",
                "MNC",
                "TOT",
                "ARS",
                "BRI",
                "BUR",
                "HUD",
                "FUL",
                "AVL",
                "WOL",
                "MIL",
                "BOL",
                "BRT",
                "CHA",
                "OXD",
                "BRA",
                "SHR",
                "ROT",
                "FLE",
                "COV",
                "LUT",
                "SWI",
                "LIN",
                "FOR",
            ]
        ],
        [
            "name" => "Dan Abrey",
            "predictions" => [
                "CHE",
                "MNC",
                "MNU",
                "ARS",
                "WAT",
                "BUR",
                "HUD",
                "MID",
                "WOL",
                "AVL",
                "BRT",
                "MIL",
                "QPR",
                "WIG",
                "FLE",
                "OXD",
                "WAL",
                "GIL",
                "SHR",
                "LUT",
                "MAN",
                "FOR",
                "CRA",
                "NPT",
            ]
        ],
        [
            "name" => "Craig Inness",
            "predictions" => [
                "MNC",
                "CHE",
                "MNU",
                "LIV",
                "WAT",
                "BRI",
                "HUD",
                "MID",
                "AVL",
                "SHW",
                "BAR",
                "BRC",
                "BRT",
                "BLA",
                "WIG",
                "BRO",
                "WIM",
                "BLP",
                "SHR",
                "LUT",
                "MAN",
                "PTV",
                "CRA",
                "MOR",
            ]
        ],
        [
            "name" => "Micky Kennett",
            "predictions" => [
                "MNU",
                "CHE",
                "MNC",
                "LEI",
                "STK",
                "BRI",
                "HUD",
                "FUL",
                "LEE",
                "WOL",
                "BOL",
                "BRT",
                "QPR",
                "BRA",
                "MKD",
                "OXD",
                "NMT",
                "BRY",
                "FLE",
                "LUT",
                "MAN",
                "WYC",
                "BAR",
                "ACC",
            ]
        ],
        [
            "name" => "Keith Abrey",
            "predictions" => [
                "MNC",
                "MNU",
                "CHE",
                "TOT",
                "WBA",
                "BUR",
                "HUD",
                "SHW",
                "WOL",
                "LEE",
                "MIL",
                "BAR",
                "BRT",
                "BLA",
                "WIG",
                "OXD",
                "WAL",
                "BLP",
                "OLD",
                "LUT",
                "COV",
                "MAN",
                "CRA",
                "MOR",
            ]
        ]
    ];

    private const MAP = [
        1, 2, 3, 4, 18, 19, 20, 1, 2, 3, 22, 23, 24, 1, 2, 3, 22, 23, 24, 1, 2, 3, 23, 24
    ];

    public function load(ObjectManager $manager)
    {
        $this->scrape->perform();

        foreach (static::PREDICTIONS as $prediction) {
            $entrant = new Entrant();
            $entrant->setName($prediction["name"]);
            $manager->persist($entrant);
            foreach(static::MAP as $i => $position) {
                $predictionEntity = new Prediction();
                $team = $manager->getRepository(Team::class)->findOneByAbbreviation($prediction["predictions"][$i]);

                $predictionEntity->setClub($team);
                $predictionEntity->setPredictedPosition($position);
                $predictionEntity->setEntrant($entrant);
                $manager->persist($predictionEntity);
            }
        }

        $manager->flush();
    }
}