<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Produit;
use App\Entity\Fabricant;
use App\Entity\Distributeur;
use App\Form\RegistrationFabType;
use App\Form\RegistrationDistType;
use App\Form\RegistrationUserType;
use App\Repository\ProduitRepository;
use App\Form\AddRegistrationProduitType;
use App\Repository\DistributeurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SuperAdminController extends AbstractController
{
    /**
     * @Route("/superadmin", name="super_admin")
     */
    public function superAdmin(ProduitRepository $repo, ProduitRepository $produitRepository, Request $request)
    {
        $produit = New Produit;
        $formSearch = $this->createFormBuilder($produit)
                    ->add('category',TextType::class,array('attr' => array('class' => 'form-control')))
                    ->getForm();

        $formSearch->handleRequest($request);

        if($formSearch->isSubmitted() && $formSearch->isValid())
        {
            $prod = $produit->getCategory();
            $prod = $produit->getMatiere();
            $prod = $produit->getType();
            
            $allProduits = $produitRepository->searchProduit($prod);
            return $this->redirectToRoute('searchresult');
        }
        else
        {
            $allProduits = $produitRepository->findAll();
            /* return $this->redirectToRoute('searchresult'); */
        }


        /* $distribs = $repo->myFindByDistrib('p'); */
        /* $distribs = $repo->findByDistrib('d'); */
/*         $distrib = $produit->getDistrib();
        $allDistrib = $produitRepository->findByDistrib($distrib); */

        $produit = $this->getDoctrine()->getRepository(Produit::class)->findby([]);
        $fabricants = $this->getDoctrine()->getRepository(Fabricant::class)->findAll();
        $distributeurs = $this->getDoctrine()->getRepository(Distributeur::class)->findAll();
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('admin/superadmin.html.twig', [
            'produits' => $produit,
            'fabricants' => $fabricants,
            'distributeurs' => $distributeurs,
            'users' => $users,
            'formSearch'=>$formSearch->createView(),
            'allproduits'=>$allProduits,
            /* 'alldistribs'=>$allDistrib, */
        ]);
    }

//-------------------PRODUIT--------------------------
    /**
     * @Route("/superadmin/ajout_produit", name="add_produit")
     */
    public function addProduit(Request $request, ProduitRepository $produitRepository)
    {
        $produit = New Produit;
        $formSearch = $this->createFormBuilder($produit)
                    ->add('category',TextType::class,array('attr' => array('class' => 'form-control')))
                    ->getForm();

        $formSearch->handleRequest($request);

        if($formSearch->isSubmitted() && $formSearch->isValid())
        {
            $prod = $produit->getCategory();
            $prod = $produit->getMatiere();
            $prod = $produit->getType();

            $allProduits = $produitRepository->searchProduit($prod);
            return $this->redirectToRoute('searchresult');
        }
        else
        {
            $allProduits = $produitRepository->findAll();
        }


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
            return $this->redirectToRoute('super_admin');
        }

        return $this->render('admin/ajoutProduit.html.twig', [
            'produits' => $produits,
            'ProduitForm' => $form->createView(),
            'categorys' => $categorys,
            'formSearch'=>$formSearch->createView(),
            'allproduits'=>$allProduits,
        ]);
    }

    /**
     * @Route("/superadmin/update_produit/{id}", name="update_produit")
     */ 
    public function editProduit($id, Request $request, ProduitRepository $produitRepository)
    { 
        $produit = New Produit;
        $formSearch = $this->createFormBuilder($produit)
                    ->add('category',TextType::class,array('attr' => array('class' => 'form-control')))
                    ->getForm();

        $formSearch->handleRequest($request);

        if($formSearch->isSubmitted() && $formSearch->isValid())
        {
            $prod = $produit->getCategory();
            $prod = $produit->getMatiere();
            $prod = $produit->getType();

            $allProduits = $produitRepository->searchProduit($prod);
            return $this->redirectToRoute('searchresult');
        }
        else
        {
            $allProduits = $produitRepository->findAll();
        }


        $repository = $this->getDoctrine()->getRepository(Produit::class);
        $produits = $repository->findAll();

        // -------------------------------------------------------------------


        $manager = $this->getDoctrine()->getManager();
        $produit = $manager->find(Produit::class, $id);


        // On créé la vue d'un formulaire qui provient du dossier FORM > ContenuType.php 
        $form = $this->createForm(AddRegistrationProduitType::class, $produit);

        // On gère les informations du formulaire
        $form->handleRequest($request); 

        // Conditions du formulaire >> CF l.81/85
        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($produit);

            $manager->flush();

            // Message qui confirme l'action et retour à la route 
            $this->addFlash('success', 'Les modifications ont été effectuées ! ');
            return $this->redirectToRoute('super_admin');
        } 

        // On renvoie les informations dans la VUE 
            return $this->render('admin/ajoutProduit.html.twig', [

            'produits' => $produits,
            'ProduitForm' => $form->createView(),
            'formSearch'=>$formSearch->createView(),
            'allproduits'=>$allProduits,
        ]);
    }

    /**
     * @Route("/superadmin/supprimer_produit/{id}", name="delete_produit")
     */
    public function deleteProduit($id, ProduitRepository $produitRepository, Request $request)
    {
        $produit = New Produit;
        $formSearch = $this->createFormBuilder($produit)
                    ->add('category',TextType::class,array('attr' => array('class' => 'form-control')))
                    ->getForm();

        $formSearch->handleRequest($request);

        if($formSearch->isSubmitted() && $formSearch->isValid())
        {
            $prod = $produit->getCategory();
            $prod = $produit->getMatiere();
            $prod = $produit->getType();

            $allProduits = $produitRepository->searchProduit($prod);
            return $this->redirectToRoute('searchresult');
        }
        else
        {
            $allProduits = $produitRepository->findAll();
        }


        $manager = $this->getDoctrine()->getManager();
        // On récupère l'objet de la BDD en fonction de son *ID
        $produit = $manager->find(Produit::class, $id);

        // Grâce au MANAGER, on supprime l'élément de la BDD
        $manager->remove($produit);
        $manager->flush();

        // On confirme à l'utilisateur que la suppression a bien été effectuée.
        $this->addFlash('success', 'Le produit a bien été supprimé.');
        return $this->redirectToRoute('super_admin');

        // On renvoie les informations dans la VUE
        return $this->render('admin/superadmin.html.twig',[
            'allproduits'=>$allProduits,
        ]);
    }

    // -----------------------UTILISATEUR------------------------//

    /**
     * @Route("/superadmin/update_user/{id}", name="update_user")
     */ 
    public function editUser($id, Request $request, UserPasswordEncoderInterface $encoder, ProduitRepository $produitRepository)
    {
        $produit = New Produit;
        $formSearch = $this->createFormBuilder($produit)
                    ->add('category',TextType::class,array('attr' => array('class' => 'form-control')))
                    ->getForm();

        $formSearch->handleRequest($request);

        if($formSearch->isSubmitted() && $formSearch->isValid())
        {
            $prod = $produit->getCategory();
            $prod = $produit->getMatiere();
            $prod = $produit->getType();

            $allProduits = $produitRepository->searchProduit($prod);
            return $this->redirectToRoute('searchresult');
        }
        else
        {
            $allProduits = $produitRepository->findAll();
        }



        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findAll();

        $manager = $this->getDoctrine()->getManager();
        $user = $manager->find(User::class, $id);

        $form = $this->createForm(RegistrationUserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hash = $encoder->encodePassword($user, $user->getPassword()); 
            $user->setPassword($hash);
            $user->setConfirmpassword($hash);
            $manager->persist($user);

            $manager->flush();

            $this->addFlash('success', 'Les modifications ont été effectuées ! ');
            return $this->redirectToRoute('super_admin');
        }

        return $this->render('security/registrationUser.html.twig', [
            'users' => $users,
            'formUser' => $form->createView(),
            'formSearch'=>$formSearch->createView(),
            'allproduits'=>$allProduits,
        ]);
    }

    //------------DISTRIBUTEUR--------------------

    /**
     * @Route("/superadmin/supprimer_distributeur/{id}", name="delete_distrib")
     */
    public function deleteDistributeur($id, ProduitRepository $produitRepository, Request $request)
    {
        $produit = New Produit;
        $formSearch = $this->createFormBuilder($produit)
                    ->add('category',TextType::class,array('attr' => array('class' => 'form-control')))
                    ->getForm();

        $formSearch->handleRequest($request);

        if($formSearch->isSubmitted() && $formSearch->isValid())
        {
            $prod = $produit->getCategory();
            $prod = $produit->getMatiere();
            $prod = $produit->getType();

            $allProduits = $produitRepository->searchProduit($prod);
            return $this->redirectToRoute('searchresult');
        }
        else
        {
            $allProduits = $produitRepository->findAll();
        }


        $manager = $this->getDoctrine()->getManager();
        $distributeur = $manager->find(Distributeur::class, $id);

        $manager->remove($distributeur);
        $manager->flush();

        $this->addFlash('success', 'Le distributeur est bien supprimé');
        return $this->redirectToRoute('super_admin');

        return $this->render('admin/superadmin.html.twig',[
            'formSearch'=>$formSearch->createView(),
            'allproduits'=>$allProduits,
        ]);
    }

    /**
     * @Route("/superadmin/update_distrib/{id}", name="update_distrib")
     */ 
    public function editDtributeur($id, Request $request, ProduitRepository $produitRepository)
    {
        $produit = New Produit;
        $formSearch = $this->createFormBuilder($produit)
                    ->add('category',TextType::class,array('attr' => array('class' => 'form-control')))
                    ->getForm();

        $formSearch->handleRequest($request);

        if($formSearch->isSubmitted() && $formSearch->isValid())
        {
            $prod = $produit->getCategory();
            $prod = $produit->getMatiere();
            $prod = $produit->getType();

            $allProduits = $produitRepository->searchProduit($prod);
            return $this->redirectToRoute('searchresult');
        }
        else
        {
            $allProduits = $produitRepository->findAll();
        }


        $repository = $this->getDoctrine()->getRepository(Distributeur::class);
        $distributeurs = $repository->findAll();

        $manager = $this->getDoctrine()->getManager();
        $distributeur = $manager->find(Distributeur::class, $id);

        $form = $this->createForm(RegistrationDistType::class, $distributeur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($distributeur);

            $manager->flush();

            $this->addFlash('success', 'Les modifications ont été effectuées ! ');
            return $this->redirectToRoute('super_admin');
        }

        return $this->render('security/addDist.html.twig', [
            'distributeurs' => $distributeurs,
            'formDist' => $form->createView(),
            'formSearch'=>$formSearch->createView(),
            'allproduits'=>$allProduits,
        ]);
    }


    //----------FABRIQUANT-------------

    /**
     * @Route("/superadmin/supprimer_fabric/{id}", name="delete_fabric")
     */
    public function deleteFabriquant($id, ProduitRepository $produitRepository, Request $request)
    { 
        $produit = New Produit;
        $formSearch = $this->createFormBuilder($produit)
                    ->add('category',TextType::class,array('attr' => array('class' => 'form-control')))
                    ->getForm();

        $formSearch->handleRequest($request);

        if($formSearch->isSubmitted() && $formSearch->isValid())
        {
            $prod = $produit->getCategory();
            $prod = $produit->getMatiere();
            $prod = $produit->getType();

            $allProduits = $produitRepository->searchProduit($prod);
            return $this->redirectToRoute('searchresult');
        }
        else
        {
            $allProduits = $produitRepository->findAll();
        }


        $manager = $this->getDoctrine()->getManager();
        // On récupère l'objet de la BDD en fonction de son *ID
        $fabriquant = $manager->find(Fabricant::class, $id);

        // Grâce au MANAGER, on supprime l'élément de la BDD
        $manager->remove($fabriquant);
        $manager->flush();

        // On confirme à l'utilisateur que la suppression a bien été effectuée.
        $this->addFlash('success', 'Le fabriquant est bien supprimé');
        return $this->redirectToRoute('super_admin');

        // On renvoie les informations dans la VUE
        return $this->render('admin/superadmin.html.twig',[
            'formSearch'=>$formSearch->createView(),
            'allproduits'=>$allProduits,
        ]);
    }

    /**
     * @Route("/superadmin/update_fabric/{id}", name="update_fabric")
     */ 
    public function editFabriquant($id, Request $request, ProduitRepository $produitRepository)
    {
        $produit = New Produit;
        $formSearch = $this->createFormBuilder($produit)
                    ->add('category',TextType::class,array('attr' => array('class' => 'form-control')))
                    ->getForm();

        $formSearch->handleRequest($request);

        if($formSearch->isSubmitted() && $formSearch->isValid())
        {
            $prod = $produit->getCategory();
            $prod = $produit->getMatiere();
            $prod = $produit->getType();
            
            $allProduits = $produitRepository->searchProduit($prod);
            return $this->redirectToRoute('searchresult');
        }
        else
        {
            $allProduits = $produitRepository->findAll();
        }


        $repository = $this->getDoctrine()->getRepository(Fabricant::class);
        $fabriquants= $repository->findAll();

        $manager = $this->getDoctrine()->getManager();
        $fabriquant = $manager->find(Fabricant::class, $id);

        $form = $this->createForm(RegistrationFabType::class, $fabriquant);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($fabriquant);

            $manager->flush();

            $this->addFlash('success', 'Les modifications ont été effectuées ! ');
            return $this->redirectToRoute('super_admin');
        }

        return $this->render('security/addFab.html.twig', [
            'fabriquants' => $fabriquants,
            'formFab' => $form->createView(),
            'formSearch'=>$formSearch->createView(),
            'allproduits'=>$allProduits,
        ]);
    }
}
