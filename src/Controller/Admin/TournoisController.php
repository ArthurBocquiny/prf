<?php

namespace App\Controller\Admin;

use App\Entity\InscriptionTournois;
use App\Entity\Tournois;
use App\Form\TournoisType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/tournois")
*/
class TournoisController extends Controller
{
    /**
     * @Route("/")
     * 
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Tournois::class);
        $tournois = $repository->findAll();
        
        for($i = 0; $i < count($tournois); $i++)
        {
            $idtour = $tournois[$i]->getId();
            $userTournois = $this->getDoctrine()->getRepository(InscriptionTournois::class);
            $nbuser = count($userTournois->selectUserTournois($idtour));
            $tournois[$i]->setNbParticipantActuel($nbuser);
            
        }
        
        return $this->render(
                'admin/tournois/index.html.twig',
            [
                'tournois' => $tournois
            ]);
    }
    
    /**
     * @Route("/insert/{id}", defaults={"id": null})
     */
   public function insert( Request $request, $id )
    {
       $em = $this->getDoctrine()->getManager();
       
       if (is_null($id)) {
       $tournois = new Tournois();
       }
       else {
           $tournois = $em->find(Tournois::class, $id);
           
       }
       if(!empty($_GET['game_name']))
        {
           $jeu = $_GET['game_name'];
       } else {
           $jeu = 'null';
       }
       foreach ($tournois as $key => $value) {
                if($key == 'jeu'){
                    $jeu = $value;
                }
            }
       $form = $this->createForm(TournoisType::class, $tournois);
       
       $form->handleRequest($request);
       
       if ($form->isSubmitted()){
           if ($form->isValid()){
               
               $em = $this->getDoctrine()->getManager();
               $em->persist($tournois);
               $em->flush();
               
               $this->addFlash('success', 'Tournois Organisé !');
               return $this->redirectToRoute('app_admin_tournois_index');
               
           } else {
               
               $this->addFlash('error', 'Veuillez remplir tous les champs');
           }
       }
       
       return $this->render('admin/tournois/insert.html.twig',
                [
                    'form' => $form->createView(),
                    'jeu' => $jeu
                ]);
        
   }
   
   /**
     * @Route("/delete/{id}")
     * @param int $id
     */
    public function delete($id){
        
        $em = $this->getDoctrine()->getManager();
        $tournois = $em->find(Tournois::class, $id);
        
        $em->remove($tournois);
        $em->flush();
        
        $this->addFlash('success', 'Le tournois à été annulé');
        return $this->redirectToRoute('app_admin_tournois_index');
        
    }
    
}
