<?php

namespace App\DataFixtures;

use App\Entity\UserAnswer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class UserAnswerFixtures
 * @package App\DataFixtures
 */
class UserAnswerFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for($itUser = 1; $itUser <= 20; $itUser++) {
            $user = $this->getReference(sprintf('user_%d', $itUser));

            for($itQuestion = 1; $itQuestion <= 10; $itQuestion++) {
                $question = $this->getReference(sprintf('question_%d', $itQuestion));

                $userAnswer = new UserAnswer();
                $userAnswer->setUser($user);
                $userAnswer->setQuestion($question);
                $userAnswer->setAnswer(rand(0, 5));

                $manager->persist($userAnswer);
            }
        }

        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            QuestionFixtures::class
        ];
    }
}
