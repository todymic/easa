<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', null, [
                'attr' => [
                    'placeholder' => 'form.input.lastname'
                ]
            ])
            ->add('firstname', null,[
                'attr' => [
                    'placeholder' => 'form.input.firstname'
                ]
            ])
            ->add('adresse', null,[
                'attr' => [
                    'placeholder' => 'form.input.adresse'
                ]
            ])
            ->add('city', null,[
                'attr' => [
                    'placeholder' => 'form.input.city'
                ]
            ])
            ->add('country', null,[
                'attr' => [
                    'placeholder' => 'form.input.country'
                ]
            ])
            ->add('phone', null,[
                'attr' => [
                    'placeholder' => 'form.input.phone'
                ]
            ])
            ->add('email', EmailType::class,[
                'attr' => [
                    'placeholder' => 'form.input.email'
                ]
            ])
            ->add('password', PasswordType::class,[
                'attr' => [
                    'placeholder' => 'form.input.firstname'
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'multiple' => true,
                'expanded' => true, // render check-boxes
                'choices' => [
                    'Admin' => 'ROLE_ADMIN'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
