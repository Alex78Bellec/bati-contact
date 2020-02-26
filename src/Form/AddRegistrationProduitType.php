<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Fabricant;
use App\Entity\Distributeur;
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
            ->add('matiere')
            ->add('fabric')
            ->add('distrib')

        ->add('category', EntityType::class, [
            'class' => Produit::class,
            'choice_value' => function (Produit $category = null) {
                return $category ? $category->getId() : '';
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
