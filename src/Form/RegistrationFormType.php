<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Participant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mail',
                TextType::class,
                [
                    'label'         => "Mail : ",
                    "label_attr"    =>
                        [
                            "class" => "register_label"
                        ],
                    "attr" =>
                        [
                            "class" => "register_input form-control form-control-sm"
                        ]
                ])
            /*
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])

            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
*/
            ->add('nom',
                TextType::class,
                [
                    'label'     => "Nom : ",
                    "label_attr"=>
                        [
                            "class" => "register_label"
                        ],
                    "attr" =>
                        [
                            "class" => "register_input form-control form-control-sm"
                        ]
                ])
            ->add('prenom',
                TextType::class,
                [
                    'label'     => "Prenom : ",
                    "label_attr"=>
                        [
                            "class" => "register_label"
                        ],
                    "attr" =>
                        [
                            "class" => "register_input form-control form-control-sm"
                        ]
                ])
            //->add('telephone')
            ->add('campus',
                EntityType::class,
                [
                    'class'         => Campus::class,
                    'choice_label'  => 'nom',
                    'mapped'        => false,
                    'label'         => "Campus : ",

                    "label_attr" =>
                        [
                            "class" => "register_label"
                        ],
                    "attr" =>
                        [
                            "class" => "register_input form-select form-select-sm"
                        ]
                ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
