<?php

namespace App\Command;

use App\Entity\Team;
use App\Service\GuardianLeagueTableScraper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ScrapeLeagueTablesCommand extends Command
{
    /**
     * @var GuardianLeagueTableScraper
     */
    private $scraper;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(GuardianLeagueTableScraper $scraper, EntityManagerInterface $em)
    {
        parent::__construct();
        $this->scraper = $scraper;
        $this->em = $em;
    }

    protected function configure()
    {
        $this->setName("app:scrape");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
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
    }
}