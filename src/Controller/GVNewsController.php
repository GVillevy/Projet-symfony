<?php

namespace App\Controller;

use App\Entity\News;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class GVNewsController extends AbstractController
{
    #[Route('/news', name: 'news')]
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(News::class);
        $NewsList = $repo->findAll();

        return $this->render('gv_news/index.html.twig', [
            'controller_name' => 'GVNewsController',
            'newsList' => $NewsList
        ]);
    }

    /**
     * @Route("/news/create", name="news_create")
     * @Route("/news/{id}/edit", name="news_edit")
     */
    public function form(News $news = null, Request $request, EntityManagerInterface $manager){

        if(!$news){
            $news=new News();
        }

        $form = $this->createFormBuilder($news)
                    ->add('title')
                    ->add('content')
                    ->add('image')
                    ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if(!$news->getId()){
                $news->setCreateAt(new \DateTimeImmutable());
            }

            $manager->persist($news);
            $manager->flush();

            return $this->redirectToRoute('news_show',['id' => $news->getId()]);
        }

        return $this->render('gv_news/create.html.twig', [
            'formNews' => $form->createView(),
            'editMode' => $news->getId()!==null
        ]);
    }

    #[Route('/news/{id}', name: 'news_show')]
    public function show($id){
        $repo=$this->getDoctrine()->getRepository(News::class);
        $news = $repo->find($id);
        return $this->render('gv_news/show.html.twig', [
            'news' =>$news
        ]);
    }
}
