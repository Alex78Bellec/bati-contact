<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Produit;
use App\Entity\Fabricant;
use App\Entity\Distributeur;
use App\Form\AddProduitFabType;
use App\Form\RegistrationFabType;
use App\Form\RegistrationDistType;
use App\Form\RegistrationUserType;
use App\Repository\UserRepository;
use App\Repository\ProduitRepository;
use App\Repository\FabricantRepository;
use App\Form\AddRegistrationProduitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/security", name="security")
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

            $allProduits = $produitRepository->searchProduit($prod);
            return $this->redirectToRoute('searchresult');
        }
        else
        {
            $allProduits = $produitRepository->findAll();
        }


        return $this->render('security/index.html.twig', [
            'formSearch'=>$formSearch->createView(),
            'allproduits'=>$allProduits,
        ]);
    }


/**
* @Route("/inscriptionUser", name="security_registrationUser") 
*/

    public function registrationUser(Request $request, EntityManagerInterface $manager,UserPasswordEncoderInterface $encoder, ProduitRepository $produitRepository) 
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
        
        $user = new User();
        $form = $this->createForm(RegistrationUserType::class , $user ); 

        $form->handleRequest($request);

        
        if($form->isSubmitted() && $form->isValid()) //Si le formulaire est validé et que tous les champs sont correctes on entre dans la condition
        {   $hash = $encoder->encodePassword($user, $user->getPassword()); 
            $user->setPassword($hash);
            $user->setConfirmpassword($hash); // On hash le mot de passe et le confirme mot de passe pour ne pas qu'il soit rentré en dur dans la BDD
            $user->setRoles(['ROLE_USER']); 
            $manager->persist($user);  // on fait persisiter dans le temps l'utilisateur, on dit à symfony , prépare toi à la sauvegarder         
            $manager->flush(); 
            return $this->redirectToRoute('login'); // on redirige vers la page login après inscription
        }


        return $this->render('security/registrationUser.html.twig', [
            'controller_name' => 'SecurityController',
            'formUser' => $form->createView(), //On créer la vu du formulaire pour l'intégrer dans la vu twig
            'formSearch'=>$formSearch->createView(),
            'allproduits'=>$allProduits,
            ]);

    }


/**
* @Route("/ajoutFab", name="security_addFab") 
*/

public function registrationFab(Request $request, EntityManagerInterface $manager, ProduitRepository $produitRepository) 
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


        $user = new User();
        $fab = new Fabricant();
        $formFab = $this->createForm(RegistrationFabType::class , $fab ); 
        $formFab->handleRequest($request);

        
        if($formFab->isSubmitted() && $formFab->isValid()) //Si le formulaire est validé et que tous les champs sont correctes on entre dans la condition
        {     
            $manager->persist($fab);   
            $user = $this->getUser();
            $fab->setUser($user);
            if($this-> isGranted('ROLE_USER', $user))
            { 

                $user->setRoles(['ROLE_FAB']);
                
            }

            

            $manager->flush(); 
           return $this->redirectToRoute('prod'); // on redirige vers la page produit après 
        }

    return $this->render('security/addFab.html.twig', [
        'controller_name' => 'SecurityController',
        'formFab' => $formFab->createView(),
        'formSearch'=>$formSearch->createView(),
        'allproduits'=>$allProduits,
    ]);
}


/**
* @Route("/ajoutDist", name="security_addDist") 
*/

    public function registrationDist(Request $request, EntityManagerInterface $manager, ProduitRepository $produitRepository) 
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
        
        
        $user = new User();
        $dist = new Distributeur();
        $formDist = $this->createForm(RegistrationDistType::class , $dist); 
        $formDist->handleRequest($request);

        
        if($formDist->isSubmitted() && $formDist->isValid()) //Si le formulaire est validé et que tous les champs sont correctes on entre dans la condition
        {  
            $manager->persist($dist);  
            $user = $this->getUser();

            $dist->setUser($user);  

            $dist->setUser($user);

            if($this-> isGranted('ROLE_USER', $user)){ 
            $user->setRoles(['ROLE_DIST']);
            }
            $manager->flush(); 
                return $this->redirectToRoute('prod'); // on redirige vers la page produit après FabOrDist
        }

        return $this->render('security/addDist.html.twig', [
            'controller_name' => 'SecurityController',
            'formDist' => $formDist->createView(),
            'formSearch'=>$formSearch->createView(),
            'allproduits'=>$allProduits,
        ]);
    }

/**
* @Route("/fabricantOUdistributeurs", name="FabOrDist") 
*/
public function FabOrDist(ProduitRepository $produitRepository, Request $request)
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

return $this->render('security/FabOrDist.html.twig',[
    'formSearch'=>$formSearch->createView(),
    'allproduits'=>$allProduits,
    ]);
}

