<?php

namespace App\Form;

use App\DataTransformer\QuestionToIdModelTransformer;
use App\DataTransformer\QuestionToIdViewTransformer;
use App\Entity\Question;
use App\Entity\UserAnswer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * Class UserAnswerType
 * @package App\Form
 */
class UserAnswerType extends AbstractType
{
    /**
     * @var QuestionToIdModelTransformer
     */
    private $questionToIdModelTransformer;
    /**
     * @var QuestionToIdViewTransformer
     */
    private $questionToIdViewTransformer;

    /**
     * UserAnswerType constructor.
     * @param QuestionToIdModelTransformer $questionToIdModelTransformer
     * @param QuestionToIdViewTransformer $questionToIdViewTransformer
     */
    public function __construct(QuestionToIdModelTransformer $questionToIdModelTransformer, QuestionToIdViewTransformer $questionToIdViewTransformer)
    {
        $this->questionToIdModelTransformer = $questionToIdModelTransformer;
        $this->questionToIdViewTransformer = $questionToIdViewTransformer;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('answer', ChoiceType::class, [
                'choices' => range(0, 5),
                'expanded' => true,
                'constraints' => [
                    new NotNull(['message' => sprintf('Please provide an answer to question "%s"', $options['question']->getName())])
                ],
                'label' => false,
                'block_prefix' => 'answers_weight',
            ])
            ->add('question', HiddenType::class, [
                'data' => $options['question']->getId()
            ]);

        $builder->get('question')->addViewTransformer($this->questionToIdViewTransformer);
        $builder->get('question')->addModelTransformer($this->questionToIdModelTransformer);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserAnswer::class,
            'question' => null
        ]);

        $resolver->setAllowedTypes('question', Question::class);
    }
}
