<?php

namespace App\Form;

use App\Entity\Allergen;
use App\Repository\AllergenRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('email', EmailType::class, [
        'attr' => [
          'class' => 'form-control'
        ],
        'label' => 'E-mail'
      ])
      ->add('lastname', TextType::class, [
        'attr' => [
          'class' => 'form-control'
        ],
        'label' => 'Nom'
      ])
      ->add('firstname', TextType::class, [
        'attr' => [
          'class' => 'form-control'
        ],
        'label' => 'Prénom'
      ])
      ->add('address', TextType::class, [
        'attr' => [
          'class' => 'form-control'
        ],
        'label' => 'Adresse'
      ])
      ->add('zipcode', TextType::class, [
        'attr' => [
          'class' => 'form-control'
        ],
        'label' => 'Code Postal'
      ])
      ->add('city', TextType::class, [
        'attr' => [
          'class' => 'form-control'
        ],
        'label' => 'Ville'
      ])
      ->add('allergens', EntityType::class, [
        'class' => Allergen::class,
        'choice_label' => 'label',
        'label' => 'Allergènes',
        'multiple' => true,
        'expanded' => false,
        'query_builder' => function(AllergenRepository $ir)
        {
          return $ir->createQueryBuilder('r')
            ->orderBy('r.label', 'ASC');
        }
      ])
      // ->add('RGPDConsent', CheckboxType::class, [
      //   'mapped' => false,
      //   'constraints' => [
      //     new IsTrue([
      //       'message' => 'Veuillez accepter les termes d\'utilisation de vos données.',
      //     ]),
      //   ],
      //   'label' => 'J\'accepte l\'utilisation de mes informations.'
      // ])
      // ->add('plainPassword', PasswordType::class, [
      //   'mapped' => false,
      //   'attr' => [
      //     'autocomplete' => 'new-password',
      //     'class' => 'form-control'
      //   ],
      //   'constraints' => [
      //     new NotBlank([
      //       'message' => 'Veuillez un mot de passe.',
      //     ]),
      //     new Length([
      //       'min' => 6,
      //       'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères.',
      //       'max' => 4096
      //     ]),
      //   ],
      //   'label' => 'Mot de passe'
      // ])
      ;
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
      $resolver->setDefaults([
          'entityManager' => 'second',
      ]);
  }
}

?>