/**
* @Route("/login", name="login") 
*/
    public function login(Request $request,AuthenticationUtils $authenticationUtils, ProduitRepository $produitRepository)
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


        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();


    return $this->render('security/login.html.twig', array(
        'last_username' => $lastUsername,
        'error'         => $error,
        'formSearch'=>$formSearch->createView(),
        'allproduits'=>$allProduits,
    ));


    
    }
    // **************************** PROFIL DISTRIBUTEUR **************************** //
/**
* @Route("/profilDist/{id}", name="profilDist") 
*/
public function profilDist($id, ProduitRepository $produitRepository, Request $request)
{

    $produit = New Produit;
        $formSearch = $this->createFormBuilder($produit)
                    ->add('category',TextType::class,array('attr' => array('class' => 'form-control')))
                    ->getForm();

        $formSearch->handleRequest($request);

        $repository = $this->getDoctrine()->getRepository(Distributeur::class);
        $distributeurs = $repository->findAll();

        $manager = $this->getDoctrine()->getManager();
        $distributeur = $manager->find(Distributeur::class, $id);


        
        $repository = $this->getDoctrine()->getRepository(Produit::class);
        $produits = $repository->findAll();

        $produits = new Produit;
        $categorys = $produits->getCategory();


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


return $this->render('security/profilDist.html.twig',[
    'formSearch'=>$formSearch->createView(),
    'allproduits'=>$allProduits,
    'produits' => $produits,
    'distributeurs' => $distributeurs,

    ]);

}


 /**
     * @Route("/profilDist/update_Profildistrib/{id}", name="update_Profildistrib")
     */ 
    public function editDistributeur($id, Request $request, ProduitRepository $produitRepository)
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


        $repository = $this->getDoctrine()->getRepository(Distributeur::class);
        $distributeurs = $repository->findAll();

        $manager = $this->getDoctrine()->getManager();
        $distributeur = $manager->find(Distributeur::class, $id);

        $form = $this->createForm(RegistrationDistType::class, $distributeur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($distributeur);

            $manager->flush();

            $this->addFlash('success', 'Les modifications ont été effectuées ! ');
            return $this->redirectToRoute('prod');
        }

        return $this->render('security/addDist.html.twig', [
            'distributeurs' => $distributeurs,
            'formDist' => $form->createView(),
            'formSearch'=>$formSearch->createView(),
            'allproduits'=>$allProduits,
        ]);
    }


      //************* FABRICANT PROFIL *****************/

/**
* @Route("/profilFab/{id}", name="profilFab") 
*/
public function profilFab($id,ProduitRepository $produitRepository, Request $request, FabricantRepository $fabricantRepository)
{
    $user=new User();
    $produit = New Produit;
        $formSearch = $this->createFormBuilder($produit)
                    ->add('category',TextType::class,array('attr' => array('class' => 'form-control')))
                    ->getForm();

        $formSearch->handleRequest($request);

        $repository = $this->getDoctrine()->getRepository(Fabricant::class);
        $fabriquants= $repository->findAll();

        $manager = $this->getDoctrine()->getManager();
        $fabriquants = $manager->find(Fabricant::class, $id);

        
        $repository = $this->getDoctrine()->getRepository(Produit::class);
        $produits = $repository->findAll();

        $produits = new Produit;
        $categorys = $produits->getCategory();


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

        
        /* $user = $this->getUser(); */

        /////////////////////
        $fabricants =$this->getDoctrine()->getRepository(Fabricant::class)->findBy([]);
        $produit = $this->getDoctrine()->getRepository(Produit::class)->findBy([/* 'id' => $user->getId() */]);
////////////////////////////

return $this->render('security/profilFab.html.twig',[
    'produits' => $produits,
    'categorys' => $categorys,
    'users' => $user,
    'formSearch'=>$formSearch->createView(),
    'allproduits'=>$allProduits,
    /* 'fabricants'=>$fabriquants, */
//////////////////////
    'fabricants'=>$fabricants,
    'prods'=>$produit,
//////////////////////
    ]);

}
         

 /**
 * @Route("/profilFab/update_userFab/{id}", name="update_userFab")
 */ 
    public function editUser($id, Request $request, UserPasswordEncoderInterface $encoder, ProduitRepository $produitRepository)
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



        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findAll();

        $manager = $this->getDoctrine()->getManager();
        $user = $manager->find(User::class, $id);

        $form = $this->createForm(RegistrationUserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hash = $encoder->encodePassword($user, $user->getPassword()); 
            $user->setPassword($hash);
            $user->setConfirmpassword($hash);
            $manager->persist($user);

            $manager->flush();

            $this->addFlash('success', 'Les modifications ont été effectuées ! ');
            return $this->redirectToRoute('prod');
        }

        return $this->render('security/registrationUser.html.twig', [
            'users' => $users,
            'formUser' => $form->createView(),
            'formSearch'=>$formSearch->createView(),
            'allproduits'=>$allProduits,
        ]);
    }
             

     /**
     * @Route("/profilFab/updateProfil_fabric/{id}", name="updateProfil_fabric")
     */ 
    public function editProfilFabriquant($id, Request $request, ProduitRepository $produitRepository)
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



        $repository = $this->getDoctrine()->getRepository(Fabricant::class);
        $fabriquants= $repository->findAll();

        $manager = $this->getDoctrine()->getManager();
        $fabriquant = $manager->find(Fabricant::class, $id);

        $form = $this->createForm(RegistrationFabType::class, $fabriquant);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($fabriquant);

            $manager->flush();

            $this->addFlash('success', 'Les modifications ont été effectuées ! ');
            return $this->redirectToRoute('prod');
        }

        return $this->render('security/addFab.html.twig', [
            'fabriquants' => $fabriquants,
            'formFab' => $form->createView(),
            'formSearch'=>$formSearch->createView(),
            'allproduits'=>$allProduits,
        ]);
    }




    /**
     * @Route("/profilFab/add_produitProfilFab/{id}", name="add_produitProfilFab")
     */
    public function addProduit($id,Request $request, ProduitRepository $produitRepository)
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

        $repository = $this->getDoctrine()->getRepository(Produit::class);
        $produits = $repository->findAll();

        
