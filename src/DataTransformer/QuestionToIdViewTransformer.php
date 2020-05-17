<?php

namespace App\DataTransformer;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Class QuestionToIdTransformer
 * @package App\DataTransformer
 */
class QuestionToIdViewTransformer implements DataTransformerInterface
{
    /**
     * @var QuestionRepository
     */
    private $questionRepository;

    /**
     * QuestionToIdTransformer constructor.
     * @param QuestionRepository $questionRepository
     */
    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    /**
     * @param $id
     * @return mixed|string|null
     */
    public function transform($id)
    {
        if(!$id) {
            return null;
        }

        $question = $this->questionRepository->find($id);

        if(!$question) {
            throw new TransformationFailedException(sprintf(
                'A question with id "%s" does not exist!',
                $id
            ));
        }

        return sprintf('%s', $question->getId());
    }

    /**
     * @param $question
     * @return Question|mixed|void|null
     */
    public function reverseTransform($question)
    {
        return $question;
    }
}