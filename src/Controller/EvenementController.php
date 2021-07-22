<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Event;
use App\Entity\UserEvent;
use App\Entity\UserEventRole;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use App\Repository\UserEventRepository;
use App\Repository\UserEventRoleRepository;
use App\Service\UrlName;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/evenement', name: 'evenement_')]
class EvenementController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(EvenementRepository $evenementRepository): Response
    {
        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    /**
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request, UrlName $urlName): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $urlName = $urlName->generate($evenement->getTitre());
            $evenement->setUrlName($urlName);
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{urlName}', name: 'show', methods: ['GET'])]
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    #[Route('/{urlName}/edit', name: 'edit', methods: ['GET', 'POST'])]
    /**
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Evenement $evenement): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    /**
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Evenement $evenement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('evenement_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/{id}/participe/{participe}", name="participe", methods={"GET"})
     */
    public function participe(
        Request $request,
        Evenement $event,
        UserEventRepository $userRepository,
        int $participe
    ): Response {
        $userEventRole = $userRepository->findOneBy(['user' => $this->getUser(), 'event' => $event]);
        if (!$userEventRole) {
            $userEventRole = new UserEvent();
            $user = $this->getUser();
            $userEventRole->setUser($user);
            $userEventRole->setResponse($participe);
            $userEventRole->setEvent($event);
            $this->getDoctrine()->getManager()->persist($userEventRole);
        }
        $userEventRole->setResponse($participe);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('evenement_index');
    }
}
