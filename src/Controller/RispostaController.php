<?php

namespace App\Controller;

use App\Entity\Risposta;
use App\Form\RispostaType;
use App\Repository\RispostaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Attribute\WithMonologChannel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[WithMonologChannel('risposta')]
#[Route('/risposta')]
final class RispostaController extends AbstractController
{
    #[Route(name: 'app_risposta_index', methods: ['GET'])]
    public function index(RispostaRepository $rispostaRepository): Response
    {
        return $this->redirectToRoute('app_quiz_index', [], Response::HTTP_SEE_OTHER);

    }

    #[Route('/new', name: 'app_risposta_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $rispostum = new Risposta();
        $form = $this->createForm(RispostaType::class, $rispostum);
        $form->handleRequest($request);

        // test sessione
        $session = $request->getSession();
        // $foo = $session->get('foo-name');
        // $filters = $session->get('filters', []);
        // dump($foo);
        dump($session);
        // dump($filters);
        dump($session->getMetadataBag());

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($rispostum);
            $entityManager->flush();

            return $this->redirectToRoute('app_risposta_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('risposta/new.html.twig', [
            'rispostum' => $rispostum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_risposta_show', methods: ['GET'])]
    public function show(Risposta $rispostum): Response
    {
        return $this->render('risposta/show.html.twig', [
            'rispostum' => $rispostum,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_risposta_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Risposta $rispostum, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RispostaType::class, $rispostum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_risposta_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('risposta/edit.html.twig', [
            'rispostum' => $rispostum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_risposta_delete', methods: ['POST'])]
    public function delete(Request $request, Risposta $rispostum, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rispostum->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($rispostum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_risposta_index', [], Response::HTTP_SEE_OTHER);
    }
}
