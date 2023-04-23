<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class ContactFormType extends AbstractType
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
      ->add('phone', TextType::class, [
        'attr' => [
          'class' => 'form-control'
        ],
        'label' => 'Téléphone'
      ])
      ->add('message', TextareaType::class, [
        'attr' => [
          'class' => 'form-control'
        ],
        'label' => 'Message'
      ])
      ->add('RGPDConsent', CheckboxType::class, [
        'mapped' => false,
        'constraints' => [
          new IsTrue([
            'message' => 'Veuillez accepter les termes d\'utilisation de vos données.',
          ]),
        ],
        'label' => 'J\'accepte l\'utilisation de mes informations.'
      ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
      $resolver->setDefaults([
          'entityManager' => 'second',
      ]);
  }
}

?>