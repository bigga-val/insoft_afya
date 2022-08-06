<?php

namespace App\Controller;

use App\Entity\Doctor;
use App\Entity\Person;
use App\Entity\User;
use App\Form\DoctorType;
use App\Repository\DoctorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/doctor')]
class DoctorController extends AbstractController
{
    #[Route('/', name: 'doctor_index', methods: ['GET'])]
    public function index(DoctorRepository $doctorRepository): Response
    {
        return $this->render('doctor/index.html.twig', [
            'doctors' => $doctorRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'doctor_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        if($request->isMethod('POST')){
            if($this->isCsrfTokenValid('csrf_token', $request->request->get('csrf_token'))){
                $user = new User();
                $user->setUsername($request->request->get('DoctorName'));
                $user->setEmail($request->request->get('DoctorEmail'));
                $user->setPassword($request->request->get('DoctorPassword'));
                $user->setRoles(["ROLE_MEDECIN"]);
                //$user->setPassword($request->request->get('DoctorPassword'));
                $user->setCreatedAt(new \DateTimeImmutable());
                $user->setCreatedBy("currentSeession");
                $entityManager->persist($user);
                //person creation
                $person = new Person();
                $person->setCreatedBy("currentSesssion");
                $person->setCreatedAt(new \DateTimeImmutable());
                $person->setUserPerson($user);
                $person->setEditedAt(new \DateTimeImmutable());
                $person->setNomPostnom($request->request->get('DoctorName'));
                $person->setTelephone($request->request->get('Doctortelephone'));
                $entityManager->persist($person);

                //doctor creation
                $medecin = new Doctor();
                $medecin->setCreatedAt(new \DateTimeImmutable());
                $medecin->setCreatedBy("currentSession");
                $medecin->setPerson($person);
                $medecin->setMatricule($request->request->get("DoctorMatricule"));
                $medecin->setTelephone($request->request->get("Doctortelephone"));
                $entityManager->persist($medecin);
                $entityManager->flush();
                return $this->render("doctor_index");
            }
        }
        $doctor = new Doctor();

//        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($doctor);
//            $entityManager->flush();
//
//            return $this->redirectToRoute('doctor_index', [], Response::HTTP_SEE_OTHER);
//        }

        return $this->renderForm('doctor/new.html.twig', [
            //'doctor' => $doctor,
            //'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'doctor_show', methods: ['GET'])]
    public function show(Doctor $doctor): Response
    {
        return $this->render('doctor/show.html.twig', [
            'doctor' => $doctor,
        ]);
    }

    #[Route('/{id}/edit', name: 'doctor_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Doctor $doctor): Response
    {
        $form = $this->createForm(DoctorType::class, $doctor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('doctor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('doctor/edit.html.twig', [
            'doctor' => $doctor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'doctor_delete', methods: ['POST'])]
    public function delete(Request $request, Doctor $doctor): Response
    {
        if ($this->isCsrfTokenValid('delete'.$doctor->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($doctor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('doctor_index', [], Response::HTTP_SEE_OTHER);
    }
}
