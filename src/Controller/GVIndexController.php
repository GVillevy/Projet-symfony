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
    public function home(UserPasswordHasherInterface $passwordHasher){
        /*
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $user->setEmail('t.delias22@gmail.com');
        $user->setPassword($passwordHasher->hashPassword($user, 'admin'));
        //$user->setRole(['ROLE_ADMIN']);
        $em->persist($user);

        $em->flush();*/
        return $this->render('gv_index/index.html.twig');
    }

}
