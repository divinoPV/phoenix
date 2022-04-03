<?php

namespace App\Form;

use App\Entity\Portfolio;
use App\Entity\Project;
use App\Entity\Team;
use App\Enum\StatusEnum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('code')
            ->add('startedAt')
            ->add('endedAt')
            ->add('status', EnumType::class, [
                'class' => StatusEnum::class,
                'choice_label' => 'label'
            ])
            ->add('budget', BudgetType::class)
            ->add('portfolio', EntityType::class, [
                'class' => Portfolio::class,
                'choice_label' => 'name',
                'multiple' => false,
            ])
            ->add('teamProject', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name',
                'multiple' => false,
            ])
            ->add('teamCustomer', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name',
                'multiple' => false,
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
