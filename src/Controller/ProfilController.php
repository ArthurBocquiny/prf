<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Intl\Intl;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends Controller
{
    /**
     * @Route("/profil")
     */
    public function index()
    {
        $user = $this->getUser();
        $userCountry = $this->getUser()->getCountry();
        $country = Intl::getRegionBundle()->getCountryNames();
        foreach($country as $key => $value)
        {
            if ($userCountry == $key)
            {
                $userCountry = $value;
            }
        }
             
        if ( null === $user )
        {
            $this->addFlash('error', 'Veuillez vous connecter');
            
            return $this->redirectToRoute('app_security_login');
            
        } else {
            return $this->render(
                    'profil/index.html.twig',
                    [
                        'user' => $user,
                        'user_country' => $userCountry
                    ]
            );
        }
    }
}
