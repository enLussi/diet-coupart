<?php

namespace App\Controller;

use App\Entity\Opinion;
use App\Entity\Patient;
use App\Entity\Recipe;
use App\Form\CommentFormType;
use App\Repository\OpinionRepository;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/recipe', name: 'app_recipe_')]
class RecipeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(RecipeRepository $recipeRepository, Request $request, OpinionRepository $opinionRepository): Response
    {

        $marks = []; 

        foreach($recipeRepository->findAll() as $recipe) {
            $opinions = $opinionRepository->findBy(['recipe' => $recipe]);
            $sum_mark = 0;
            $average_mark = 0; 
    
            foreach( $opinions as $o ) {
                $sum_mark += $o->getMark();
            }
    
            if( count($opinions) > 0 ) {
                $average_mark = $sum_mark / count($opinions);
            }
            array_push($marks, $average_mark);
        }

        $search = $request->request->get('search');
        if (strlen($search) < 3) {
            $recipe = $recipeRepository->findAll();
            
        } else {
            $recipe = $recipeRepository->findBy([
                'title' => $search
            ]);
            
        }

        return $this->render('list_recipes/index.html.twig', [
            'recettes' => $recipe,
            'marks' => $marks,
        ]);
    }

    #[Route('/{id}', name: 'details')]
    public function details(Request $request, EntityManagerInterface $entityManager, Recipe $recipe, OpinionRepository $opinionRepository): Response 
    {
        //dd($recipe->getTitle());
        if($recipe->isIsPremium() && !($this->isGranted('ROLE_PATIENT') || $this->isGranted('ROLE_ADMIN')) ){
            return $this->redirectToRoute('app_login');
        }

        $user = $this->getUser();

        $form_display = false;

        $opinion = new Opinion();
        $form = $this->createForm(CommentFormType::class, $opinion);
        $form->handleRequest($request);

        $opinions = $opinionRepository->findBy(['recipe' => $recipe]);
        $sum_mark = 0;
        $average_mark = 0; 

        foreach( $opinions as $o ) {
            $sum_mark += $o->getMark();
        }

        if( count($opinions) > 0 ) {
            $average_mark = $sum_mark / count($opinions);
        }

        if($form->isSubmitted() && $form->isValid()) {
    
            $recipe->addOpinion($opinion);   
            $opinion->setRecipe($recipe);

            $opinion->setAuthor($user);

            $entityManager->persist($opinion);
            $entityManager->flush();

            return new JsonResponse([
                'author' => $opinion->getAuthor()->getFirstname(). ' '.$opinion->getAuthor()->getLastname(),
                'message' => $opinion->getMessage(),
                'mark' => $opinion->getMark(),
                'date' => $opinion->getpublishedDate()
            ]);
        }

        if($user && $user instanceof Patient) {
            $form_display = true;
        }



        return $this->render('recipe/index.html.twig', [
            'recette' => $recipe,
            'commentForm' => $form,
            'formDisplay' => $form_display,
            'opinions' => array_reverse($opinions),
            'averageMark' => $average_mark,
        ]);
        

    }
}
