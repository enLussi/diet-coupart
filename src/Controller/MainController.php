<?php

namespace App\Controller;

use App\Repository\OpinionRepository;
use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(RecipeRepository $recipeRepository, OpinionRepository $opinionRepository): Response
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


        return $this->render('main/index.html.twig', [
            'recettes' => $recipeRepository->findAll(),
            'marks' => $marks,
        ]);
    }
}
