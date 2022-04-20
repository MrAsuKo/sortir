<?php

namespace App\Form;

use App\Entity\Groupe;
use App\Entity\Participant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('membres', EntityType::class,
                [
                    'label'     =>  'Membres : ',
                    'class'     =>  Participant::class,
                    'choice_label'  =>  'nom',
                    'mapped' => false,

                    'attr'  =>
                        [
                            'class' => 'form-select form-select-sm',
                        ],
                    'multiple' => true

                ]
            )
            ->add('creer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Groupe::class,
        ]);
    }
}
