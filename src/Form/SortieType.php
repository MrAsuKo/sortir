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
                    "label" => "Nom de la sortie : ",
                    "attr" => ["class" => "form"]
                ]
            )
            ->add('dateHeureDebut',
                DateTimeType::class,
                [
                    "label" => "Date et heure de la sortie : ",
                    'widget' => 'single_text',
                    'data' => new DateTime('now'),
                    "attr" => ["class" => "form"]
                ]
            )
            ->add('dateLimiteInscription',
                DateType::class,
                [
                    "label" => "Date limite d'inscription : ",
                    'widget' => 'single_text',
                    'data' => new DateTime('now'),
                    "attr" => ["class" => "form"]
                ]
            )
            ->add('nbInscriptionsMax',
                IntegerType::class,
                [
                    "label" => "Nombre de places : ",
                    "attr" => ["class" => "form"]
                ]
            )
            ->add('duree',
                IntegerType::class,
                [
                    "label" => "Durée : ",
                    "attr" => ["class" => "form",
                    "onchange" => "select()"]
                ]
            )
            ->add('infosSortie',
                TextareaType::class,
                [
                    "label" => "Description et infos : ",
                    "attr" => [ "class" => "form"]
                ]
            )
            ->add('lieu',
                EntityType::class,
                [
                    'label'=> 'Lieu : ',
                    'class'=> Lieu::class,
                    'choice_label' => 'nom',
                    'mapped' => false,
                    "attr" => ["class" => "form", "id" => "lieu"]

                ]
            )
            ->add('ville',
                EntityType::class,
                [
                    'label'=> 'Ville : ',
                    'class'=> Ville::class,
                    'choice_label' => 'nom',
                    'mapped' => false,
                    "attr" => [ "class" => "form"]
                ]
            )
            ->add('enregistrer',
                SubmitType::class,
                [
                    'label'=> 'Enregistrer',
                    "attr" => [ "class" => "btn btn-info"]
                ]
            )
            ->add('publier',
                SubmitType::class,
                [
                    'label'=> 'Publier la sortie',
                    "attr" => [ "class" => "btn btn-info"]
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
