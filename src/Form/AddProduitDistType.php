<?php

namespace App\Form;

use App\Entity\Distributeur;
use App\Entity\Produit;
use App\Entity\Fabricant;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

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
            ->add('distrib', EntityType::class,[
                // looks for choices from this entity
                'class' => Distributeur::class,
            
                // uses the User.username property as the visible option string
                'choice_label' => 'id',

                // used to render a select box, check boxes or radios
                // 'multiple' => false,
                // 'expanded' => false,
                'query_builder' => function (EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('distrib')
                        ->where('distrib.user = :user')
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
