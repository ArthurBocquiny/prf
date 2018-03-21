<?php

namespace App\Controller\Admin;

use App\Entity\Clan;
use App\Form\ClanType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/clan")
 */
class ClanController extends Controller
{
    /**
     * @Route("/")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Clan::class);
        $clan = $repository->findAll();
        
        return $this->render(
            '/admin/clan/index.html.twig', 
            [
                'clan' => $clan
            ]);
    }
    
    /**
     * @Route("/edit/{id}", defaults={"id":null})
     */
    public function edit(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $originalImage = null;
        
        if (is_null($id)){//création
            $clan = new Clan();
            
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
               
               $this->addFlash('success', "Le clan est enregistré");
               return $this->redirectToRoute('app_admin_clan_index');
            }
            else {
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
        }
        
         
        return $this->render(
                '/admin/clan/edit.html.twig',
                [
                    'form' => $form->createView()
                ]
        );
    }
    /**
     * @Route("/delete/{id}")
     * @param type $id
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        //raccourci pour $em->getRepository(Category::class)->find($id)
        $clan = $em->find(Clan::class, $id);
        
        //Suppression de la catégorie en bdd
        $em->remove($clan);
        $em->flush();
        
        //ajout d'un message
        $this->addFlash('success', "Le clan a été supprimé");
        // redirection vers la liste
        return $this->redirectToRoute('app_admin_clan_index');
    }
}
