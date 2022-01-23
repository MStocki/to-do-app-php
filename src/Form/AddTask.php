<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\StatusTask;
use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddTask extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('status', ChoiceType::class,[
                'choices'=>[
                    StatusTask::NEW->value => StatusTask::NEW->value,
                    StatusTask::TEST->value =>StatusTask::TEST->value,
                    StatusTask::ERROR->value => StatusTask::ERROR->value,
                    StatusTask::ANALYSIS->value => StatusTask::ANALYSIS->value,
                ],
            ])
            ->add('deadline');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}