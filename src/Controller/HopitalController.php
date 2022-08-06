<?php

namespace App\Controller;

use App\Entity\Hopital;
use App\Entity\Patient;
use App\Entity\Person;
use App\Entity\User;
use App\Form\HopitalType;
use App\Entity\ServiceHopital;
use App\Form\ServiceHopitalType;
use App\Repository\HopitalRepository;
use App\Repository\ServiceHopitalRepository;
use phpDocumentor\Reflection\Types\This;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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

    #[Route('/create', name:'hopital_create', methods:['GET', 'POST'])]
    public function create(Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        if($request->isMethod('POST')){
            //dump($request->request);
            if($this->isCsrfTokenValid('csrf_token', $request->request->get('csrf_token')))
            {
                //var_dump($request->request);
                $user = new User();
                $user->setRoles(["ROLE_HOPITAL"]);
                $user->setEmail($request->request->get('emailHopital'));
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $request->request->get('passwordHopital')
                    ));
                $user->setUsername($request->request->get('NomHopital'));
                $user->setEmail($request->request->get('emailHopital'));
                $entityManager->persist($user);
                $person = new Person();
                $person->setUserPerson($user);
                $person->setEditedAt(new \DateTimeImmutable());
                $person->setCreatedBy($request->request->get('NomHopital'));
                $person->setCreatedAt(new \DateTimeImmutable());
                $entityManager->persist($person);
                $hopital = new Hopital();
                $hopital->setPerson($person);
                $hopital->setAdresse($request->request->get('AdressHopital'));
                $hopital->setNomHopital($request->request->get('NomHopital'));
                $hopital->setNoUrgence($request->request->get('NoUrgence'));

                $entityManager->persist($hopital);

                $entityManager->flush();
                return $this->redirectToRoute("hopital_index");
            }else{

            }
        }

        return $this->render('hopital/create.html.twig');
    }


    #[Route('/new', name: 'hopital_new', methods: ['GET','POST']), IsGranted('ROLE_ADMIN')]
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


    #[Route('/news', name: 'service_Hopital', methods: ['GET','POST'])]
    public function serviceToHopital(Request $request, ServiceHopital $serviceHopital): Response
    {
        $form = $this->createForm(ServiceHopitalType::class, $serviceHopital);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $serviceHopital->setCreatedBy($this->getUser());
            $serviceHopital->setCreatedAt(new \DateTimeImmutable());
            $serviceHopital->setStatus(1);
        }
        return $this->render('hopital/serviceToHopital.html.twig');
    }
}
