<?php

namespace App\Form;

use App\Entity\Propriete;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProprieteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adresse',AdresseType::class)
            ->add('nom')
            ->add('description', TextareaType::class)
            ->add('surface')
            ->add('nbPieces')
            ->add('etage')
            ->add('nbChambres')
            ->add('vendue')
            ->add('prix')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Propriete::class,
        ]);
    }

}
