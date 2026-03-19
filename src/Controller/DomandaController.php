<?php

namespace App\Controller;

use App\Entity\Domanda;
use App\Event\Argomento\DeleteArgomentoEvent;
use App\Event\Domanda\DeleteDomandaEvent;
use App\Event\Domanda\EditDomandaEvent;
use App\Event\Domanda\NewDomandaEvent;
use App\Form\DomandaType;
use App\Repository\ArgomentoRepository;
use App\Repository\DomandaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Attribute\WithMonologChannel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[WithMonologChannel('domanda')]
#[Route('/domanda')]
final class DomandaController extends AbstractController
{
    #[Route('/new', name: 'app_domanda_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(?string $nomeArgomento= null, ArgomentoRepository $argomentoRepository, Request $request, EntityManagerInterface $entityManager, EventDispatcherInterface $dispatcher): Response
    {
        $domanda = new Domanda();

        if($request->get('nomeArgomento'))
        {
            $argomento = $argomentoRepository->findOneBy(['nome_argomento' => $request->get('nomeArgomento')]);
            $domanda->setArgomento($argomento);
        }

        $form = $this->createForm(DomandaType::class, $domanda);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($domanda);
            $entityManager->flush();

            $event = new NewDomandaEvent($domanda);
            $dispatcher->dispatch($event, NewDomandaEvent::class);

            return $this->redirectToRoute('app_quiz_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('domanda/new.html.twig', [
            'domanda' => $domanda,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_domanda_show', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function show( Domanda $domanda, DomandaRepository $domandaRepository ): Response
    {
        $rispostasCorrette = $domandaRepository->getRispostasCorrette($domanda->getId());
        $rispostasSbagliate = $domandaRepository->getRispostasSbagliate($domanda->getId());

        return $this->render('domanda/show.html.twig', [
            'domanda' => $domanda,
            'rispostasCorrette' => $rispostasCorrette,
            'rispostasSbagliate' => $rispostasSbagliate
        ]);
    }

    #[Route('/{id}/edit', name: 'app_domanda_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Domanda $domanda, EntityManagerInterface $entityManager, EventDispatcherInterface $dispatcher): Response
    {
        $form = $this->createForm(DomandaType::class, $domanda);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $event = new EditDomandaEvent($domanda);
            $dispatcher->dispatch($event);

            return $this->redirectToRoute('app_domanda_show', ['id' => $domanda->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('domanda/edit.html.twig', [
            'domanda' => $domanda,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_domanda_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Domanda $domanda, EntityManagerInterface $entityManager, EventDispatcherInterface $dispatcher): Response
    {
        if ($this->isCsrfTokenValid('delete'.$domanda->getId(), $request->getPayload()->getString('_token'))) {

            $event = new DeleteDomandaEvent($domanda);
            $dispatcher->dispatch($event);
            
            $entityManager->remove($domanda);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_quiz_index', [], Response::HTTP_SEE_OTHER);
    }
}
