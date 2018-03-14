<?php

namespace App\Controller\Admin;

use App\Entity\News;
use App\Form\NewsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/news")
*/
class NewsController extends Controller
{
    /**
     * @Route("/")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(News::class);
        $news = $repository->findAll();
    
        return $this->render(
                '/admin/news/index.html.twig',
                [
                    'news' => $news
                ]
        );
    }
    
    /**
     * @Route("/insert/{id}", defaults={"id": null})
     */
   public function insert( Request $request, $id )
    {
       $em = $this->getDoctrine()->getManager();
       
       if (is_null($id)) {
       $news = new News();
       $news->setDate(new \DateTime('now'));
       }
       else {
           $news = $em->find(News::class, $id);
       }
       
       $form = $this->createForm(NewsType::class, $news);
       
       $form->handleRequest($request);
       
       if ($form->isSubmitted()){
           if ($form->isValid()){
               
               $em = $this->getDoctrine()->getManager();
               $em->persist($news);
               $em->flush();
               
               $this->addFlash('success', 'Article ajouté');
               return $this->redirectToRoute('app_admin_news_index');
               
           } else {
               
               $this->addFlash('error', 'Veuillez remplir tous les champs');
           }
       }
       
       return $this->render('admin/news/insert.html.twig',
                [
                    'form' => $form->createView()
                ]);
        
   }
   
   /**
     * @Route("/delete/{id}")
     * @param int $id
     */
    public function delete($id){
        
        $em = $this->getDoctrine()->getManager();
        $news = $em->find(News::class, $id);
        
        $em->remove($news);
        $em->flush();
        
        $this->addFlash('success', 'L\'article à été supprimé');
        return $this->redirectToRoute('app_admin_news_index');
        
    }
   
   
}
