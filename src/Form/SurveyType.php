<?php

namespace App\Form;

use App\Repository\QuestionRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class QuizType
 * @package App\Form
 */
class SurveyType extends AbstractType
{
    /**
     * @var QuestionRepository
     */
    private $questionRepository;

    /**
     * QuizType constructor.
     * @param QuestionRepository $questionRepository
     */
    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $questions = $this->questionRepository->findBy([], ['id' => 'asc'], 5, ($options['step'] - 1) * 5);

        foreach($questions as $question) {
            $builder
                ->add(sprintf('answer_%s', $question->getId()), UserAnswerType::class, [
                    'question' => $question,
                    'label' => $question->getName(),
                ])
            ;
        }
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'step' => 1
        ]);
    }
}
