<?php

namespace App\DataFixtures;

use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class QuestionFixtures
 * @package App\DataFixtures
 */
class QuestionFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for($it = 1; $it <= 10; $it++) {
            $question = new Question();
            $question->setName(sprintf('Question %d', $it));

            $manager->persist($question);

            $this->addReference(sprintf('question_%d', $it), $question);
        }

        $manager->flush();
    }
}
