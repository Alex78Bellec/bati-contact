<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Fabricant;
use App\Entity\Distributeur;
use App\Form\RegistrationFabType;
use App\Form\RegistrationDistType;
use App\Form\RegistrationUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
* @Route("/inscriptionUser", name="security_registrationUser") 
*/

    public function registrationUser(Request $request, EntityManagerInterface $manager,UserPasswordEncoderInterface $encoder) 
    {   
        
        $user = new User();
        $form = $this->createForm(RegistrationUserType::class , $user ); 

        $form->handleRequest($request);

        
        if($form->isSubmitted() && $form->isValid()) //Si le formulaire est validé et que tous les champs sont correctes on entre dans la condition
        {   $hash = $encoder->encodePassword($user, $user->getPassword()); 
            $user->setPassword($hash);
            $user->setConfirmpassword($hash); // On hash le mot de passe et le confirme mot de passe pour ne pas qu'il soit rentré en dur dans la BDD
            $user->setRoles(["ROLE_USER"]); 
            $manager->persist($user);  // on fait persisiter dans le temps l'utilisateur, on dit à symfony , prépare toi à la sauvegarder         
            $manager->flush(); 
            return $this->redirectToRoute('login'); // on redirige vers la page login après inscription
        }


        return $this->render('security/registrationUser.html.twig', [
            'controller_name' => 'SecurityController',
            'formUser' => $form->createView(), //On créer la vu du formulaire pour l'intégrer dans la vu twig
            
            ]);

    }


/**
* @Route("/ajoutFab", name="security_addFab") 
*/

public function registrationFab(Request $request, EntityManagerInterface $manager) 
{       $user = new User();
        $fab = new Fabricant();
        $formFab = $this->createForm(RegistrationFabType::class , $fab ); 
        $formFab->handleRequest($request);

       
        
        if($formFab->isSubmitted() && $formFab->isValid()) //Si le formulaire est validé et que tous les champs sont correctes on entre dans la condition
        {     
            $manager->persist($fab);   
            $user = $this->getUser();
            $fab->setUser($user);
            $user->setRoles(["ROLE_FAB"]);
            $manager->flush(); 
           return $this->redirectToRoute('prod'); // on redirige vers la page login après 
        }

    return $this->render('security/addFab.html.twig', [
        'controller_name' => 'SecurityController',
        'formFab' => $formFab->createView(),
    ]);
}



/**
* @Route("/ajoutDist", name="security_addDist") 
*/

    public function registrationDist(Request $request, EntityManagerInterface $manager) 
    {   $user = new User();
        $dist = new Distributeur();
        $formDist = $this->createForm(RegistrationDistType::class , $dist); 
        $formDist->handleRequest($request);

       
        
        if($formDist->isSubmitted() && $formDist->isValid()) //Si le formulaire est validé et que tous les champs sont correctes on entre dans la condition
        {  
            $manager->persist($dist);  
            $user = $this->getUser();
            $dist->setUser($user);  
            $user->setRoles(["ROLE_DIST"]);
            $manager->flush(); 
            return $this->redirectToRoute('prod'); // on redirige vers la page login après FabOrDist
        }

        return $this->render('security/addDist.html.twig', [
            'controller_name' => 'SecurityController',
            'formDist' => $formDist->createView(),
        ]);
    }

/**
* @Route("/fabricantOUdistributeurs", name="FabOrDist") 
*/
public function FabOrDist()
{

return $this->render('security/FabOrDist.html.twig',[
    'controller_name' => 'SecurityController',
    ]);
}

/**
* @Route("/login", name="login") 
*/
    public function login(Request $request,AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
          $lastUsername = $authenticationUtils->getLastUsername();
          
      

    return $this->render('security/login.html.twig', array(
        'last_username' => $lastUsername,
        'error'         => $error,
    ));
 

    
    }

/**
* @Route("/profil", name="profil") 
*/
public function profil()
{

return $this->render('security/profil.html.twig',[
    'controller_name' => 'SecurityController',
    
    ]);

}

/**
* @Route("\deconnexion", name="logout") 
*/
    public function logout()
    {
        // cette fonction ne retourne rien, il nous suffit d'avoir une route pour la deconnexion, une fois créer, modifier le providers form_login
    }
}
