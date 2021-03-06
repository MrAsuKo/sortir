<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Ville;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, ['attr' => ['class' => 'form-control form-control-sm']])
            ->add('rue', TextType::class, ['attr' => ['class' => 'form-control form-control-sm']])
            ->add('latitude', TextType::class, ['attr' => ['class' => 'form-control form-control-sm']])
            ->add('longitude', TextType::class, ['attr' => ['class' => 'form-control form-control-sm']])
            ->add('ville',EntityType::class,
                [
                    'label'=>'Ville : ',
                    'class'=> Ville::class,
                    'choice_label' => function (Ville $ville){
                        return $ville->getNom() . ' - ' . $ville->getCodePostal();
                    },
                    "multiple" => false,
                    'attr' => [
                        'class' => 'form-select form-select-sm'
                    ]
            ])
            ->add('valider',
            SubmitType::class, ["attr" => [ "class" => "btn btn-secondary bouton_creer_lieu"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class,
        ]);
    }
}
