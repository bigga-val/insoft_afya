<?php

namespace App\Controller;

use App\Entity\Person;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\ChoixMedecinRepository;
use App\Repository\DoctorRepository;
use App\Repository\MedecinServiceHopitalRepository;
use App\Repository\PatientRepository;
use App\Repository\PersonRepository;
use App\Repository\RendezvousRepository;
use App\Repository\UserRepository;
use mysql_xdevapi\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

#[Route('/user')]
class UserController extends AbstractController
{

    #[Route('/indexes', name: 'user_indexes', methods: ['GET'])]
    public function indexes(UserRepository $userRepository, Request $request): Response
    {
        $session = $request->getSession();
        //$session->start();
        if(in_array("ROLE_PATIENT", $this->getUser()->getRoles(), true)){
            $session->set('role', 'Patient');
            return $this->redirect($this->generateUrl("user_dashboard", ["id"=>$this->getUser()->getId()]));
        }else if(in_array("ROLE_MEDECIN", $this->getUser()->getRoles(), true)){
            $session->set('role', 'Medecin');
            return $this->redirect($this->generateUrl("user_dashboard_doctor", ["id"=>$this->getUser()->getId()]));
        }else if(in_array("ROLE_HOPITAL", $this->getUser()->getRoles(), true)){
            $session->set('role', 'Hopital');
            return $this->redirect($this->generateUrl("user_dashboard_hopital", ["id"=>$this->getUser()->getId()]));
        }else if(in_array("ROLE_ADMIN", $this->getUser()->getRoles(), true)){
            $session->set('role', 'Admin');
            return $this->redirect($this->generateUrl("user_dashboard_admin", ["id"=>$this->getUser()->getId()]));
        }
    }


    #[Route('/', name: 'user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        if($this->isGranted("ROLE_ADMIN")){
            return $this->render('user/index.html.twig', [
                'users' => $userRepository->findAll(),
            ]);
        }

        return new \Exception("Access Denyes");

    }

    #[Route('/new', name: 'user_new', methods: ['GET','POST']), ]
    /**
     * @param Request $request
     * @param UserPasswordHasherInterface $passwordHasher
     * @return Response
     */
    public function new(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        //$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));
            $entityManager = $this->getDoctrine()->getManager();
            $person = new Person();
            $user->setUserPerson($person);
            $user->setRoles(["ROLE_MEDECIN"]);
            $person->setEditedAt(new \DateTimeImmutable());
            $person->setCreatedAt(new \DateTimeImmutable());
            $person->setCreatedBy("kj");
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/dashboard', name:'user_dashboard', methods:['Get', 'POST'])]
    public function dashboard(User $user, ChoixMedecinRepository $choixMedecinRepository,
                                PersonRepository $personRepository, PatientRepository $patientRepository,
                                RendezvousRepository $rendezvousRepository
    )
    {
        $loggedPerson = $personRepository->findOneBy(['UserPerson'=>$user->getId()]);
        $patient = $patientRepository->findOneBy(['Person'=>$loggedPerson->getId()]);
        $services = $choixMedecinRepository->findBy(['patient'=>$patient->getId()]);
        //$rendezvous = $rendezvousRepository->findBy(['']);
        return $this->render('user/dashboard.html.twig',[
            'user'=>$user,
            'services'=> $services
        ]);
    }

    #[Route('/{id}/dashboard_doctor', name:'user_dashboard_doctor', methods:['Get', 'POST'])]
    public function dashboard_doctor(User $user, ChoixMedecinRepository $choixMedecinRepository,
                                     PersonRepository $personRepository, PatientRepository $patientRepository,
                                     MedecinServiceHopitalRepository $medecinServiceHopitalRepository,
                                        DoctorRepository $doctorRepository
    )
    {
       //dd($user->getId());
        $person = $personRepository->findOneBy(["UserPerson"=>$user->getId()]);
        $medecin = $doctorRepository->findOneBy(["Person"=>$person->getId()]);
        $msh = $medecinServiceHopitalRepository->findBy(["medecin"=>$medecin->getId(), "status"=>"active"]);
        //$choixmed = $choixMedecinRepository->findBy(["medecin_service_hopital"=>$msh->getId()]);
        return $this->render('user/dashboard_doctor.html.twig',[
            'user'=>$user,
            'attributions'=>$msh,
        ]);
    }


    #[Route('/{id}/edit', name: 'user_edit', methods: ['GET','POST'])]
    public function edit(Request $request, User $user, UserPasswordHasherInterface $hasher): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
//            $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));
            $user->setPassword($hasher->hashPassword($user, $user->getPassword()));
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }
}
