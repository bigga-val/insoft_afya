<?php

namespace App\Controller;

use App\Entity\ChoixMedecin;
use App\Entity\Patient;
use App\Form\ChoixMedecinType;
use App\Repository\ChoixMedecinRepository;
use App\Repository\MedecinServiceHopitalRepository;
use App\Repository\PatientRepository;
use App\Repository\PersonRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/choix_medecin')]
class ChoixMedecinController extends AbstractController
{
    #[Route('/', name: 'choix_medecin_index', methods: ['GET'])]
    public function index(ChoixMedecinRepository $choixMedecinRepository): Response
    {
        return $this->render('choix_medecin/index.html.twig', [
            'choix_medecins' => $choixMedecinRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'choix_medecin_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $choixMedecin = new ChoixMedecin();
        $form = $this->createForm(ChoixMedecinType::class, $choixMedecin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($choixMedecin);
            $entityManager->flush();

            return $this->redirectToRoute('choix_medecin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('choix_medecin/new.html.twig', [
            'choix_medecin' => $choixMedecin,
            'form' => $form,
        ]);
    }

    #[Route("/createRelationToDoctorJson", name:"createrelationToDoctorJson", methods:['POST'])]
    public  function createRelationToDoctorAction(Request $request, PatientRepository $patientRepository,
                                                  MedecinServiceHopitalRepository $repository,
                                                  PersonRepository $personRepository, UserRepository $userRepository
    ){

        if ($request->isXMLHttpRequest()) {
            //if($this->isCsrfTokenValid('csrf_token', $request->request->get('csrf_token'))){
                $logUser = $userRepository->find($request->request->get('patientID'));
                $person = $personRepository->findOneBy(['UserPerson'=>$logUser->getId()]);
//                $person = $personRepository->findOneBy(['UserPerson'=>$request->request->get('patientID')]);
                $patient = $patientRepository->findOneBy(['Person'=>$person->getId()]);
                $medServHop = $repository->find($request->request->get('medecinID'));

                $choixMedecin = new ChoixMedecin();
                $choixMedecin->setCreatedAt(new \DateTimeImmutable());
                $choixMedecin->setCreatedBy($this->getUser()->getUserIdentifier());
                $choixMedecin->setMedecinServiceHopital($medServHop);
                $choixMedecin->setPatient($patient);
                $choixMedecin->setStatus("active");
                $this->getDoctrine()->getManager()->persist($choixMedecin);
                $this->getDoctrine()->getManager()->flush();

            //}
            return new JsonResponse('Right');
        }else{
            return new JsonResponse('Check please');
        }
        return new JsonResponse('Submited');
    }

    #[Route('/{id}', name: 'choix_medecin_show', methods: ['GET'])]
    public function show(ChoixMedecin $choixMedecin): Response
    {
        return $this->render('choix_medecin/show.html.twig', [
            'choix_medecin' => $choixMedecin,
        ]);
    }

    #[Route('/{id}/edit', name: 'choix_medecin_edit', methods: ['GET','POST'])]
    public function edit(Request $request, ChoixMedecin $choixMedecin): Response
    {
        $form = $this->createForm(ChoixMedecinType::class, $choixMedecin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('choix_medecin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('choix_medecin/edit.html.twig', [
            'choix_medecin' => $choixMedecin,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'choix_medecin_delete', methods: ['POST'])]
    public function delete(Request $request, ChoixMedecin $choixMedecin): Response
    {
        if ($this->isCsrfTokenValid('delete'.$choixMedecin->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($choixMedecin);
            $entityManager->flush();
        }

        return $this->redirectToRoute('choix_medecin_index', [], Response::HTTP_SEE_OTHER);
    }
}
