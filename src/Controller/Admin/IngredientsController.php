<?php

namespace App\Controller\Admin;

use App\Entity\Ingredient;
use App\Form\IngredientFormType;
use App\Form\RegistrationFormType;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/ingredient', name: 'admin_ingredient_')]
class IngredientsController extends AbstractController
{
  #[Route('/', name: 'index')]
  public function index(IngredientRepository $ingredientRepository): Response
  {
    $this->denyAccessUnlessGranted('ROLE_ADMIN');

    return $this->render('admin/ingredient/index.html.twig', [
      'ingredients' => $ingredientRepository->findAll(),
    ]);
  }

  #[Route('/add', name: 'add')]
  public function add(Request $request, UserPasswordHasherInterface $userPasswordHasher, 
  EntityManagerInterface $entityManager): Response
  {

    $this->denyAccessUnlessGranted('ROLE_ADMIN');

    $ingredient = new Ingredient();
    $form = $this->createForm(IngredientFormType::class, $ingredient);
    $form->handleRequest($request);
    //

    if($form->isSubmitted() && $form->isValid()) {
      
      $entityManager->persist($ingredient);
      $entityManager->flush();

      return $this->redirectToRoute('admin_ingredient_index');
    }

    return $this->render('admin/ingredient/new.html.twig', [
      'ingredientForm' => $form->createView(),
    ]);
    
  }

  #[Route('/edit/{id}', name: 'edition')]
  public function edit(Request $request, Ingredient $ingredient, EntityManagerInterface $entityManager): Response
  {

    $this->denyAccessUnlessGranted('ROLE_ADMIN');

    $form = $this->createForm(IngredientFormType::class, $ingredient);
    $form->handleRequest($request);
    //

    if($form->isSubmitted() && $form->isValid()) {
      
      $entityManager->persist($ingredient);
      $entityManager->flush();

      return $this->redirectToRoute('admin_ingredient_index');
    }

    return $this->render('admin/ingredient/edit.html.twig', [
      'ingredientForm' => $form->createView(),
    ]);
    
  }

  #[Route('/remove/{id}', name: 'remove')]
  public function remove(Ingredient $ingredient, EntityManagerInterface $entityManager): Response
  {
    $this->denyAccessUnlessGranted('ROLE_ADMIN');

    $entityManager->remove($ingredient);
    $entityManager->flush();

    return $this->redirectToRoute('admin_ingredient_index');
  }
}