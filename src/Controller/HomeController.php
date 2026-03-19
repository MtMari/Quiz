<?php

namespace App\Controller;

use App\Repository\ArgomentoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index( ArgomentoRepository $argomentoRepository, Request $request, RequestStack $requestStack ): Response
    {
        $argomenti = $argomentoRepository->findAllConDomandas();

        $session = $request->getSession();
        // dd($session->getMetadataBag()->getLifetime());

        // $session =  $requestStack->getSession();
        // $session->set('foo-name', 'foo-value');
        // // dump($argomenti);
        $session->set('argomenti', $argomenti);
        // dump($session);

        dump($session);

        return $this->render('home/index.html.twig', [
            'titolo'    => 'Benvenuto',
            'testo'     => 'Scegli un quiz',
            'controller_name' => 'HomeController',
            'argomenti' => $argomenti
        ]);
    }
}
