<?php

namespace App\Controller;

use App\Entity\Service;
use App\Repository\HopitalRepository;
use App\Repository\ServiceRepository;
use App\Entity\ServiceHopital;
use App\Form\ServiceHopital1Type;
use App\Repository\ServiceHopitalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/service_hopital')]
class ServiceHopitalController extends AbstractController
{
    #[Route('/', name: 'service_hopital_index', methods: ['GET'])]
    public function index(ServiceHopitalRepository $serviceHopitalRepository): Response
    {
        return $this->render('service_hopital/index.html.twig', [
            'service_hopitals' => $serviceHopitalRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'service_hopital_new', methods: ['GET','POST'])]
    public function new(Request $request, ServiceRepository $serviceRepository, HopitalRepository $hopitalRepository): Response
    {
        $services = $serviceRepository->findAll();
        $hopitals = $hopitalRepository->findAll();
        $serviceHopital = new ServiceHopital();
        if($request->isMethod('POST')){
            if($this->isCsrfTokenValid('csrf_token', $request->request->get('csrf_token'))){
                $service = $serviceRepository->find($request->request->get('serviceID'));
                $hopital = $hopitalRepository->find($request->request->get('hopitalID'));
                $servHop = new ServiceHopital();
                $servHop->setHopital($hopital);
                $servHop->setService($service);
                $servHop->setCreatedBy($this->getUser()->getUserIdentifier());
                $servHop->setCreatedAt(new \DateTimeImmutable());
                $service->setStatus('active');
                $this->getDoctrine()->getManager()->persist($servHop);
                $this->getDoctrine()->getManager()->flush();
                return $this->redirectToRoute('service_hopital_index');
            }else{
                dump($request);
            }
        }

        return $this->renderForm('service_hopital/new.html.twig', [
            'service_hopital' => $serviceHopital,
            'services' => $services,
            'hopitals' => $hopitals
        ]);
    }

    #[Route('/{id}', name: 'service_hopital_show', methods: ['GET'])]
    public function show(ServiceHopital $serviceHopital): Response
    {
        return $this->render('service_hopital/show.html.twig', [
            'service_hopital' => $serviceHopital,
        ]);
    }

    #[Route('/{id}/edit', name: 'service_hopital_edit', methods: ['GET','POST'])]
    public function edit(Request $request, ServiceHopital $serviceHopital): Response
    {
        $form = $this->createForm(ServiceHopital1Type::class, $serviceHopital);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('service_hopital_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service_hopital/edit.html.twig', [
            'service_hopital' => $serviceHopital,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'service_hopital_delete', methods: ['POST'])]
    public function delete(Request $request, ServiceHopital $serviceHopital): Response
    {
        if ($this->isCsrfTokenValid('delete'.$serviceHopital->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($serviceHopital);
            $entityManager->flush();
        }

        return $this->redirectToRoute('service_hopital_index', [], Response::HTTP_SEE_OTHER);
    }
}
