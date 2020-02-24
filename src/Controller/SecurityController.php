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
* @Route("/inscription", name="security_registrationFab") 
*/

    public function registrationFab() 
    {
        return $this->render('security/registrationFab', [
            'controller_name' => 'SecurityController',
        ]);
    }


/**
* @Route("/inscription", name="security_registrationFab") 
*/

    public function registrationDist() 
    {
        return $this->render('security/registrationDist', [
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
