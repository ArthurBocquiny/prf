<?php

namespace App\Controller;

use App\Entity\Clan;
use App\Entity\InscriptionTeam;
use App\Entity\InscriptionTournois;
use App\Entity\Tournois;
use App\Entity\User;
use App\Form\ClanType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Intl\Intl;
use Symfony\Component\Routing\Annotation\Route;
use function dump;
use App\Form\UserEditType;
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
        $em = $this->getDoctrine()->getManager();
        
        $invClan = array();
        $searchUsers = array();
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        
        $user = $this->getUser();
        
        $userCountry = $this->getUser()->getCountry();
        $country = Intl::getRegionBundle()->getCountryNames();
        
        $iduser = $user->getId();
        
        $repo = new Tournois();
        $repo = $this->getDoctrine()->getRepository(Tournois::class);
        
        $tournoisusers = $repo->tournoisUser($iduser);

        $idclan = $user->getIdClan();
        
        $tournoisclan = $repo->tournoisClan($idclan);
        
        $repositoryClan = $this->getDoctrine()->getRepository(Clan::class);
        
        $idUserClan = $this->getUser()->getIdClan();
        
        $creatorClan = $repositoryClan->searchIdUser($iduser);
        
        if ( count($creatorClan) > 0 )
        {
            $user->setIdClan($creatorClan[0]->getId());
            $em->persist($user);
            $em->flush();
        }
        
        $clanUser = $repositoryClan->findBy(['id' => $idUserClan]);

        $invitationClanRepository = $this->getDoctrine()->getRepository(InscriptionTeam::class);
        $invitationClanUser = $invitationClanRepository->findUserInvit($iduser);
        $nbInvit = count($invitationClanUser);
        
        for($i = 0; $i < $nbInvit; $i++)
        {            
            $invClan[] = $repositoryClan->findNameClan($invitationClanUser[$i]->getIdTeam());
        }
        
        foreach($country as $key => $value)
        {
            if ($userCountry == $key)
            {
                $userCountry = $value;
            }
        }
        
        if ( !empty($_GET['user']) )
        {
            $searchUsers =  $userRepository->searchPseudoUser($_GET['user']);
        }
        
        if ( !empty($_GET['action']) && $_GET['action'] == 'ajout' )
        {
            $inviteClan = new InscriptionTeam();
            
            $inviteClan->setIdTeam($clanUser[0]->getId());
            $inviteClan->setIdUser($_GET['user']);
            $em->persist($inviteClan);
            $em->flush();
            
            $this->addFlash('success', 'Membre bien ajouté');
        }
        
        if ( !empty($_GET['action']) && $_GET['action'] == 'accept' )
        {
            $invitationClanUser = $invitationClanRepository->findBy(['id_user' => $iduser,
                                                                     'id_team' => $_GET['id_clan']]);
            $user->setIdClan($_GET['id_clan']);
            $em->remove($invitationClanUser[0]);
            
            $userClan = $repositoryClan->findBy(['id_user' => $iduser]);
            $userClan[0]->setIdUser(0);
            
            $em->persist($user);
            $em->persist($userClan[0]);
            $em->flush();
            
            $this->addFlash('success', 'Vous avez accepté une invitation');
            
            return $this->redirectToRoute('app_profil_index');
        }
        
        if ( !empty($_GET['action']) && $_GET['action'] == 'refus' )
        {
            $invitationClanUser = $invitationClanRepository->findBy(['id_user' => $iduser,
                                                                     'id_team' => $_GET['id_clan']]);
            
            $userClan = $repositoryClan->findBy(['id_user' => $iduser]);
            $userClan[0]->setIdUser(0);
            
            $em->remove($invitationClanUser[0]);
            $em->persist($userClan[0]);
            $em->flush();
            $this->addFlash('success', 'Vous avez refusé une invitation');
            
            return $this->redirectToRoute('app_profil_index');
        }
        
        if ( !empty($_GET['action']) && $_GET['action'] == 'leave' )
        {
            $user->setIdClan(0);
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Vous avez quitté le clan');
            
            return $this->redirectToRoute('app_profil_index');
        }
        if ( null === $user )
        {
            $this->addFlash('error', 'Veuillez vous connecter');
            
            return $this->redirectToRoute('app_security_login');
            
        } else {
            return $this->render(
                    'profil/index.html.twig',
                    [
                        'tournoisclan' => $tournoisclan,
                        'clanUser' => $clanUser,
                        'invClan' => $invClan,
                        'nbInvit' => $nbInvit,
                        'invitationsClan' => $invitationClanUser,
                        'searchUsers' => $searchUsers,
                        'idUserClan' => $idUserClan,
                        'user' => $user,
                        'user_country' => $userCountry,
                        'tournoisusers' => $tournoisusers
                    ]
            );
        }
    }
    
    /**
     * @Route("/clan/{id}", defaults={"id":null})
     */
    public function clan(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $originalImage = null;
        
        if (is_null($id)){//création
            $clan = new Clan();
            $clan->setIdUser($this->getUser()->getId());
        } else {//modification
            $clan = $em->find(Clan::class, $id);
            
            if(!is_null($clan->getLogo())){
                $originalImage = $clan->getLogo();
                $imagePath = $this->getParameter('upload_dir'). '/' .$originalImage;
                // objet File pour le formulaire
                $clan->setLogo(new File($imagePath));
            }
        }
        
        $form = $this->createForm(ClanType::class, $clan);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted())
        {
            if($form->isValid())
            {
               
                /**
                 * @var UploadedFile $logo
                 */
                $logo = $clan->getLogo();
               
               //s'il ya une image uploadée
               if(!is_null($logo)){
                   // nom du fichier que l'on enregistre
                   $filename = uniqid(). '.' . $logo->guessExtension();
                   
                   // équivalent move_uploaded_file()
                   $logo->move(
                        // upload_dir défini dans services.yaml
                        $this->getParameter('upload_dir'),
                        $filename
                   );
                   
                   $clan->setLogo($filename);
                   
                   // suppression
                   if (!is_null($originalImage)){
                       unlink($this->getParameter('upload_dir'). '/' .$originalImage);
                   }
               } else{
                   // getData sur une checkbox = true si coché
                   if($form->has('remove_logo') && $form->get('remove_logo')->getData()){
                       $clan->setLogo(null);
                       unlink($this->getParameter('upload_dir'). '/' .$originalImage);
                   }
                   else{
                       $clan->setLogo($originalImage);
                   }
               }
               
               $em->persist($clan);
               $em->flush();
                  
               $this->addFlash('success', "Le clan est ajouté");
               return $this->redirectToRoute('app_profil_index');
            }
            else {
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
        }
        
        return $this->render(
                'profil/ajoutClan.html.twig',
                [
                    'form' => $form->createView()
                ]
        );
    }

    /**
     * @Route("/edit/{id}")
     * @param int $id
     */
    public function edit(Request $request,$id, UserPasswordEncoderInterface $passwordEncoder){
        
        $em = $this->getDoctrine()->getManager();
        $user = $em->find(User::class, $id);
        
        $form = $this->createForm(UserEditType::class, $user);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted())
        {
            if($form->isValid())
            {
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
        
        return $this->render(
        'profil/edit.html.twig',
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
