<?php

namespace App\Form;

use App\Entity\Distributeur;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DistribCollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['user'];
        $builder
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
        ;

        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        
        $resolver->setDefaults([
            'data_class' => Distributeur::class,
            'user' => null,
            'inherit_data' => true,

        ]);
    }
}
