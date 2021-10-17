<?php

namespace App\Controller;

use App\Entity\WorldRecord;
use App\Form\WorldRecordType;
use App\Repository\WorldRecordRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/world/record')]
class WorldRecordController extends AbstractController
{
    #[Route('/', name: 'admin_world_record_index', methods: ['GET'])]
    public function index(WorldRecordRepository $worldRecordRepository): Response
    {
        return $this->render('world_record/index.html.twig', [
            'world_records' => $worldRecordRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_world_record_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $worldRecord = new WorldRecord();
        $form = $this->createForm(WorldRecordType::class, $worldRecord);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($worldRecord);
            $entityManager->flush();

            return $this->redirectToRoute('admin_world_record_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('world_record/new.html.twig', [
            'world_record' => $worldRecord,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_world_record_show', methods: ['GET'])]
    public function show(WorldRecord $worldRecord): Response
    {
        return $this->render('world_record/show.html.twig', [
            'world_record' => $worldRecord,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_world_record_edit', methods: ['GET','POST'])]
    public function edit(Request $request, WorldRecord $worldRecord): Response
    {
        $form = $this->createForm(WorldRecordType::class, $worldRecord);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_world_record_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('world_record/edit.html.twig', [
            'world_record' => $worldRecord,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_world_record_delete', methods: ['POST'])]
    public function delete(Request $request, WorldRecord $worldRecord): Response
    {
        if ($this->isCsrfTokenValid('delete'.$worldRecord->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($worldRecord);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_world_record_index', [], Response::HTTP_SEE_OTHER);
    }
}
