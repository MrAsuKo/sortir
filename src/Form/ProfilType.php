<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Participant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mail',
                TextType::class,
                [
                    'label' => "Mail : ",
                    "label_attr" =>
                        [
                            "class" => "profil_label"
                        ],
                    "attr" =>
                        [
                            "class" => "profil_input"
                        ]
                ]
            )
            ->add('password',
                RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'invalid_message' => 'les mdps ne sont pas identiques',
                    // 'options' => ['attr' => ['class' => 'password-field']],
                    'required'          => true,
                    'first_options'     =>
                        [
                            'label'         => 'Mot de passe',
                            "label_attr"    =>
                                [
                                "class"     => "profil_label"
                                ],
                            "attr"      =>
                                [
                                    "class" => "profil_input"
                                ]
                        ],
                    'second_options'    =>
                        [
                            'label'         => 'Confirmer',
                            "label_attr"    =>
                                [
                                   "class" => "profil_label"
                                ],
                            "attr"      =>
                                [
                                    "class" => "profil_input"
                                ]
                        ],

            ])
            ->add('nom',
                TextType::class,
                [
                    'label'     => "Nom : ",
                    "label_attr"=>
                        [
                            "class" => "profil_label"
                        ],
                    "attr" =>
                        [
                            "class" => "profil_input"
                        ]
                ])
            ->add('prenom',
                TextType::class,
                [
                    'label'         => "Prenom : ",
                    "label_attr"    =>
                        [
                            "class" => "profil_label"
                        ],
                    "attr" =>
                        [
                            "class" => "profil_input"
                        ]
                ])
            ->add('telephone',
                TextType::class,
                [
                    'label'         => "Telephone : ",
                    "label_attr"    =>
                        [
                            "class" => "profil_label"
                        ],
                    "attr" =>
                        [
                            "class" => "profil_input"
                        ]
                ])
            //->add('administrateur')
            //  ->add('actif')
            ->add('pseudo',
                TextType::class,
                [
                    'label'     => "Pseudo : ",
                    "label_attr"=>
                        [
                            "class" => "profil_label"
                        ],
                    "attr"      =>
                        [
                            "class" => "profil_input"
                        ]
                ])
            ->add('campus',
            EntityType::class,
                [
                    'label'     => "Campus : ",
                    "label_attr"=>
                        [
                            "class" => "profil_label"
                        ],
                    "attr" =>
                        [
                            "class" => "profil_input"
                        ],
                    'class'         => Campus::class,
                    'choice_label'  => 'nom',
                    'mapped'        => false
                ])
            ->add('avatar',
            AvatarType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
