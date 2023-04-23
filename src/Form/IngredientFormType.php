<?php

namespace App\Form;

use App\Entity\Allergen;
use App\Entity\Ingredient;
use App\Repository\AllergenRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IngredientFormType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('label', TextType::class, [
        'attr' => [
          'class' => 'form-control'
        ],
        'label' => 'Label de l\'ingrédient'
      ])
      ->add('allergen', EntityType::class, [
        'class' => Allergen::class,
        'choice_label' => 'display_label',
        'label' => 'Allergènes',
        'required' => false,
      ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
      $resolver->setDefaults([
          'data_class' => Ingredient::class,
      ]);
  }
}

?>