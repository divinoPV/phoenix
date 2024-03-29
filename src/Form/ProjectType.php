<?php

namespace App\Form;

use App\Entity\Portfolio;
use App\Entity\Project;
use App\Entity\Status;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', options: [
                'label' => 'project.name',
                'required' => true,
            ])
            ->add('description', options: [
                'label' => 'project.description',
                'required' => false,
            ])
            ->add('code', options: [
                'label' => 'project.code',
                'required' => true,
            ])
            ->add('startedAt', options: [
                'label' => 'project.started_at',
                'required' => true,
            ])
            ->add('endedAt', options: [
                'label' => 'project.ended_at',
                'required' => true,
            ])
            ->add('status', EntityType::class, [
                'class' => Status::class,
                'choice_label' => 'name',
                'label' => 'project.status',
                'multiple' => false,
                'required' => true,
            ])
            ->add('archived', options: [
                'label' => 'project.archived',
            ])
            ->add('budget', BudgetType::class)
            ->add('portfolio', EntityType::class, [
                'class' => Portfolio::class,
                'choice_label' => 'name',
                'label' => 'project.portfolio',
                'multiple' => false,
            ])
            ->add('teamProject', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name',
                'label' => 'project.team_project',
                'multiple' => false,
                'required' => true,
            ])
            ->add('teamCustomer', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name',
                'label' => 'project.team_customer',
                'multiple' => false,
                'required' => true,
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
