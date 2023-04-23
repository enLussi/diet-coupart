<?php

namespace App\Controller\Admin;

use App\Entity\Diet;
use App\Entity\Recipe;
use App\Form\RecipeFormType;
use App\Repository\IngredientRepository;
use App\Repository\RecipeRepository;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/recipe', name: 'admin_recipe_')]
class RecipesController extends AbstractController
{

  #[Route('/', name: 'index')]
  public function index(RecipeRepository $recipeRepository){

    $this->denyAccessUnlessGranted('ROLE_ADMIN');

    return $this->render('admin/recipe/list.html.twig', [
      'recettes' => $recipeRepository->findAll()
    ]);
  }

  #[Route('/add', name: 'add')]
  public function add(Request $request, EntityManagerInterface $entityManager,
  PictureService $pictureService, IngredientRepository $ingredientRepository): Response
  {

    $this->denyAccessUnlessGranted('ROLE_ADMIN');

    $recipe = new Recipe();
    $form = $this->createForm(RecipeFormType::class, $recipe);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()) {
      

      // relation many to many ingrédients - recettes
      foreach($form->get('ingredients')->getData() as $ingredient) {
        $recipe->addIngredient($ingredient);
        $i = $ingredientRepository->find($ingredient->getId());
        $i->addRecipe($recipe);
      }
      
      //on récupère les images
      $image = $form->get('image')->getData();
      
      if(is_array($image)){
        throw new Exception('trop d\'image');
      }

      $folder = 'recipe';
      $file = $pictureService->add($image, $folder, 500, 500);

      $recipe->setImage($file);
      
      $entityManager->persist($recipe);
      $entityManager->flush();


      return $this->redirectToRoute('admin_recipe_index');
    }
    
    return $this->render('admin/recipe/new.html.twig', [
      'recipeForm' => $form->createView(),
    ]);
  }

  #[Route('/edit/{id}', name: 'edition')]
  public function edit(Request $request, Recipe $recipe, EntityManagerInterface $entityManager,
  PictureService $pictureService, IngredientRepository $ingredientRepository): Response
  {
    $this->denyAccessUnlessGranted('ROLE_ADMIN');

    $form = $this->createForm(RecipeFormType::class, $recipe);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()) {


      
      $isPremium = $form->get('isPremium')->getData();
      $recipe->setIsPremium($isPremium);
      // relation many to many ingrédients - recettes
      foreach($form->get('ingredients')->getData() as $ingredient) {
        $recipe->addIngredient($ingredient);
        $i = $ingredientRepository->find($ingredient->getId());
        $i->addRecipe($recipe);
      }
      
      //on récupère les images
      $image = $form->get('image')->getData();
      
      if(is_array($image)){
        throw new Exception('trop d\'image');
      }

      if(!is_null($image)) {
        $folder = 'recipe';
        $file = $pictureService->add($image, $folder, 500, 500);
  
        $recipe->setImage($file);
      }

              
      $entityManager->persist($recipe);
      $entityManager->flush();

      return $this->redirectToRoute('admin_recipe_index');
    }

    return $this->render('admin/recipe/edit.html.twig', [
      'recipeForm' => $form->createView(),
      'recette' => $recipe,
    ]);
  }

  #[Route('/remove/{id}', name: 'remove')]
  public function remove(Recipe $recipe, EntityManagerInterface $entityManager): Response
  {
    $this->denyAccessUnlessGranted('ROLE_ADMIN');

    $entityManager->remove($recipe);
    $entityManager->flush();

    return $this->redirectToRoute('admin_recipe_index');
  }
}