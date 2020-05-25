<?php

namespace App\Form;

use App\Entity\Distributeur;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DistributeurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('marque')
            ->add('siret')
            ->add('ville')
            ->add('email')
            ->add('telephone')
            ->add('user')
            ->add('produits')
        ;

        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        
        $resolver->setDefaults([
            'data_class' => Distributeur::class,


        ]);
    }
}
