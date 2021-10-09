<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class GVIndexController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(): Response{

        return $this->render('gv_index/index.html.twig');
    }

}
