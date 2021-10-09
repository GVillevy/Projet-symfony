<?php

namespace App\Controller;

use App\Entity\Article;
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
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repo->findAll();

        return $this->render('gv_news/index.html.twig', [
            'controller_name' => 'GVNewsController',
            'articles' => $articles
        ]);
    }

    #[Route('/news/create', name: 'news_create')]
    public function create(Request $request,EntityManagerInterface $manager){

        $article = new Article();

        $form = $this->createFormBuilder($article)
                    ->add('title')
                    ->add('content')
                    ->add('image')
                    ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $article->setCreateAt(new \DateTimeImmutable());

            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('news_show',['id' => $article->getId()]);
        }

        return $this->render('gv_news/create.html.twig', [
            'formArticle' => $form->createView()
        ]);
    }

    #[Route('/news/{id}', name: 'news_show')]
    public function show($id){
        $repo=$this->getDoctrine()->getRepository(Article::class);
        $article = $repo->find($id);
        return $this->render('gv_news/show.html.twig', [
            'article' =>$article
        ]);
    }
}
