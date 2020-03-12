<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Contact;
use App\Entity\Produit;
use App\Entity\Fabricant;
use App\Form\ContactType;
use App\Entity\Distributeur;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Notification\ContactNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            $prod = $produit->getMatiere();
            $prod = $produit->getType();
            $prod = $produit->getDistrib();

            $allProduits = $produitRepository->searchProduit($prod);
            return $this->redirectToRoute('searchresult');
        }
        else
        {
            $allProduits = $produitRepository->findAll();
        }

        
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
        $produits = $this->getDoctrine()->getRepository(Produit::class)->findAll();

        $categ = $produit->getCategory();
        $distinctCategories = $produitRepository->distinctCategories($categ);
        
        return $this->render('home/index.html.twig', [

            'articles' =>$articles,
            'formSearch'=>$formSearch->createView(),
            'allproduits'=>$allProduits,
            'produits'=>$produits,
            'produitz'=>$distinctCategories,

        ]);
        
    }

    /**
     * @Route("/distributeur", name="distrib")
     */
    public function distribiteur(ProduitRepository $produitRepository, Request $request)
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

        $distributeurs = $this->getDoctrine()->getRepository(Distributeur::class)->findAll();

        return $this->render('general/listedistrib.html.twig', [
            'formSearch'=>$formSearch->createView(),
            'allproduits'=>$allProduits,
            'distributeurs' => $distributeurs,
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
            $prod = $produit->getMatiere();
            $prod = $produit->getType();

            $allProduits = $produitRepository->searchProduit($prod);
            return $this->redirectToRoute('searchresult');
        }
        else
        {
            $allProduits = $produitRepository->findAll();
        }

        $fabricants = $this->getDoctrine()->getRepository(Fabricant::class)->findAll();

        return $this->render('general/listefabricants.html.twig', [
            'formSearch'=>$formSearch->createView(),
            'allproduits'=>$allProduits,
            'fabricants' => $fabricants,
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
            $prod = $produit->getMatiere();
            $prod = $produit->getType();

            $allProduits = $produitRepository->searchProduit($prod);
            return $this->redirectToRoute('searchresult');
        }
        else
        {
            $allProduits = $produitRepository->findAll();
        }
///////////////////////////

        $products = $produitRepository->findProduct();


/////////////////////////

        return $this->render('general/produit.html.twig', [
            'formSearch'=>$formSearch->createView(),
            'allproduits'=>$allProduits,
            'products' => $products,

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
            $prod = $produit->getMatiere();
            $prod = $produit->getType();

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
            $prod = $produit->getMatiere();
            $prod = $produit->getType();

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
                    ->add('type',TextType::class,array('attr' => array('class' => 'form-control')))
                    ->getForm();

        $formSearch->handleRequest($request);

        if($formSearch->isSubmitted() && $formSearch->isValid())
        {
            $prod = $produit->getCategory();
            $prod = $produit->getMatiere();
            $prod = $produit->getType();
            
            $allProduits = $produitRepository->searchProduit($prod);  
        }
        else
        {
            $allProduits = $produitRepository->findAll();
        }

        return $this->render('general/recherche.html.twig', [
            'formSearch'=>$formSearch->createView(),
            'allproduits'=>$allProduits,
        ]);
    }

    /**
     * @Route("/article/{id}", name="articlePrecis")
     */ 
    public function voirArticle($id, Request $request, ProduitRepository $produitRepository)
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
        $articles = $manager->find(Article::class, $id);

            return $this->render('general/articlePrecis.html.twig', [

            'articles' => $articles,
            'formSearch'=>$formSearch->createView(),
            'allproduits'=>$allProduits,
        ]);
    }


    /**
     * @Route("/produitCat/{cat}", name="produitCat")
     */ 
    public function produitParCate($cat, Request $request, ProduitRepository $produitRepository)
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

        $category = $produitRepository->findOneBy([
            'category' => $cat
        ]);

        /* $produitCat = $category->getCategory(); */
        $produitCat = $produitRepository->findBy(array('category' => $cat),);



            return $this->render('general/produitCat.html.twig', [
        
            'title'=>$cat,
            'produitCat'=>$produitCat,
            'formSearch'=>$formSearch->createView(),
            'allproduits'=>$allProduits,
        ]);
    }


    /**
     * @Route("/produit/{id}", name="produitPrecis")
     */ 
    public function voirProduit($id, Request $request, ProduitRepository $produitRepository)
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
        $produits = $manager->find(Produit::class, $id);

            return $this->render('general/produitPrecis.html.twig', [

            'produits' => $produits,
            'formSearch'=>$formSearch->createView(),
            'allproduits'=>$allProduits,
        ]);
    }


}
