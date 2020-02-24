<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
    
}
