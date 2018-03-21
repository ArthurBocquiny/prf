<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InscriptionTeamController extends Controller
{
    /**
     * @Route("/inscription/team", name="inscription_team")
     */
    public function index()
    {
        return $this->render('inscription_team/index.html.twig', [
            'controller_name' => 'InscriptionTeamController',
        ]);
    }
}
