<?php

namespace App\Controller;

use App\Entity\InscriptionTournois;
use App\Entity\Tournois;
use App\Entity\User;
use App\Repository\UserRepository;
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
    
    
    public function sendMail($name, \Swift_Mailer $mailer, $tournois, $mailuser)
    {
        $message = (new \Swift_Message("Votre inscription au tournois $tournois"))
            ->setFrom('PLS@pixellovesport.com')
            ->setTo($mailuser)
            ->setBody(
                $this->renderView(
                    'emails/inscriptiontournois.html.twig',
                    array('name' => $name)
                ),
                'text/html'
            );
        
            $mailer->send($message);
            
        return $this->render('emails/inscriptiontournois.html.twig',
                [
                    'name' => $name,
                ]);
    }
    
    
    /**
     * @Route("/fichetournois/{id}", defaults={"id" :null})
     */
    public function fichetournois( \Swift_Mailer $mailer, Request $request, $id)
    {
        
        $em = $this->getDoctrine()->getManager();
        $selectedtournois = $em->find(Tournois::class, $id);
        
        // Nombre de participants
        $userTournois = new Tournois();
        $userTournois = $this->getDoctrine()->getRepository(InscriptionTournois::class);
        $nbuser = count($userTournois->selectUserTournois($id));
        // --------------
        
        $tournois = new InscriptionTournois();
        $form = $this->createForm(InscriptionTournoisType::class, $tournois);
        
        $actuser = $this->getUser();
        $emailuser = $this->getUser()->getEmail();
        $repository = $this->getDoctrine()->getRepository(InscriptionTournois::class);
        $insctournois = count($repository->grossePute($id, $actuser));

        $nomselectedtournois = $selectedtournois->getJeu();
        $nomactuser = $this->getUser()->getPseudo();
              
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted()){
            if($form->isValid()){
                
                $em->persist($tournois);
                $em->flush();
                
                $this->sendMail($nomactuser, $mailer, $nomselectedtournois, $emailuser);
               
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
                'form' => $form->createView(),
                'nbuser' => $nbuser,
                'insctournois' => $insctournois
            ]);
    }
 
}
