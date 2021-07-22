<?php

namespace App\Controller;

use App\Entity\Jet;
use App\Form\JetType;
use App\Repository\JetRepository;
use App\Service\UrlName;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/jet', name: 'jet_')]
class JetController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(JetRepository $jetRepository): Response
    {
        return $this->render('jet/index.html.twig', [
            'jets' => $jetRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    /**
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request, UrlName $urlName): Response
    {
        $jet = new Jet();
        $form = $this->createForm(JetType::class, $jet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            //Appel du service
            $urlName = $urlName->generate($jet->getNom());
            $jet->setUrlName($urlName);
            $entityManager->persist($jet);
            $entityManager->flush();

            return $this->redirectToRoute('jet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('jet/new.html.twig', [
            'jet' => $jet,
            'form' => $form,
        ]);
    }

    #[Route('/{urlName}', name: 'show', methods: ['GET'])]
    public function show(Jet $jet): Response
    {
        return $this->render('jet/show.html.twig', [
            'jet' => $jet,
        ]);
    }

    #[Route('/{urlName}/edit', name: 'edit', methods: ['GET', 'POST'])]
    /**
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Jet $jet): Response
    {
        $form = $this->createForm(JetType::class, $jet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('jet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('jet/edit.html.twig', [
            'jet' => $jet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    /**
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Jet $jet): Response
    {
        if ($this->isCsrfTokenValid('delete'.$jet->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($jet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('jet_index', [], Response::HTTP_SEE_OTHER);
    }
}
