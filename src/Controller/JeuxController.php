<?php

namespace App\Controller;

use App\Entity\Tournois;
use App\Repository\TournoisRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
* @Route("/jeux")
*/
class JeuxController extends Controller
{
    /**
     * @Route("/")
     */
    public function index()
    {
        $prochainsTournois = $this->getDoctrine()->getRepository(Tournois::class);
        $tournois = $prochainsTournois->findNextTournois(5);
        
        return $this->render(
            'jeux/index.html.twig',
            [
            'tournois' => $tournois,
            ]);
    }
    
    /**
     * @Route("/fichetournois/{id}", defaults={"id" :null})
     */
    public function fichetournois($id)
    {
        $em = $this->getDoctrine()->getManager();
        $selectedtournois = $em->find(Tournois::class, $id);
        
         return $this->render(
            'jeux/fichetournois.html.twig',
            [
                'selectedtournois' => $selectedtournois
            ]);
    }
}
