<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("/contact")
     */
class ContactController extends Controller
{
    /**
     * @Route("/")
     */

    public function index(Request $request)
    {
        $user = $this->getUser();
        $contact = new Contact();
       
        $form = $this->createForm (ContactType::class, $contact);
        
        if (!is_null($user)){
            $form->get('name')->setData($user->getPseudo());
            $form->get('email')->setData($user->getEmail());
        }
        
        
        $form->handleRequest($request);
        

                
        if ($form->isSubmitted()){
               
            if($form->isValid()){
 
               $em = $this->getDoctrine()->getManager();
               $em->persist($contact);
               $em->flush();
               
               $this->addFlash('success', 'Votre message a été envoyé.Nous en prendrons compte dans les plus brefs délais');
               
               return $this->redirectToRoute('app_index_index');
            }
            else{
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
        }
            
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
                  
    }
}
