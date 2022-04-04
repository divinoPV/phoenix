<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\User;
use App\Enum\TeamTypeEnum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class TeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', options: [
                'label' => 'team.name',
                'required' => true
            ])
            ->add('type', EnumType::class, [
                'class' => TeamTypeEnum::class,
                'choice_label' => 'label',
                'label' => 'team.type',
                'required' => true
            ])
            ->add('responsible', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'fullName',
                'label' => 'team.responsible',
                'required' => true
            ])
            ->add('parent', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name',
                'label' => 'team.parent',
                'placeholder' => '',
                'required' => false
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'user.submit'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}
