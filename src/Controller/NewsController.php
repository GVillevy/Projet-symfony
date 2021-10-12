<?php

namespace App\Controller;

use App\Entity\News;
use App\Form\NewsType;
use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/admin/admin_news')]
class NewsController extends AbstractController
{
    #[Route('/', name: 'admin_news_index', methods: ['GET'])]
    public function index(NewsRepository $newsRepository): Response
    {
        $repo = $this->getDoctrine()->getRepository(News::class);
        $news = $repo->findAll();
        return $this->render('gv_admin_news/index.html.twig', [
            'gv_admin_news' => $newsRepository->findAll(),
            'new' => $news
        ]);
    }

    #[Route('/new', name: 'admin_news_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $news = new News();
        //$form = $this->createForm(NewsType::class, $news);
        $form = $this->createFormBuilder($news)
            ->add('title')
            ->add('content')
            ->add('image')
            ->getForm();
        $news->setCreateAt(new \DateTimeImmutable());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($news);
            $entityManager->flush();

            return $this->redirectToRoute('admin_news_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('gv_admin_news/new.html.twig', [
            'news' => $news,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_news_show', methods: ['GET'])]
    public function show(News $news): Response
    {
        return $this->render('gv_admin_news/show.html.twig', [
            'news' => $news,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_news_edit', methods: ['GET','POST'])]
    public function edit(Request $request, News $news): Response
    {
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_news_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('gv_admin_news/edit.html.twig', [
            'news' => $news,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_news_delete', methods: ['POST'])]
    public function delete(Request $request, News $news): Response
    {
        if ($this->isCsrfTokenValid('delete'.$news->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($news);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_news_index', [], Response::HTTP_SEE_OTHER);
    }
}
