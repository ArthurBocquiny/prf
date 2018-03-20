<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
* @Route("/team")
*/
class TeamController extends Controller
{
    /**
     * @Route("/")
     */
    public function index()
    {
        
        return $this->render('team/index.html.twig', [
            'controller_name' => 'TeamController',
        ]);
    }
    
    /**
     * @Route("/add/{id}", defaults={"id": null})
     */
    public function add()
    {
        $user = $this->getUser();
        
        if ( null === $user )
        {
            $this->addFlash('error', 'Veuillez vous connecter');
            
            return $this->redirectToRoute('app_security_login');
            
        }
        else{
            
        }
    }
}
