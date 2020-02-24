<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/security", name="security")
     */
    public function index()
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }


/**
* @Route("/inscriptionFab", name="security_registrationFab") 
*/

    public function registrationFab() 
    {
        return $this->render('security/registrationFab.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }


/**
* @Route("/inscriptionDist", name="security_registrationDist") 
*/

    public function registrationDist() 
    {
        return $this->render('security/registrationDist.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

/**
* @Route("/connexion", name="security_login") 
*/
    public function login()
    {
    return $this->render('security/login.html.twig'); 
    }
}
