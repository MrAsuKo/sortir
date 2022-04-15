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
        date_default_timezone_set('Europe/Paris');

        $builder
            ->add('campus', EntityType::class,
                [
                    'label'         =>'Campus : ',
                    'class'         => Campus::class,
                    'choice_label'  => 'nom',
                    "multiple"      => false,
                    'attr'          =>
                        [
                            'class' => 'form-select form-select-sm'
                        ]
                ]
                )
            ->add('nom', TextType::class,
            [
                'label'     =>'Nom : ',
                'required'  => false,
                'attr'      =>
                    [
                        'class' => 'form-control form-control-sm'
                    ]
            ])
            ->add('dateHeureDebut', DateTimeType::class,
                [
                    'label'     => 'Entre : ',
                    'widget'    => 'single_text',
                    'data'      => new DateTime('now'),
                    'attr'      =>
                        [
                            'class' => 'form-select form-select-sm'
                        ]
                ])
            ->add('dateHeureFin',DateTimeType::class,[
                'label'     => ' Et : ',
                'widget'    => 'single_text',
                'data'      => new DateTime('+6month'),
                'attr'      =>
                    [
                        'class' => 'form-select form-select-sm'
                    ]
            ])

            ->add('organisateur', CheckboxType::class,
                [
                    'required'  => false,
                    'label'     => 'Sorties dont je suis l\'organisateur/trice',
                    'attr'      =>
                        [
                            'class' => 'form-check-input filter_switch',
                            'role'  => 'switch'
                        ]
                ])
            ->add('participant', CheckboxType::class,
                [
                    'label' => 'Sorties auxquelles je suis inscrit/e',
                    'attr'  =>
                        [
                            'class' => 'form-check-input filter_switch',
                            'role'  => 'switch'
                        ],
                    'required' => false
                ])
            ->add('inscrit', CheckboxType::class,
                [
                    'label' => 'Sorties auxquelles je ne suis pas inscrit/e',
                    'attr'  =>
                        [
                            'class' => 'form-check-input filter_switch',
                            'role'  => 'switch'
                        ],
                    'required' => false
                ])
            ->add('dateLimiteInscription', CheckboxType::class,
                [
                    'label' => 'Sorties passées',
                    'attr'  =>
                        [
                            'class' => 'form-check-input filter_switch',
                            'role'  => 'switch'
                        ],
                    'required' => false
                ])
            ->add('Rechercher', SubmitType::class,
                [
                'attr' => [ 'class' => 'btn btn-secondary bouton_filter']
                ]
            )
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
