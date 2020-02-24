<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Produit;
use App\Entity\Fabricant;
use App\Entity\Distributeur;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SuperAdminController extends AbstractController
{
    /**
     * @Route("/superadmin", name="super_admin")
     */
    public function superAdmin()
    {
        $produit = $this->getDoctrine()->getRepository(Produit::class)->findBy(
            [],
        );

        $fabricants = $this->getDoctrine()->getRepository(Fabricant::class)->findAll();
        $distributeurs = $this->getDoctrine()->getRepository(Distributeur::class)->findAll();
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('admin/superadmin.html.twig', [
            'produits' => $produit,
            'fabricants' => $fabricants,
            'distributeurs' => $distributeurs,
            'users' => $users
        ]);
    }


}
