<?php

namespace App\Form;

use App\Entity\Opinion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentFormType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('message', TextareaType::class, [
        'attr' => [
          'class' => 'form-control'
        ],
        'label' => 'Message'
      ])
      ->add('mark', ChoiceType::class, [
        'label' => 'Note',
        'choices' => [
          'star1' => 1,
          'star2' => 2,
          'star3' => 3,
          'star4' => 4,
          'star5' => 5,
        ],
        'expanded' => true,
        'multiple' => false,
      ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
      $resolver->setDefaults([
          'data_class' => Opinion::class,
      ]);
  }
}

?>