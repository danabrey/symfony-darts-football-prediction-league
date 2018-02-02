<?php

namespace App\Controller;

use App\Entity\Entrant;
use App\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/")
     */
    public function showAction()
    {
        return $this->render("home.html.twig", [
            "entrants" => $this->getDoctrine()->getRepository(Entrant::class)->findAllOrderedByScore(),
            "teams" => $this->getDoctrine()->getRepository(Team::class)->findAll()
        ]);
    }
}