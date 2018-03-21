<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @Route("/inscription")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
       $user = new User();
       $originalImage = null;
       $form = $this->createForm(UserType::class, $user);
       
       $form->handleRequest($request);
       
       if($form->isSubmitted()){
           if($form->isValid()){
                 /**
                 * @var UploadedFile $photo
                 */
               $photo= $user->getPhoto();
               
               //s'il ya une image uploadée
               if(!is_null($photo)){
                   // nom du fichier que l'on enregistre
                   $filename = uniqid(). '.' . $photo->guessExtension();
                   
                   // équivalent move_uploaded_file()
                   $photo->move(
                        // upload_dir défini dans services.yaml
                        $this->getParameter('upload_dir'),
                        $filename
                   );
                   
                   $user->setPhoto($filename);
                   
                   // suppression
                   if (!is_null($originalImage)){
                       unlink($this->getParameter('upload_dir'). '/' .$originalImage);
                   }
               }
               $password = $passwordEncoder->encodePassword(
                       $user,
                       $user->getPlainPassword()
                );
               $user->setPassword($password);
               $em = $this->getDoctrine()->getManager();
               $em->persist($user);
               $em->flush();
               
               $this->addFlash('success', 'Votre compte est créé');
               
               return $this->redirectToRoute('app_index_index');
           }
           else{
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
       }
       
        return $this->render(
            'security/register.html.twig', 
            [
                'form' => $form->createView()
            ]
        );
    }
    
    /**
     * @Route("/login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        
        return $this->render(
                'security/login.html.twig',
                [
                   'error' => $error,
                   'last_username' => $lastUsername
                ]
        );
    }
    
    /**
     * @Route("/logout")
     */
    public function logout()
    {
        
    }
}