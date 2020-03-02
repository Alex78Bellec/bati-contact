<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Produit;
use App\Form\ContactType;
use Doctrine\DBAL\Types\TextType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Notification\ContactNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
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
     * @Route("/contact", name="bati_contact")
     */
    public function contact(Request $request, EntityManagerInterface $manager, ContactNotification $notification)
    {
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
            'formContact' => $form->createView()
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
     * @Route("/search", name="searchresult")
     */
    public function searchAction()
    {
        return $this->render('general/recherche.html.twig', [
            'controller_name' => 'BaseController',
        ]);
    }
}
