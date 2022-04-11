<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Participant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mail')
            ->add('password',
                RepeatedType::class, [
                    'type' => PasswordType::class,
                    'invalid_message' => 'les mdps ne sont pas identiques',
                    // 'options' => ['attr' => ['class' => 'password-field']],
                    'required' => true,
                    'first_options'  => ['label' => 'Mot de passe'],
                    'second_options' => ['label' => 'Confirmer']
            ])
            ->add('nom')
            ->add('prenom')
            ->add('telephone')
            ->add('administrateur')
            ->add('actif')
            ->add('pseudo')
            ->add('campus',
            EntityType::class,
                [
                    'class'=> Campus::class,
                    'choice_label' => 'nom',
                    'mapped' => false
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
