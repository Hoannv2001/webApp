<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\IssueBook;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IssueBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('issueDate', DateType::class,[
                'widget'  => 'single_text'
            ])
            ->add('returnDate', DateType::class,[
                'widget'  => 'single_text'
            ])
            ->add('books',EntityType::class,[
                'class'=>Book::class,
                'choice_label'=> 'bookName',
                'mapped'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => IssueBook::class,
        ]);
    }
}
