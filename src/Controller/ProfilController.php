<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProfilController extends Controller
{
    /**
     * @Route("/profil")
     */
    public function index()
    {
        $user = $this->getUser();
        
        if ( null === $user )
        {
            $this->addFlash('error', 'Veuillez vous connecter');
            
            return $this->redirectToRoute('app_security_login');
            
        } else {
            return $this->render(
                    'profil/index.html.twig',
                    [
                        'user' => $user
                    ]
            );
        }
    }
}
