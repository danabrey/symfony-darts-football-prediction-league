<?php
namespace App\Service;


use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;

class Scrape
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var GuardianLeagueTableScraper
     */
    private $scraper;

    public function __construct(EntityManagerInterface $em, GuardianLeagueTableScraper $scraper)
    {

        $this->em = $em;
        $this->scraper = $scraper;
    }

    public function perform()
    {
        $teamRepo = $this->em->getRepository(Team::class);

        $leagues = $this->scraper->scrapeLeagueTables();

        foreach($leagues as $league) {
            foreach($league["teams"] as $team) {
                $teamEntity = $teamRepo->findOneBy(["abbreviation" => $team["abbreviation"]]);
                if (!$teamEntity) {
                    $teamEntity = new Team();
                    $teamEntity->setAbbreviation($team["abbreviation"]);
                    $teamEntity->setName($team["name"]);
                    $this->em->persist($teamEntity);
                }
                $teamEntity->setPosition($team["position"]);
            }
        }

        $this->em->flush();

        return true;
    }
}