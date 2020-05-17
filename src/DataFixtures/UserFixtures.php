<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserFixtures
 * @package App\DataFixtures
 */
class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    /**
     * UserFixtures constructor.
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for($it = 1; $it <= 20; $it++) {
            $user = new User();
            $user->setEmail(sprintf('surver_user_%d@survey.com', $it));
            $user->setPassword($this->userPasswordEncoder->encodePassword($user, $user->getEmail()));
            $user->setRoles(['ROLE_USER']);
            $user->setHasSurveyCompleted(true);

            $manager->persist($user);

            $this->addReference(sprintf('user_%d', $it), $user);
        }

        $userAdmin = new User();
        $userAdmin->setEmail('admin');
        $userAdmin->setPassword($this->userPasswordEncoder->encodePassword($userAdmin, 'admin'));
        $userAdmin->setRoles(['ROLE_ADMIN']);
        $userAdmin->setHasSurveyCompleted(false);

        $manager->persist($userAdmin);;

        $manager->flush();
    }
}
