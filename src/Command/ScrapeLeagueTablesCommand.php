<?php

namespace App\Command;

use App\Entity\Team;
use App\Service\GuardianLeagueTableScraper;
use App\Service\Scrape;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ScrapeLeagueTablesCommand extends Command
{
    /**
     * @var Scrape
     */
    private $scrape;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(Scrape $scrape, EntityManagerInterface $em)
    {
        parent::__construct();
        $this->scrape = $scrape;
        $this->em = $em;
    }

    protected function configure()
    {
        $this->setName("app:scrape");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $leagues = $this->scrape->perform();
    }
}