///////////////////



$produits = new Produit;

$fabricantForm =$this->getDoctrine()->getRepository(Fabricant::class)->findBy([]);

///////////////////////

        $categorys = $produits->getCategory();

        
        $form = $this->createForm(AddProduitFabType::class, $produits ,array(
            'user' => $this->getUser(), // On passe le user au formulaire
        ));


        $form->handleRequest($request);
        $manager = $this->getDoctrine()->getManager();


        $repository = $this->getDoctrine()->getRepository(Fabricant::class);
        $fabriquants= $repository->findAll();

        $manager = $this->getDoctrine()->getManager();
        $fabriquant = $manager->find(Fabricant::class, $id);
       // var_dump($produits);

        $fab=new Fabricant();

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($produits);
            $manager->flush();

            $this->addFlash('success', 'Le produit est bien ajouté au site !');
            //return $this->redirectToRoute('super_admin');
        }

        return $this->render('security/ajoutProduitFab.html.twig', [
            'fabriquants' => $fabriquants,
            'produits' => $produits,
            'ProduitFormFab' => $form->createView(),
            'categorys' => $categorys,
            'formSearch'=>$formSearch->createView(),
            'allproduits'=>$allProduits,
            'fabricantForm'=>$fabricantForm,
            
        ]);
    }




    //************************** PRODUIT UPDATE/DELETE ******************************/


      /**
     * @Route("/profilFab/update_produit/{id}", name="update_produitFab")
     */ 
    public function editProduitProfilFab($id, Request $request, ProduitRepository $produitRepository)
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


        $repository = $this->getDoctrine()->getRepository(Produit::class);
        $produits = $repository->findAll();

        // -------------------------------------------------------------------


        $manager = $this->getDoctrine()->getManager();
        $produit = $manager->find(Produit::class, $id);


        // On créé la vue d'un formulaire qui provient du dossier FORM > ContenuType.php 
        $form = $this->createForm(AddRegistrationProduitType::class, $produit);

        // On gère les informations du formulaire
        $form->handleRequest($request); 

        // Conditions du formulaire >> CF l.81/85
        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($produit);

            $manager->flush();

            // Message qui confirme l'action et retour à la route 
            $this->addFlash('success', 'Les modifications ont été effectuées ! ');
            return $this->redirectToRoute('prod');
        } 

        // On renvoie les informations dans la VUE 
            return $this->render('admin/ajoutProduit.html.twig', [

            'produits' => $produits,
            'ProduitForm' => $form->createView(),
            'formSearch'=>$formSearch->createView(),
            'allproduits'=>$allProduits,
        ]);
    }






    /**
     * @Route("/profilFab/supprimer_produit/{id}", name="delete_produitFab")
     */
    public function deleteProduit($id, ProduitRepository $produitRepository, Request $request)
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
        // On récupère l'objet de la BDD en fonction de son *ID
        $produit = $manager->find(Produit::class, $id);

        // Grâce au MANAGER, on supprime l'élément de la BDD
        $manager->remove($produit);
        $manager->flush();

        // On confirme à l'utilisateur que la suppression a bien été effectuée.
        $this->addFlash('success', 'Le produit a bien été supprimé.');
        return $this->redirectToRoute('prod');

        // On renvoie les informations dans la VUE
        return $this->render('admin/superadmin.html.twig',[
            'allproduits'=>$allProduits,
        ]);
    }


    //*************************************************************** */


/**
* @Route("\deconnexion", name="logout") 
*/
    public function logout()
    {
        // cette fonction ne retourne rien, il nous suffit d'avoir une route pour la deconnexion, une fois créer, modifier le providers form_login
    }
}
