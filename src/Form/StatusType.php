<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Status;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class StatusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('book', EntityType::class, [
                'class' => Book::class,
            ])
        ;
        if ($options['updating']) {
            $builder
                ->add('current_page')
                ->add(child: 'starting_date', type:DateTimeType::class, 
                    options: [
                        'label' => 'Starting date',
                        'widget' => 'single_text',
                    ]
                );
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Status::class,
            'updating' => false,
        ]);
    }
}
