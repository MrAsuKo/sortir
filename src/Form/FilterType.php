<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Sortie;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('campusFilter', EntityType::class,
                [
                    'label'=>'Campus : ',
                    'class'=> Campus::class,
                    'choice_label' => 'nom',
                    "multiple" => true,
                    "mapped" => false,
                ])
            ->add('nom', )
            ->add('dateHeureDebut', DateTimeType::class,
                    [
                        'label' => 'Entre ',
                        "mapped" => false
                    ])
            ->add('dateHeureFin',DateTimeType::class,[
                    'label' => 'Et ',
                    "mapped" => false,
                ])

            ->add('organisateur', CheckboxType::class,
                [
                    'label' => 'Sorties dont je suis l\'organisateur/trice',
                    "mapped" => false,
                ])
            ->add('participant', CheckboxType::class,
                [
                    'label' => 'Sorties auxquelles je suis inscrit/e ',
                    "mapped" => false,
                ])
            ->add('inscrit', CheckboxType::class,
                [
                    'label' => 'Sorties auxquelles je ne suis pas inscrit/e',
                    "mapped" => false,
                ])
            ->add('dateLimiteInscription', CheckboxType::class,
                [
                    'label' => 'Sorties passées',
                    "mapped" => false,
                ])
            ->add('Rechercher', SubmitType::class)

        ;


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
