<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Fabricant;
use App\Entity\Distributeur;
use Doctrine\ORM\EntityRepository;
use App\Form\DistribCollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AddProduitDistType extends AbstractType
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
            ->add('fabric')
            
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
