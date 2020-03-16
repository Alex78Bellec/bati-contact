<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Fabricant;
use App\Repository\FabricantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\FormBuilderInterface;
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
            ->add('image', FileType::class)
            ->add('content')
/*             ->add('fabric', HiddenType::class, [
                'attr' => '',
            ]);
 */
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
            'attr' => ['id' => 'addProduitFab-form']
        ]);
    }
}
