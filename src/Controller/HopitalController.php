<?php

namespace App\Controller;

use App\Entity\Hopital;
use App\Form\HopitalType;
use App\Repository\HopitalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/hopital')]
class HopitalController extends AbstractController
{
    #[Route('/', name: 'hopital_index', methods: ['GET'])]
    public function index(HopitalRepository $hopitalRepository): Response
    {
        return $this->render('hopital/index.html.twig', [
            'hopitals' => $hopitalRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'hopital_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $hopital = new Hopital();
        $form = $this->createForm(HopitalType::class, $hopital);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($hopital);
            $entityManager->flush();

            return $this->redirectToRoute('hopital_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hopital/new.html.twig', [
            'hopital' => $hopital,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'hopital_show', methods: ['GET'])]
    public function show(Hopital $hopital): Response
    {
        return $this->render('hopital/show.html.twig', [
            'hopital' => $hopital,
        ]);
    }

    #[Route('/{id}/edit', name: 'hopital_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Hopital $hopital): Response
    {
        $form = $this->createForm(HopitalType::class, $hopital);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('hopital_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hopital/edit.html.twig', [
            'hopital' => $hopital,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'hopital_delete', methods: ['POST'])]
    public function delete(Request $request, Hopital $hopital): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hopital->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($hopital);
            $entityManager->flush();
        }

        return $this->redirectToRoute('hopital_index', [], Response::HTTP_SEE_OTHER);
    }
}
