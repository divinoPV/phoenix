<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\User;
use App\Enum\MemberTypeEnum;
use App\Enum\UserRoleEnum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

final class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'user.email',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer une adresse email',
                    ]),
                    new Email([
                        'message' => 'Veuillez entrer une adresse email valide',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit faire au moins {{ limit }} caractères',
                        'max' => 63,
                    ]),
                ],
                'label' => 'user.password',
                'mapped' => false,
            ])
            ->add('firstName', options: [
                'label' => 'user.first_name'
            ])
            ->add('lastName', options: [
                'label' => 'user.last_name'
            ])
            ->add('userName', options: [
                'label' => 'user.user_name'
            ])
        ;

        if ($options['form_add']) {
            $builder->add('roles', EnumType::class, [
                'class' => UserRoleEnum::class,
                'choice_label' => 'label',
                'label' => 'user.role',
                'multiple' => true,
            ]);
        }

        $builder
            ->add('type', EnumType::class, [
                'class' => MemberTypeEnum::class,
                'choice_label' => 'label',
                'label' => 'user.type',
                'required' => true
            ])
            ->add('team', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name',
                'label' => 'user.team',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'user.submit'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'form_add' => false,
        ]);
    }
}
