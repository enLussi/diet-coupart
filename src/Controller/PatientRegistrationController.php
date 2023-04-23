<?php

namespace App\Controller;

use App\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PatientRegistrationController extends AbstractController {

  #[Route('/appointment', name: 'app_register')]
  public function register(Request $request): Response
  {

    $form = $this->createForm(ContactFormType::class);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()) {
      // envoyer un mail sur la boite mail de l'agence
    }

    return $this->render('contact/contact.html.twig', [
      'registrationForm' => $form->createView(),
    ]);
  }

}

?>