<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',
                TextType::class,
                [
                    "label" => "Nom : ",
                    "attr"  => ["class" => "form-control form-control-sm"]
                ]
            )
            ->add('dateHeureDebut',
                DateTimeType::class,
                [
                    "label"     => "Date/heure : ",
                    'widget'    => 'single_text',
                    'data'      => new DateTime('now'),
                    'attr' =>
                        [
                            'class' => 'form-select form-select-sm'
                        ]
                ]
            )
            ->add('dateLimiteInscription',
                DateType::class,
                [
                    "label"     => "Limite : ",
                    'widget'    => 'single_text',
                    'data'      => new DateTime('now'),
                    'attr' =>
                        [
                            'class' => 'form-select form-select-sm'
                        ]
                ]
            )
            ->add('nbInscriptionsMax',
                IntegerType::class,
                [
                    "label" => "Places : ",
                    "attr" => ["class" => "form-control form-control-sm"]
                ]
            )
            ->add('duree',
                IntegerType::class,
                [
                    "label"     => "Durée : ",
                    "attr"      => ["class" => "form-control form-control-sm",
                    "onchange"  => "select()"]
                ]
            )
            ->add('infosSortie',
                TextareaType::class,
                [
                    "label" => "Description : ",
                    "attr"  => [ "class" => "form-control form-control-sm"]
                ]
            )
            ->add('lieu',
                EntityType::class,
                [
                    'label'         => 'Lieu : ',
                    'class'         => Lieu::class,
                    'choice_label'  => 'nom',
                    'mapped'        => false,
                    'placeholder'   => '--Lieu--',
                    "attr"          => ["class" => "form-select form-select-sm", "id" => "lieu"]

                ]
            )
            ->add('ville',
                EntityType::class,
                [
                    'label'         => 'Ville : ',
                    'class'         => Ville::class,
                    'choice_label'  => 'nom',
                    'mapped'        => false,
                    'placeholder'   => '--Villes--',
                    'attr'  =>
                        [
                            'class' => 'form-select form-select-sm',
                        ]
                ]
            )
            ->add('enregistrer',
                SubmitType::class,
                [
                    'label'=> 'Enregistrer',
                    "attr" => [ "class" => "btn btn-secondary bouton_sortie"]
                ]
            )
            ->add('publier',
                SubmitType::class,
                [
                    'label'=> 'Publier la sortie',
                    "attr" => [ "class" => "btn btn-secondary bouton_sortie"]
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
