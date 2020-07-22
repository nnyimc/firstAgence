<?php

namespace App\Form;

use App\Entity\OptionPropriete;
use App\Entity\Propriete;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
            ->add('options', EntityType::class, [
                'class' => OptionPropriete::class,
                'choice_label' => 'intitule',
                'multiple' => 'true'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Propriete::class,
        ]);
    }

}
