<?php

namespace App\Controller;

use App\EventSubscriber\AddDynamicRispostaFieldSubscriber;
use App\Form\QuizType;
use App\Repository\ArgomentoRepository;
use App\Repository\DomandaRepository;
use App\Service\CalcoloPunteggio;
use App\Service\CalcoloPuntiTotali;
use App\Service\RispostasByPost;
use Monolog\Attribute\WithMonologChannel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[WithMonologChannel('quiz')]
#[Route('/quiz')]
final class QuizController extends AbstractController
{
    #[Route(name: 'app_quiz', methods: ['GET'])]
    public function list( ArgomentoRepository $argomentoRepository ): Response
    {
        $argomenti = $argomentoRepository->findAllConDomandas();
        dump($argomenti);

        return $this->render('quiz/list.html.twig', [
            'controller_name' => 'QuizController',
            'argomenti' => $argomenti
        ]);
    }

    #[Route('/indiceQuiz', name: 'app_quiz_index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index( ArgomentoRepository $argomentoRepository ): Response
    {
        $dati = $argomentoRepository->argomentoPerDomanda();

        return $this->render('quiz/index.html.twig', [
            'dati' => $dati,
        ]);
    }

    #[Route('/{nomeArgomento}', name: 'app_quiz_argomento', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function quiz( string $nomeArgomento, ArgomentoRepository $argomentoRepository, Request $request ): Response
    {
        $cleanNomeArgomento = str_replace('-', ' ', $nomeArgomento);
        $dati = $argomentoRepository->argomentoPerNomeArgomento($cleanNomeArgomento);

        // TEST-SESSIONE
        // dump($request->getSession()->get('user'));
        // 

        return $this->render('quiz/quiz.html.twig', [
            'controller_name' => 'app_quiz_argomento',
            'nomeArgomento' => $nomeArgomento,
            'dati' => $dati,
        ]);
    }

    #[Route('/{nomeArgomento}/risultato', name: 'app_quiz_risultato', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function quizRisultato( 
        string $nomeArgomento,
        Request $request, 
        CalcoloPuntiTotali $calcoloPuntiTotali,
        RispostasByPost $rispostasByPost,
        CalcoloPunteggio $calcoloPunteggio,
        DomandaRepository $dr
        ): Response
    {
        $puntiTotali = $calcoloPuntiTotali->calcoloPuntiTotali( $nomeArgomento );

        $rispostas = $rispostasByPost->rispostasByPost( $request->request->all());

        // TEST-SESSIONE
        dump($request->request->all());
        // $session = $request->getSession();
        // dump($this->getUser()->getUserIdentifier());
        // $session->set('user', [$this->getUser()->getUserIdentifier() => $request->request->all()]);
        // dump($session->get('user'));
        // 

        $punteggioFinale = $calcoloPunteggio->calcoloPunteggio( $rispostas );


        return $this->render('quiz/risultato.html.twig', [
            'controller_name' => 'app_quiz_argomento',
            'nomeArgomento' => $nomeArgomento,
            'punteggioFinale' => $punteggioFinale,
            'puntiTotali' => $puntiTotali
        ]);
    }
}
