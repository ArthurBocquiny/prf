<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use function dump;

class UsersController extends Controller
{
    /**
     * @Route("/users")
     */
    public function index()
    {
        /**
         * @Route("/")
         */
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
        * @Route("/upgrade/{id}", defaults={"id": null})
        */
    public function upgrade(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $users = $em->find(User::class, $id);
        $users->setRole('ROLE_ADMIN');
        
        $em->persist($users);
        $em->flush();
        
        $this->addFlash('success', 'Le membre a été promou');
        return $this->redirectToRoute('app_admin_users_index');
        
    }
    
     /**
     * @Route("/delete/{id}")
     * @param int $id
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        //raccourci pour $em->getRepository(Category::class)->find($id)
        $users = $em->find(User::class, $id);
        
        // suppression de la catégorie en bdd
        $em->remove($users);
        $em->flush();
        
        // ajout d'un message
        $this->addFlash('success', "Le membre a été supprimé");
        // redirection vers la liste
        return $this->redirectToRoute('app_admin_users_index');
    }
}

