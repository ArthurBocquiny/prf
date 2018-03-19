<?php

namespace App\Controller;

use App\Entity\Tournois;
use App\Entity\InscriptionTournois;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Intl\Intl;
use Symfony\Component\Routing\Annotation\Route;


    /**
     * @Route("/profil")
     */
class ProfilController extends Controller
{
    /**
     * @Route("/")
     */
    public function index()
    {
        $user = $this->getUser();
        $userCountry = $this->getUser()->getCountry();
        $country = Intl::getRegionBundle()->getCountryNames();
        
        $iduser = $user->getId();
        
        $repo = new Tournois();
        $repo = $this->getDoctrine()->getRepository(Tournois::class);
        
        $tournoisusers = $repo->tournoisUser($iduser);
        
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
                        'user_country' => $userCountry,
                        'tournoisusers' => $tournoisusers
                    ]
            );
        }
    }
    
    
     /**
     * @Route("/delete/{id}")
     * @param int $id
     */
    public function delete($id){
        $em = $this->getDoctrine()->getManager();
        $inscription = $em->find(InscriptionTournois::class, $id);
        
        $em->remove($inscription);
        $em->flush();
        
        $this->addFlash('success', 'Vous êtes désinscrit');
        return $this->redirectToRoute('app_profil_index');
    }
   
}
