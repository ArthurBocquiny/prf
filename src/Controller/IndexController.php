<?php

namespace App\Controller;

use App\Entity\InscriptionTournois;
use App\Entity\Tournois;
use App\Entity\News;
use App\Form\InscriptionTournoisType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends Controller
{
    /**
     * @Route("/")
     */
    public function index()
    {
        $prochainsTournois = $this->getDoctrine()->getRepository(Tournois::class);
        $tournois = $prochainsTournois->findNextTournois(5);
        
        $newNews = $this->getDoctrine()->getRepository(News::class);
        $news = $newNews->findNewNews(5);
        
        return $this->render(
            'index/index.html.twig',
            [
                'tournois' => $tournois,
                'news' => $news
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
               
               return $this->redirectToRoute('app_index_index');
           }
           else{
                $this->addFlash('error', 'Le formulaire contient des erreurs');
                
            }
        }
        
         return $this->render(
            'index/fichetournois.html.twig',
            [
                'selectedtournois' => $selectedtournois,
                'form' => $form->createView()
            ]);
    }
}

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
        
    }
    
    
    
   
}
