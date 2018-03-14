<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserEditType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/users")
 */
class UsersController extends Controller
{
    /**
     * @Route("/")
     */
    public function index()
    {
        
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findAll();
        
        return $this->render(
                'admin/users/index.html.twig',
                [
                    'users' => $users
                ]
        );
    }
    
   
   /**
    * @Route("/edit/{id}", defaults={"id": null})
    */
    public function edit(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $originalImage = null;
        
        if(is_null($id)) { // création
            $users = new User();
            
            $form = $this->createForm(UserType::class, $users);
        
            
        } else{ // modification
            $users = $em->find(User::class, $id);
            
            /* if (!is_null($users->getImage()))
            {
                $originalImage = $users->getImage();
                $imagePath = $this->getParameter('upload_dir') . '/' . $originalImage;
                // objet File pour le formulaire
                $users->setImage(new File($imagePath));
            } */
        
            $form = $this->createForm(UserEditType::class, $users);
        }
        
        
            $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            if ($form->isValid()){
                /**
                 * @var UploadedFile $image
                 */
                
                // $image = $users->getImage();
                
                // s'il n'y a pas eu d'images uploadée avant
                 /* if (!is_null($image))
                {
                    // nom du fichier que l'on va enregistrer
                    $filename = uniqid() . '.' . $image->guessExtension();
                    
                    // équivalent move_uploaded_file()
                    $image->move(
                            // upload_dir defini dans service.yaml
                            $this->getParameter('upload_dir'),
                            $filename
                    );
                    
                    $users->setImage($filename);
                    
                    // suppression de l'ancienne image en modification
                    if (!is_null($originalImage))
                    {
                        unlink($this->getParameter('upload_dir') . '/' . $originalImage);
                    }
                } else {
                    // getData sur une checkbox = true si coché, false sinon
                    if ($form->has('remove_image') && $form->get('remove_image')->getData()) {
                        $users->setImage(null);
                        unlink($this->getParameter('upload_dir') . '/' . $originalImage);
                    } else {
                        $users->setImage($originalImage);
                    }
                }
                */
                $em->persist($users);
                $em->flush();
                
                $this->addFlash('success', "L'utilisateur est modifié");
                
                return $this->redirectToRoute('app_admin_users_index');
            } else {
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
        }
            
        if (is_null($id))
        {
            return $this->render(
                '/admin/users/insert.html.twig', 
                [
                    'form' => $form->createView()
                ]
            );
        } else {
            return $this->render(
                '/admin/users/edit.html.twig', 
                [
                    'form' => $form->createView()
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
        $users = $em->find(User::class, $id);
        
        $em->remove($users);
        $em->flush();
        
        $this->addFlash('success', 'Le membre a été supprimé');
        return $this->redirectToRoute('app_admin_users_index');
        
    }
   
   
}
