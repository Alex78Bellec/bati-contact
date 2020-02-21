<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{

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

}
