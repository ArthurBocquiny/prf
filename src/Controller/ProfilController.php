<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProfilController extends Controller
{
    /**
     * @Route("/profil")
     */
    public function index(User $profil)
    {
        return $this->render(
                'profil/index.html.twig',
                [
                    'profil' => $profil
                ]
        );
    }
}
