<?php

namespace App\Controller;

use App\Entity\InscriptionTournois;
use App\Entity\Tournois;
use App\Form\InscriptionTournoisType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
    public function fichetournois( Request $request, $id)
    {
        
        $em = $this->getDoctrine()->getManager();
        $selectedtournois = $em->find(Tournois::class, $id);
        
        $tournois = new InscriptionTournois();
        $form = $this->createForm(InscriptionTournoisType::class, $tournois);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted()){
            if($form->isValid()){
                
                $em->persist($tournois);
                $em->flush();
               
                $this->addFlash('success', 'Vous êtes inscrit !');
               
               return $this->redirectToRoute('app_jeux_index');
           }
           else{
                $this->addFlash('error', 'Le formulaire contient des erreurs');
                
            }
        }
        
         return $this->render(
            'jeux/fichetournois.html.twig',
            [
                'selectedtournois' => $selectedtournois,
                'form' => $form->createView()
            ]);
    }
    
   
}
