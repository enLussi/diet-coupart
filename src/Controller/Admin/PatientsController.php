<?php

namespace App\Controller\Admin;

use App\Entity\Patient;
use App\Form\RegistrationFormType;
use App\Repository\AllergenRepository;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/patient', name: 'admin_patient_')]
class PatientsController extends AbstractController
{
  #[Route('/', name: 'index')]
  public function index(PatientRepository $patientRepository): Response
  {
    $this->denyAccessUnlessGranted('ROLE_ADMIN');

    return $this->render('admin/patient/index.html.twig', [
      'patients' => $patientRepository->findAll(),
    ]);
  }

  #[Route('/add', name: 'add')]
  public function add(Request $request, UserPasswordHasherInterface $userPasswordHasher, 
  EntityManagerInterface $entityManager, AllergenRepository $allergenRepository): Response
  {

    $this->denyAccessUnlessGranted('ROLE_ADMIN');

    $patient = new Patient();
    $form = $this->createForm(RegistrationFormType::class, $patient);
    $form->handleRequest($request);
    //

    if($form->isSubmitted() && $form->isValid()) {

      foreach($form->get('allergen')->getData() as $allergen) {
        $patient->addAllergen($allergen);
        $i = $allergenRepository->find($allergen->getId());
        $i->addPatient($patient);
      }

      //générer un mot de passe aléatoire automatiquement
      // et laisser le patient changer le mot de passe à sa première connexion

      $patient->setPassword(
        $userPasswordHasher->hashPassword(
          $patient,
          'patient'
        )
        );
      
      $entityManager->persist($patient);
      $entityManager->flush();

      return $this->redirectToRoute('admin_patient_index');
    }

    return $this->render('admin/patient/new.html.twig', [
      'registrationForm' => $form->createView(),
    ]);
    
  }

  #[Route('/edit/{id}', name: 'edition')]
  public function edit(Request $request, Patient $patient, UserPasswordHasherInterface $userPasswordHasher, 
  EntityManagerInterface $entityManager): Response
  {

    $this->denyAccessUnlessGranted('ROLE_ADMIN');

    $form = $this->createForm(RegistrationFormType::class, $patient);
    $form->handleRequest($request);
    //

    if($form->isSubmitted() && $form->isValid()) {
      // $patient->setPassword(
      //   $userPasswordHasher->hashPassword(
      //     $patient,
      //     $form->get('plainPassword')->getData()
      //   )
      //   );
      
      $entityManager->persist($patient);
      $entityManager->flush();

      return $this->redirectToRoute('admin_patient_index');
    }

    return $this->render('admin/patient/edit.html.twig', [
      'registrationForm' => $form->createView(),
    ]);
    
  }

  #[Route('/remove/{id}', name: 'remove')]
  public function remove(Patient $patient, EntityManagerInterface $entityManager): Response
  {
    $this->denyAccessUnlessGranted('ROLE_ADMIN');

    $entityManager->remove($patient);
    $entityManager->flush();

    return $this->redirectToRoute('admin_patient_index');
  }
}