<?php

namespace App\Controller;

use App\Entity\Entrant;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class EntrantController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/entrant/{id}")
     */
    public function showAction(Entrant $entrant)
    {
        return $this->render("entrant.html.twig", [
            "entrant" => $entrant
        ]);
    }
}