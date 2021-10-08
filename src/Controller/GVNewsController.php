<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GVNewsController extends AbstractController
{
    #[Route('/news', name: 'news')]
    public function index(): Response
    {
        return $this->render('gv_news/index.html.twig', [
            'controller_name' => 'GVNewsController',
        ]);
    }
}
