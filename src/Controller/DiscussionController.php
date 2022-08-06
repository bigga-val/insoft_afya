<?php

namespace App\Controller;

use App\Entity\Discussion;
use App\Form\DiscussionType;
use App\Repository\ChoixMedecinRepository;
use App\Repository\DiscussionRepository;
use App\Repository\UserRepository;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/discussion')]
class DiscussionController extends AbstractController
{
    #[Route('/{choix}/choix', name: 'discussion_index', methods: ['GET', 'POST'])]
    public function index(DiscussionRepository $discussionRepository, $choix): Response
    {

        $discussions = $discussionRepository->findBy(['user'=>$this->getUser()->getId()]);

        return $this->render('discussion/index.html.twig', [
            'discussions'=>$discussions
        ]);
    }

    #[Route('/{choix}/new', name: 'discussion_new', methods: ['GET','POST'])]
    public function new(DiscussionRepository $discussionRepository, Request $request, $choix): Response
    {
        $discussion = new Discussion();
        $discussions = $discussionRepository->findBy(['choixMedecin'=>$choix], ['id'=>'DESC']);
        //dd($discussions);
        return $this->render('discussion/new.html.twig', [
            'discussions' => $discussions,
            'choix' => $choix
        ]);
    }
    #[Route('/create_discussion', name:'create_discussion', methods:['POST'])]
    public function create_discussion(Request $request,UserRepository $userRepository, ChoixMedecinRepository $choixMedecinRepository)
    {
        $user = $userRepository->find($this->getUser()->getId());
        $choixMed = $choixMedecinRepository->find($request->request->get('choix'));
        if($request->isXmlHttpRequest()){
            $discussion = new Discussion();
            $discussion->setStatus("active");
            $discussion->setCreatedBy($this->getUser()->getUserIdentifier());
            $discussion->setCreatedAt(new \DateTimeImmutable());
            $discussion->setChoixMedecin($choixMed);
            $discussion->setMessage($request->request->get("message"));
            $discussion->setUser($user);
            $this->getDoctrine()->getManager()->persist($discussion);
            $this->getDoctrine()->getManager()->flush();
            return new JsonResponse(true);
        }
    }

    #[Route('/{id}', name: 'discussion_show', methods: ['GET'])]
    public function show(Discussion $discussion): Response
    {
        return $this->render('discussion/show.html.twig', [
            'discussion' => $discussion,
        ]);
    }

    #[Route('/{id}/edit', name: 'discussion_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Discussion $discussion): Response
    {
        $form = $this->createForm(DiscussionType::class, $discussion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('discussion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('discussion/edit.html.twig', [
            'discussion' => $discussion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'discussion_delete', methods: ['POST'])]
    public function delete(Request $request, Discussion $discussion): Response
    {
        if ($this->isCsrfTokenValid('delete'.$discussion->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($discussion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('discussion_index', [], Response::HTTP_SEE_OTHER);
    }
}
