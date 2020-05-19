<?php

namespace App\Form;

use App\Entity\Distributeur;
use App\Entity\Produit;
use App\Entity\Fabricant;
use Doctrine\ORM\EntityRepository;
use App\Repository\FabricantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AddProduitFabType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['user'];
        $builder
            ->add('category', ChoiceType::class, [
                'choices'  => [
                    'Électricité' => 'Électricité',
                    'Plomberie' => 'Plomberie',
                    'Menuiserie' => 'Menuiserie',
                    'Peintre' => 'Peintre',
                    'Couvreur' => 'Couvreur',
                    'Maçonnerie' => 'Maçonnerie',
                    'Carreleur' => 'Carreleur',
                    'Paysagiste' => 'Paysagiste',
                    
                ],
            ])
            ->add('type')
            ->add('matiere')
            ->add('image'/* , FileType::class */)
            ->add('content')
            
            ->add('distrib', EntityType::class, array(
                'class' => Distributeur::class,
                'multiple' => true,
                'expanded' => true,
            ))

            ->add('fabric', EntityType::class,[
                // looks for choices from this entity
                'class' => Fabricant::class,
            
                // uses the User.username property as the visible option string
                'choice_label' => 'id',

                // used to render a select box, check boxes or radios
                // 'multiple' => false,
                // 'expanded' => false,
                'query_builder' => function (EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('fabric')
                        ->where('fabric.user = :user')
                        ->setParameter('user', $user);
                },

            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
            'user' => null,
        ]);
    }
}
