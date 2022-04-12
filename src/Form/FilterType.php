<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Sortie;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('campus', EntityType::class,
                [
                    'label'=>'Campus : ',
                    'class'=> Campus::class,
                    'choice_label' => 'nom',
                ])
            ->add('nom')
            ->add('dateHeureDebut', DateTimeType::class,
                    [
                        'label' => 'Entre '
                    ])
            ->add('dateHeureFin',DateTimeType::class,[
                    'label' => 'Et '
                ])

            ->add('organisateur', CheckboxType::class,
                [
                    'label' => 'Sorties dont je suis l\'organisateur/trice'
                ])
            ->add('participant', CheckboxType::class,
                [
                    'label' => 'Sorties auxquelles je suis inscrit/e '
                ])
            ->add('inscrit', CheckboxType::class,
                [
                    'label' => 'Sorties auxquelles je ne suis pas inscrit/e'
                ])
            ->add('dateLimiteInscription', CheckboxType::class,
                [
                    'label' => 'Sorties passées'
                ])


        ;


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
