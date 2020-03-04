<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Produit;
use App\Form\ContactType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Notification\ContactNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{

    /**
     * @Route("/", name="index")
     */
    public function index(ProduitRepository $produitRepository, Request $request)
    {
        $produit = New Produit;
        $formSearch = $this->createFormBuilder($produit)
                    ->add('category',TextType::class,array('attr' => array('class' => 'form-control')))
                    ->getForm();

        $formSearch->handleRequest($request);

        if($formSearch->isSubmitted() && $formSearch->isValid())
        {
            $prod = $produit->getCategory();
            $allProduits = $produitRepository->searchProduit($prod);
            return $this->redirectToRoute('searchresult');
        }
        else
        {
            $allProduits = $produitRepository->findAll();
        }

        return $this->render('home/index.html.twig', [
            'formSearch'=>$formSearch->createView(),
            'allproduits'=>$allProduits,
        ]);
    }

    /**
     * @Route("/distributeur", name="distrib")
     */
    public function marques(ProduitRepository $produitRepository, Request $request)
    {
        $produit = New Produit;
        $formSearch = $this->createFormBuilder($produit)
                    ->add('category',TextType::class,array('attr' => array('class' => 'form-control')))
                    ->getForm();

        $formSearch->handleRequest($request);

        if($formSearch->isSubmitted() && $formSearch->isValid())
        {
            $prod = $produit->getCategory();
            $allProduits = $produitRepository->searchProduit($prod);
            return $this->redirectToRoute('searchresult');
        }
        else
        {
            $allProduits = $produitRepository->findAll();
        }

        return $this->render('general/listedistrib.html.twig', [
            'formSearch'=>$formSearch->createView(),
            'allproduits'=>$allProduits,
        ]);
    }

    /**
     * @Route("/fabricants", name="fabricants")
     */
    public function fabricants(ProduitRepository $produitRepository, Request $request)
    {
        $produit = New Produit;
        $formSearch = $this->createFormBuilder($produit)
                    ->add('category',TextType::class,array('attr' => array('class' => 'form-control')))
                    ->getForm();

        $formSearch->handleRequest($request);

        if($formSearch->isSubmitted() && $formSearch->isValid())
        {
            $prod = $produit->getCategory();
            $allProduits = $produitRepository->searchProduit($prod);
            return $this->redirectToRoute('searchresult');
        }
        else
        {
            $allProduits = $produitRepository->findAll();
        }


        return $this->render('general/listefabricants.html.twig', [
            'formSearch'=>$formSearch->createView(),
            'allproduits'=>$allProduits,
        ]);
    }

    /**
     * @Route("/produit", name="prod")
     */
    public function produit(ProduitRepository $produitRepository, Request $request)
    {
        $produit = New Produit;
        $formSearch = $this->createFormBuilder($produit)
                    ->add('category',TextType::class,array('attr' => array('class' => 'form-control')))
                    ->getForm();

        $formSearch->handleRequest($request);

        if($formSearch->isSubmitted() && $formSearch->isValid())
        {
            $prod = $produit->getCategory();
            $allProduits = $produitRepository->searchProduit($prod);
            return $this->redirectToRoute('searchresult');
        }
        else
        {
            $allProduits = $produitRepository->findAll();
        }

        return $this->render('general/produit.html.twig', [
            'formSearch'=>$formSearch->createView(),
            'allproduits'=>$allProduits,
        ]);
    }

    /**
     * @Route("/contact", name="bati_contact")
     */
    public function contact(Request $request, EntityManagerInterface $manager, ContactNotification $notification, ProduitRepository $produitRepository)
    {
        $produit = New Produit;
        $formSearch = $this->createFormBuilder($produit)
                    ->add('category',TextType::class,array('attr' => array('class' => 'form-control')))
                    ->getForm();

        $formSearch->handleRequest($request);

        if($formSearch->isSubmitted() && $formSearch->isValid())
        {
            $prod = $produit->getCategory();
            $allProduits = $produitRepository->searchProduit($prod);
            return $this->redirectToRoute('searchresult');
        }
        else
        {
            $allProduits = $produitRepository->findAll();
        }

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $notification->notify($contact);
            
            $this->addFlash('success', 'Votre Email a bien été envoyé');

            $manager->persist($contact); // on prépare l'insertion
            $manager->flush(); // on execute l'insertion

        }
        
        return $this->render("contact/nous-contacter.html.twig", [
            'formContact' => $form->createView(),
            'formSearch'=>$formSearch->createView(),
            'allproduits'=>$allProduits,
        ]);
    }

    /**
     * @Route("/contact-pros", name="contactPros")
     */
    public function contactpros(ProduitRepository $produitRepository, Request $request)
    {
        $produit = New Produit;
        $formSearch = $this->createFormBuilder($produit)
                    ->add('category',TextType::class,array('attr' => array('class' => 'form-control')))
                    ->getForm();

        $formSearch->handleRequest($request);

        if($formSearch->isSubmitted() && $formSearch->isValid())
        {
            $prod = $produit->getCategory();
            $allProduits = $produitRepository->searchProduit($prod);
            return $this->redirectToRoute('searchresult');
        }
        else
        {
            $allProduits = $produitRepository->findAll();
        }

        return $this->render('contact/contact-pros.html.twig', [
            'formSearch'=>$formSearch->createView(),
            'allproduits'=>$allProduits,
        ]);
    }

    /**
     * @Route("/search", name="searchresult", methods={"GET","POST"})
     */ 
    public function searchAction(ProduitRepository $produitRepository, Request $request): Response
    {

        $produit = New Produit;
        $formSearch = $this->createFormBuilder($produit)
                    ->add('category',TextType::class,array('attr' => array('class' => 'form-control')))
                    ->getForm();

/*         $formType = $this->createFormBuilder($produit)
                    ->add('type',TextType::class,array('attr' => array('class' => 'form-control')))
                    ->getForm(); */

        $formSearch->handleRequest($request);
        /* $formType->handleRequest($request); */


        if($formSearch->isSubmitted() && $formSearch->isValid())
        {
            $prod = $produit->getCategory();
            /* $type = $produit->getType(); */
            $allProduits = $produitRepository->searchProduit($prod);  
            /* $allTypes = $produitRepository->searchType($type); */ 
        }
        else
        {
            $allProduits = $produitRepository->findAll();
            $allTypes = $produitRepository->findAll();
        }

        return $this->render('general/recherche.html.twig', [
            'formSearch'=>$formSearch->createView(),
            /* 'formType'=>$formType->createView(), */
            'allproduits'=>$allProduits,
            /* 'alltypes'=>$allTypes, */
        ]);
    }
}
