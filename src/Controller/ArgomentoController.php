<?php

namespace App\Controller;

use App\Entity\Argomento;
use App\Event\Argomento\DeleteArgomentoEvent;
use App\Event\Argomento\EditArgomentoEvent;
use App\Event\Argomento\NewArgomentoEvent;
use App\Form\ArgomentoType;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Attribute\WithMonologChannel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[WithMonologChannel('argomento')]
#[Route('/argomento')]
final class ArgomentoController extends AbstractController
{
    #[Route('/new', name: 'app_argomento_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new( Request $request, EntityManagerInterface $entityManager, EventDispatcherInterface $dispatcher): Response
    {
        $argomento = new Argomento();
        $form = $this->createForm(ArgomentoType::class, $argomento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($argomento);
            $entityManager->flush();

            $event = new NewArgomentoEvent($argomento);
            $dispatcher->dispatch($event, NewArgomentoEvent::class);

            return $this->redirectToRoute('app_quiz_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('argomento/new.html.twig', [
            'argomento' => $argomento,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_argomento_show', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function show(Argomento $argomento): Response
    {
        return $this->render('argomento/show.html.twig', [
            'argomento' => $argomento,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_argomento_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Argomento $argomento, EntityManagerInterface $entityManager, EventDispatcherInterface $dispatcher): Response
    {
        $form = $this->createForm(ArgomentoType::class, $argomento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $event = new EditArgomentoEvent($argomento);
            $dispatcher->dispatch($event, EditArgomentoEvent::class);

            return $this->redirectToRoute('app_argomento_show', ['id' => $argomento->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('argomento/edit.html.twig', [
            'argomento' => $argomento,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_argomento_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Argomento $argomento, EntityManagerInterface $entityManager, EventDispatcherInterface $dispatcher): Response
    {
        if ($this->isCsrfTokenValid('delete'.$argomento->getId(), $request->getPayload()->getString('_token'))) {
            
            $event = new DeleteArgomentoEvent($argomento);
            $dispatcher->dispatch($event, DeleteArgomentoEvent::class);

            $entityManager->remove($argomento);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_quiz_index', [], Response::HTTP_SEE_OTHER);
    }
}
