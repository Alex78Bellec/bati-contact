<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{

    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'BaseController',
        ]);
    }

    /**
     * @Route("/distributeur", name="distrib")
     */
    public function marques()
    {
        return $this->render('general/listedistrib.html.twig', [
            'controller_name' => 'BaseController',
        ]);
    }

    /**
     * @Route("/fabricants", name="fabricants")
     */
    public function fabricants()
    {
        return $this->render('general/listefabricants.html.twig', [
            'controller_name' => 'BaseController',
        ]);
    }

    /**
     * @Route("/produit", name="prod")
     */
    public function produit()
    {
        return $this->render('general/produit.html.twig', [
            'controller_name' => 'BaseController',
        ]);
    }

    /**
     * @Route("/contact-pros", name="contactPros")
     */
    public function contactpros()
    {
        return $this->render('contact/contact-pros.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }

    /**
     * @Route("/contact-us", name="contactUs")
     */
    public function contactus()
    {
        return $this->render('contact/nous-contacter.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }

    /**
     * @Route("/search", name="searchresult")
     */
    public function rechAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
     

        $motcle=$request->get('motcle');

        $listeDesProduits= $em->getRepository(User::class)->findBy(array('username' => $motcle));
        
        
        
        
        return $this->render('general/recherche.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }

}
