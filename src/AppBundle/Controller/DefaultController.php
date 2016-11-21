<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Movie;
use AppBundle\Entity\Session;
use AppBundle\Event\MovieEvent;
use AppBundle\Event\VoteEvent;
use AppBundle\Form\MovieType;
use AppBundle\Form\VoteType;
use AppBundle\Model\Vote;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $sessionManager = $this->get('app.manager.session');
        $movieDay = $sessionManager->findFirstTuesdayOfMonth($sessionManager->findCurrentMonth(), true);

        if (false === $sessionManager->sessionExists($movieDay)) {
            $session = new Session();
            $session->setDate($movieDay);

            $em = $this->getDoctrine()->getManagerForClass(Session::class);
            $em->persist($session);
            $em->flush();
        }
        $session = $sessionManager->findCurrentSession();

        $voteForm = $this->createForm(VoteType::class, $this->get('app.manager.vote')->prepareVote($session, $request->getClientIp()));
        $voteForm->handleRequest($request);

        if ($voteForm->isSubmitted() && $voteForm->isValid()) {
            $event = new VoteEvent($session, $voteForm->getData(), $request->getClientIp());
            $this->get('event_dispatcher')->dispatch(VoteEvent::VOTE, $event);

            $this->addFlash('success', 'Votre vote a bien été pris en compte');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('default/index.html.twig', [
            'session' => $session,
            'voteForm' => $voteForm->createView(),
            'sessionVoters' => $sessionManager->findAllVoters($session),
        ]);
    }

    /**
     * @Route("/new-movie", name="movie_new")
     */
    public function movieAction(Request $request)
    {
        $session = $this->get('app.manager.session')->findCurrentSession();

        $form = $this->createForm(MovieType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event = new MovieEvent($form->getData(), $session, $request->getClientIp());
            $this->get('event_dispatcher')->dispatch(MovieEvent::MOVIE_NEW, $event);

            $this->addFlash('success', 'Film ajouté à la liste');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('default/movie.html.twig', [
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }
}
