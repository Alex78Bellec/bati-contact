<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Fabricant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddRegistrationProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category')
            ->add('type')
            ->add('fabricant')
            ->add('distributeur')
            ->add('matiere')
            ->add('fabric')
            ->add('distrib')

        ->add('fabricant', EntityType::class, [
            'class' => Fabricant::class,
            'choice_value' => function (Fabricant $fabricant = null) {
                return $fabricant ? $fabricant->getId() : '';
            },
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
