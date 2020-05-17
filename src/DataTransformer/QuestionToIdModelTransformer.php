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
class QuestionToIdModelTransformer implements DataTransformerInterface
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
     * @param $question
     * @return mixed
     */
    public function transform($question)
    {
        return $question;
    }

    /**
     * @param mixed $id
     * @return Question|mixed|void|null
     */
    public function reverseTransform($id)
    {
        if(!$id) {
            return;
        }

        $question = $this->questionRepository->find($id);

        if(!$question) {
            throw new TransformationFailedException(sprintf(
                'A question with id "%s" does not exist!',
                $id
            ));
        }

        return $question;
    }
}