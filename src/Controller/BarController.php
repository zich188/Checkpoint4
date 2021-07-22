<?php

namespace App\Controller;

use App\Entity\Bar;
use App\Form\BarType;
use App\Form\SearchByType;
use App\Repository\BarRepository;
use App\Service\UrlName;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/bar', name: 'bar_')]
class BarController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(BarRepository $barRepository, Request $request): Response
    {
        $form = $this->createForm(SearchByType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData()['search'];
            $bar = $barRepository->findBy(['nom' => $search]);
        } else {
            $bar = $barRepository->findAll();
        }

        return $this->render('bar/index.html.twig', [
            'bars' => $bar,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, UrlName $urlName): Response
        /**
         * @IsGranted("ROLE_ADMIN")
         */
    {
        $bar = new Bar();
        $form = $this->createForm(BarType::class, $bar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            //Appel du service Slugify
            $urlName = $urlName->generate($bar->getNom());
            $bar->setUrlName($urlName);
            $entityManager->persist($bar);
            $entityManager->flush();

            return $this->redirectToRoute('bar_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bar/new.html.twig', [
            'bar' => $bar,
            'form' => $form,
        ]);
    }


    #[Route('/{urlName}', name: 'show', methods: ['GET'])]
    public function show(Bar $bar): Response
    {
        return $this->render('bar/show.html.twig', [
            'bar' => $bar,
        ]);
    }

    #[Route('/{urlName}/edit', name: 'edit', methods: ['GET', 'POST'])]
    /**
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Bar $bar): Response
    {
        $form = $this->createForm(BarType::class, $bar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bar_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bar/edit.html.twig', [
            'bar' => $bar,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Bar $bar): Response
        /**
         * @IsGranted("ROLE_ADMIN")
         */
    {
        if ($this->isCsrfTokenValid('delete'.$bar->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bar);
            $entityManager->flush();
        }

        return $this->redirectToRoute('bar_index', [], Response::HTTP_SEE_OTHER);
    }
}
