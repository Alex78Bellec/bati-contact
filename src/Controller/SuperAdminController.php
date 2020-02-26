<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Produit;
use App\Entity\Fabricant;
use App\Entity\Distributeur;
use App\Form\AddRegistrationProduitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SuperAdminController extends AbstractController
{
    /**
     * @Route("/superadmin", name="super_admin")
     */
    public function superAdmin()
    {
        $produit = $this->getDoctrine()->getRepository(Produit::class)->findby([]);
        
        /* $prod = $produit; */
/*         $valeur = '';
        foreach($produit as $key => $value)
        {
            foreach($value as $valeur)
            {
                return $valeur;
            }

        } */

        $fabricants = $this->getDoctrine()->getRepository(Fabricant::class)->findAll();
        $distributeurs = $this->getDoctrine()->getRepository(Distributeur::class)->findAll();
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('admin/superadmin.html.twig', [
            'produits' => $produit,
            'fabricants' => $fabricants,
            'distributeurs' => $distributeurs,
            'users' => $users,
           /*  'valeur'=> $valeur, */

        ]);
    }
    

    /**
     * @Route("/superadmin/ajout_produit", name="add_produit")
     */
    public function addProduit(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Produit::class);
        $produits = $repository->findAll();

        $produits = new Produit;
        $categorys = $produits->getCategory();

        $form = $this->createForm(AddRegistrationProduitType::class, $produits);
        $form->handleRequest($request);

        $manager = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($produits);

            $manager->flush();

            $this->addFlash('success', 'Le produit est bien ajouté au site !');
            return $this->redirectToRoute('add_produit');
        }

        return $this->render('admin/ajoutProduit.html.twig', [
            'produits' => $produits,
            'ProduitForm' => $form->createView(),
            'categorys' => $categorys
        ]);
    }

    /**
     * @Route("/superadmin/modifier_produit", name="edit_produit")
     */
    public function editProduit()
    {
        
    }

    /**
     * @Route("/superadmin/supprimer_produit", name="delete_produit")
     */
    public function deleteProduit()
    {
        
    }

}
