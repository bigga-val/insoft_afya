<?php

namespace App\Controller;

use App\Entity\MedecinServiceHopital;
use App\Form\MedecinServiceHopitalType;
use App\Repository\DoctorRepository;
use App\Repository\MedecinServiceHopitalRepository;
use App\Repository\ServiceHopitalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/medecin_service_hopital')]
class MedecinServiceHopitalController extends AbstractController
{
    #[Route('/', name: 'medecin_service_hopital_index', methods: ['GET'])]
    public function index(MedecinServiceHopitalRepository $medecinServiceHopitalRepository): Response
    {
        return $this->render('medecin_service_hopital/index.html.twig', [
            'medecin_service_hopitals' => $medecinServiceHopitalRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'medecin_service_hopital_new', methods: ['GET','POST'])]
    public function new(Request $request, DoctorRepository $doctorRepository, ServiceHopitalRepository $serviceHopitalRepository): Response
    {
        $medecinServiceHopital = new MedecinServiceHopital();

        $medecins = $doctorRepository->findAll();
        $servicehops = $serviceHopitalRepository->findAll();
        if($request->isMethod("POST")){
            if($this->isCsrfTokenValid('csrf_token', $request->request->get('csrf_token'))){
                $serviceHop = $serviceHopitalRepository->find($request->request->get('serviceHopID'));
                $medecin = $doctorRepository->find($request->request->get('medecinID'));
                $medecinServiceHopital->setServiceHopital($serviceHop);
                $medecinServiceHopital->setMedecin($medecin);
                $medecinServiceHopital->setStatus('active');
                $medecinServiceHopital->setCreatedAt(new \DateTimeImmutable());
                $medecinServiceHopital->setCreateBy($this->getUser()->getUserIdentifier());
                $this->getDoctrine()->getManager()->persist($medecinServiceHopital);
                $this->getDoctrine()->getManager()->flush();
            }
        }

        return $this->render('medecin_service_hopital/new.html.twig', [
            'medecins'=>$medecins,
            'servicehops'=>$servicehops
        ]);
    }

    #[Route('/{id}', name: 'medecin_service_hopital_show', methods: ['GET'])]
    public function show(MedecinServiceHopital $medecinServiceHopital): Response
    {
        return $this->render('medecin_service_hopital/show.html.twig', [
            'medecin_service_hopital' => $medecinServiceHopital,
        ]);
    }

    #[Route('/{id}/edit', name: 'medecin_service_hopital_edit', methods: ['GET','POST'])]
    public function edit(Request $request, MedecinServiceHopital $medecinServiceHopital): Response
    {
        $form = $this->createForm(MedecinServiceHopitalType::class, $medecinServiceHopital);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('medecin_service_hopital_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('medecin_service_hopital/edit.html.twig', [
            'medecin_service_hopital' => $medecinServiceHopital,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'medecin_service_hopital_delete', methods: ['POST'])]
    public function delete(Request $request, MedecinServiceHopital $medecinServiceHopital): Response
    {
        if ($this->isCsrfTokenValid('delete'.$medecinServiceHopital->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($medecinServiceHopital);
            $entityManager->flush();
        }

        return $this->redirectToRoute('medecin_service_hopital_index', [], Response::HTTP_SEE_OTHER);
    }
}
