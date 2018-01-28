<?php

namespace App\Service;


use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class GuardianLeagueTableScraper
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    private const LEAGUES = [
        ["name" => "Premier League", "slug" => "premierleague"],
        ["name" => "Championship", "slug" => "championship"],
        ["name" => "League One", "slug" => "leagueonefootball"],
        ["name" => "League Two", "slug" => "leaguetwofootball"],
    ];

    private function generateUrl($slug)
    {
        return sprintf("https://www.theguardian.com/football/%s/table", $slug);
    }

    private function scrapeLeagueTableUrl($url)
    {
        $crawler = $this->client->request("GET", $url);
        $ret = [];

        $crawler->filter("table.table--league-table tbody tr")->each(function(Crawler $node) use (&$ret) {
            $ret[] = [
                "abbreviation" => $node->filter("span[data-abbr]")->eq(0)->attr("data-abbr"),
                "name" => trim($node->filter(".team-name__long")->eq(0)->text()),
                "position" => $node->filter("td.table-column--sub")->eq(0)->text(),
            ];
        });

        return $ret;
    }

    public function scrapeLeagueTables()
    {
        $leagues = [];

        foreach(static::LEAGUES as $league) {
            $leagues[] = [
                "name" => $league["name"],
                "teams" => $this->scrapeLeagueTableUrl($this->generateUrl($league["slug"]))
            ];
        }

        return $leagues;
    }
}