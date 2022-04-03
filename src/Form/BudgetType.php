<?php

namespace App\Form;

use App\Entity\Budget;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class BudgetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('original', options: [
                'label' => 'budget.original'
            ])
            ->add('consumed', options: [
                'label' => 'budget.consumed'
            ])
            ->add('remaining', options: [
                'label' => 'budget.remaining'
            ])
            ->add('landing', options: [
                'label' => 'budget.landing'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Budget::class,
        ]);
    }
}
