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
     * @Route("/marques", name="marques")
     */
    public function marques()
    {
        return $this->render('general/listemarques.html.twig', [
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
    
}
