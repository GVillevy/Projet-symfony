<?php

namespace App\Controller;

use App\Entity\PlayOfTheWeek;
use App\Form\PlayOfTheWeekType;
use App\Repository\PlayOfTheWeekRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/potw')]
class PlayOfTheWeekController extends AbstractController
{
    #[Route('/', name: 'admin_potw_index', methods: ['GET'])]
    public function index(PlayOfTheWeekRepository $playOfTheWeekRepository): Response
    {
        return $this->render('play_of_the_week/index.html.twig', [
            'play_of_the_weeks' => $playOfTheWeekRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_potw_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $playOfTheWeek = new PlayOfTheWeek();
        $form = $this->createForm(PlayOfTheWeekType::class, $playOfTheWeek);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($playOfTheWeek);
            $entityManager->flush();

            return $this->redirectToRoute('admin_potw_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('play_of_the_week/new.html.twig', [
            'play_of_the_week' => $playOfTheWeek,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_potw_show', methods: ['GET'])]
    public function show(PlayOfTheWeek $playOfTheWeek): Response
    {
        return $this->render('play_of_the_week/show.html.twig', [
            'play_of_the_week' => $playOfTheWeek,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_potw_edit', methods: ['GET','POST'])]
    public function edit(Request $request, PlayOfTheWeek $playOfTheWeek): Response
    {
        $form = $this->createForm(PlayOfTheWeekType::class, $playOfTheWeek);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_potw_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('play_of_the_week/edit.html.twig', [
            'play_of_the_week' => $playOfTheWeek,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_potw_delete', methods: ['POST'])]
    public function delete(Request $request, PlayOfTheWeek $playOfTheWeek): Response
    {
        if ($this->isCsrfTokenValid('delete'.$playOfTheWeek->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($playOfTheWeek);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_potw_index', [], Response::HTTP_SEE_OTHER);
    }
}
