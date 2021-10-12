<?php

namespace App\Controller;

use App\Entity\WorldRecords;
use App\Form\WorldRecordsType;
use App\Repository\WorldRecordsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/wr')]
class WorldRecordsController extends AbstractController
{
    #[Route('/', name: 'admin_wr_index', methods: ['GET'])]
    public function index(WorldRecordsRepository $worldRecordsRepository): Response
    {
        return $this->render('world_records/index.html.twig', [
            'world_records' => $worldRecordsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_wr_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $worldRecord = new WorldRecords();
        $form = $this->createForm(WorldRecordsType::class, $worldRecord);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($worldRecord);
            $entityManager->flush();

            return $this->redirectToRoute('admin_wr_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('world_records/new.html.twig', [
            'world_record' => $worldRecord,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_wr_show', methods: ['GET'])]
    public function show(WorldRecords $worldRecord): Response
    {
        return $this->render('world_records/show.html.twig', [
            'world_record' => $worldRecord,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_wr_edit', methods: ['GET','POST'])]
    public function edit(Request $request, WorldRecords $worldRecord): Response
    {
        $form = $this->createForm(WorldRecordsType::class, $worldRecord);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_wr_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('world_records/edit.html.twig', [
            'world_record' => $worldRecord,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_wr_delete', methods: ['POST'])]
    public function delete(Request $request, WorldRecords $worldRecord): Response
    {
        if ($this->isCsrfTokenValid('delete'.$worldRecord->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($worldRecord);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_wr_index', [], Response::HTTP_SEE_OTHER);
    }
}
