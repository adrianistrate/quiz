<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SurveyType;
use App\Service\SurveyManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomepageController
 * @package App\Controller
 */
class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @param SurveyManager $surveyManager
     * @return Response
     */
    public function index(Request $request, SurveyManager $surveyManager)
    {
        /** @var User $user */
        $user = $this->getUser();

        if($user->getHasSurveyCompleted()) {
            return $this->redirectToRoute('stats');
        }

        $step = $request->get('step', 1);

        $quizForm = $this->createForm(SurveyType::class, $surveyManager->getData($user), ['step' => $step]);

        if ($request->getMethod() == Request::METHOD_POST) {
            $quizForm->handleRequest($request);

            if ($quizForm->isSubmitted() && $quizForm->isValid()) {
                $surveyManager->saveStepAnswers($user, $quizForm->getData(), ($step == SurveyManager::LAST_SURVEY_STEP ? true : false));

                if($step == SurveyManager::LAST_SURVEY_STEP) {
                    return $this->redirectToRoute('stats');
                } else {
                    return $this->redirectToRoute('homepage', ['step' => ($step + 1)]);
                }
            }
        }

        return $this->render('homepage/index.html.twig', [
            'quizForm' => $quizForm->createView()
        ]);
    }

    /**
     * @Route("/stats", name="stats")
     * @param SurveyManager $surveyManager
     * @return Response
     */
    public function stats(SurveyManager $surveyManager)
    {
        if($this->getUser()->getHasSurveyCompleted() == false && !$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('homepage');
        }

        $stats = $surveyManager->getStats();

        return $this->render('homepage/stats.html.twig', ['stats' => $stats]);
    }
}
