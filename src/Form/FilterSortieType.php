<?php

namespace App\Form;

use App\Entity\Campus;

use DateTime;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('nom', TextType::class,
            [
                'required' => false
            ])
            ->add('dateHeureDebut', DateTimeType::class,
                [
                    'label' => 'Entre ',
                    'widget' => 'single_text',
                    'data' => new DateTime('now')
                ])
            ->add('dateHeureFin',DateTimeType::class,[
                'label' => 'Et ',
                'widget' => 'single_text',
                'data' => new DateTime('2026-09-01T15:03:01.012345Z')
            ])

            ->add('organisateur', CheckboxType::class,
                [
                    'label'  => 'Sorties dont je suis l\'organisateur/trice',
                    'required' => false,
                ])
            ->add('participant', CheckboxType::class,
                [
                    'label' => 'Sorties auxquelles je suis inscrit/e ',
                    'required' => false,
                ])
            ->add('inscrit', CheckboxType::class,
                [
                    'label' => 'Sorties auxquelles je ne suis pas inscrit/e',
                    'required' => false,
                ])
            ->add('dateLimiteInscription', CheckboxType::class,
                [
                    'label' => 'Sorties passées',
                    'required' => false,
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
