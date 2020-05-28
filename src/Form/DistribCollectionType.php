<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Distributeur;
use App\Form\AddProduitDistType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class DistribCollectionType extends AddProduitDistType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
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
            ->add('fabric')

        ->add('distrib', EntityType::class,[

            'class' => Distributeur::class,

            'choice_label' => 'id',

            'query_builder' => function (EntityRepository $er) use ($user) {
                return $er->createQueryBuilder('distrib')
                    ->where('distrib.user = :user')
                    ->setParameter('user', $user);
            }, 

        ])


        
    ;

/*     $builder->get('distrib')
    ->addModelTransformer(new CallbackTransformer(
        function ($tagsAsArray) {
            // transform the array to a string
            return implode('', $tagsAsArray);
        },
        function ($tagsAsString) {
            // transform the string back to an array
            return explode('', $tagsAsString);
        }
    )); */
        

        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        
        $resolver->setDefaults([
            'data_class' => Produit::class,
            'user' => null,
            /* 'inherit_data' => true, */

        ]);
    }

    public function getParent()
    {
        return AddProduitDistType::class;
    }
}
