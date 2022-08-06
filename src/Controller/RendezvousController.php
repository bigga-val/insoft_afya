<?php

namespace App\Controller;

use App\Entity\Rendezvous;
use App\Form\RendezvousType;
use App\Repository\ChoixMedecinRepository;
use App\Repository\RendezvousRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/rendezvous')]
class RendezvousController extends AbstractController
{
    #[Route('/', name: 'rendezvous_index', methods: ['GET'])]
    public function index(RendezvousRepository $rendezvousRepository): Response
    {
        return $this->render('rendezvous/index.html.twig', [
            'rendezvouses' => $rendezvousRepository->findAll(),
        ]);
    }

    #[Route('/{choix}/new', name: 'rendezvous_new', methods: ['GET','POST'])]
    public function new(Request $request, RendezvousRepository $rendezvousRepository, ChoixMedecinRepository $choixMedecinRepository,$choix): Response
    {
        $rendezvou = new Rendezvous();
        $form = $this->createForm(RendezvousType::class, $rendezvou);
        $form->handleRequest($request);
        $choixMed = $choixMedecinRepository->find($choix);
        $rendezvous = $rendezvousRepository->findBy(['ChoixMedecin'=> $choix]);
        if ($request->isMethod("POST")) {
            if($this->isCsrfTokenValid('csrf_token', $request->request->get("csrf_token"))){
                $rendezvou->setCreatedAt(new \DateTimeImmutable());
                $rendezvou->setChoixMedecin($choixMed);
                $rendezvou->setCreatedBy($this->getUser()->getUserIdentifier());
                $rendezvou->setHeureRendezvous(new \DateTimeImmutable($request->request->get('heurerdv'))) ;
                $rendezvou->setMotif($request->request->get('motifrdv'));
                //dd($rendezvou);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($rendezvou);
                $entityManager->flush();

                //return $this->redirectToRoute('rendezvous_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('rendezvous/new.html.twig', [
            'rendezvou' => $rendezvou,
            'rendezvous'=> $rendezvous,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'rendezvous_show', methods: ['GET'])]
    public function show(Rendezvous $rendezvou): Response
    {
        return $this->render('rendezvous/show.html.twig', [
            'rendezvou' => $rendezvou,
        ]);
    }

    #[Route('/{id}/edit', name: 'rendezvous_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Rendezvous $rendezvou): Response
    {
        $form = $this->createForm(RendezvousType::class, $rendezvou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rendezvous_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rendezvous/edit.html.twig', [
            'rendezvou' => $rendezvou,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'rendezvous_delete', methods: ['POST'])]
    public function delete(Request $request, Rendezvous $rendezvou): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rendezvou->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rendezvou);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rendezvous_index', [], Response::HTTP_SEE_OTHER);
    }
}
