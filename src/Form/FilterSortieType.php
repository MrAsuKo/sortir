<?php

namespace App\Form;

use App\Entity\Campus;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('campus', EntityType::class,
                [
                    'label'=>'Campus : ',
                    'class'=> Campus::class,
                    'choice_label' => 'nom',
                    "multiple" => false,
                ])
            ->add('nom', )
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
            ->add('Rechercher', SubmitType::class)

        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
