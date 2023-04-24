<?php

namespace App\Form;

use App\Entity\Diet;
use App\Entity\Ingredient;
use App\Entity\Recipe;
use App\Repository\DietRepository;
use App\Repository\IngredientRepository;
use App\Repository\RecipeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class RecipeFormType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('title', TextType::class, [
        'attr' => [
          'class' => 'form-control'
        ],
        'label' => 'Nom de la recette'
      ])
      ->add('description', TextareaType::class, [
        'attr' => [
          'class' => 'form-control'
        ],
        'label' => 'Description de la recette'
      ])
      ->add('makingTime', TimeType::class, [
        'widget' => 'choice',
        'label' => 'Temps de préparation'
      ])
      ->add('restingTime', TimeType::class, [
        'widget' => 'choice',
        'label' => 'Temps de repos'
      ])
      ->add('cookingTime', TimeType::class, [
        'widget' => 'choice',
        'label' => 'Temps de cuisson'
      ])
      ->add('steps', TextareaType::class, [
        'attr' => [
          'class' => 'form-control'
        ],
        'label' => 'Etape  de préparation'
      ])
      ->add('calories', NumberType::class, [
        'attr' => [
          'class' => 'form-control'
        ],
        'label' => 'Calories du plat pour 100g'
      ])
      ->add('isPremium', CheckboxType::class, [
        'label' => 'Réservé aux abonnés',
        'required' => false,
        'mapped' => true,
      ])
      ->add('diets', EntityType::class, [
        'class' => Diet::class,
        'choice_label' => 'label',
        'label' => 'Régime',
        'multiple' => true,
        'expanded' => false,
        'query_builder' => function(DietRepository $dr)
        {
          return $dr->createQueryBuilder('r')
            ->orderBy('r.label', 'ASC');
        },
      ])
      ->add('ingredients', EntityType::class, [
        'class' => Ingredient::class,
        'choice_label' => 'label',
        'label' => 'Ingrédients',
        'multiple' => true,
        'expanded' => false,
        'query_builder' => function(IngredientRepository $ir)
        {
          return $ir->createQueryBuilder('r')
            ->orderBy('r.label', 'ASC');
        },
      ])
      ->add('image', FileType::class, [
        'attr' => [
          'class' => 'form-control'
        ],
        'label' => false,
        'multiple' => false,
        'mapped' => false,
        'required' => false
      ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
      $resolver->setDefaults([
          'entityManager' => 'second',
          'data_class' => Recipe::class,
      ]);
  }
}

?>