<?php

namespace App\Service;

use App\Entity\Question;
use App\Entity\User;
use App\Entity\UserAnswer;
use App\Model\Stats;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class QuizManager
 * @package App\Service
 */
class SurveyManager
{
    /**
     *
     */
    const LAST_SURVEY_STEP = 2;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * QuizManager constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param User $user
     * @param $quizData
     * @param bool $markSurveyCompleted
     */
    public function saveStepAnswers(User $user, $quizData, $markSurveyCompleted = false)
    {
        foreach($quizData as $answerData) {
            $userAnswer = $this->entityManager->getRepository(UserAnswer::class)->findOneBy(['user' => $user, 'question' => $answerData->getQuestion()]);
            if(is_null($userAnswer)) {
                $userAnswer = new UserAnswer();
            }
            $userAnswer->setUser($user);
            $userAnswer->setQuestion($answerData->getQuestion());
            $userAnswer->setAnswer($answerData->getAnswer());

            $this->entityManager->persist($userAnswer);
        }

        if($markSurveyCompleted) {
            $user->setHasSurveyCompleted(true);
        }

        $this->entityManager->flush();
    }

    /**
     * @param User $user
     * @return array
     */
    public function getData(User $user)
    {
        $answers = [];

        foreach($user->getUserAnswers() as $userAnswer) {
            $answers[sprintf('answer_%s', $userAnswer->getQuestion()->getId())] = $userAnswer;
        }

        return $answers;
    }

    /**
     * @return Stats
     */
    public function getStats()
    {
        $stats = $this->entityManager->getRepository(Question::class)->getStats();

        return new Stats($stats);
    }
}