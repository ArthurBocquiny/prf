<?php

namespace App\Controller;

use App\Entity\InscriptionTournois;
use App\Entity\Tournois;
use App\Entity\User;
use App\Form\UserEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Intl\Intl;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


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
     * @Route("/edit/{id}")
     * @param int $id
     */
    public function edit(Request $request,$id, UserPasswordEncoderInterface $passwordEncoder){
        
        $em = $this->getDoctrine()->getManager();
        $user = $em->find(User::class, $id);
        $originalImage = null;
        
        if(!is_null($user->getPhoto())){
            $originalImage = $user->getPhoto();
            $imagePath = $this->getParameter('upload_dir'). '/' .$originalImage;
            // objet File pour le formulaire
            $user->setPhoto(new File($imagePath));
        }
        
        $form = $this->createForm(UserEditType::class, $user);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted())
        {
            if($form->isValid())
            {

                /**
                 * @var UploadedFile $photo
                 */
                $photo = $user->getPhoto();
               
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
                } else{
                // getData sur une checkbox = true si coché
                if($form->has('remove_photo') && $form->get('remove_photo')->getData()){
                    $user->setPhoto(null);
                    unlink($this->getParameter('upload_dir'). '/' .$originalImage);
                }
                else{
                    $user->setPhoto($originalImage);
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
               
               $this->addFlash('success', "Votre profil a été modifié");
               return $this->redirectToRoute('app_profil_index');
            }
            else{
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
        }
        
        if ($user->getPhoto() instanceof File) {
            $user->setPhoto($user->getPhoto()->getBasename());
        }
        
        return $this->render(
        '/profil/edit.html.twig',
        [
            'form' => $form->createView()
        ]
        );
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
