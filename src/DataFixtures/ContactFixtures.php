<?php

namespace App\DataFixtures;


use App\Entity\Contact;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ContactFixtures extends Fixture
{

    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {

        $faker = Faker\Factory::create('en_GB');

        for ($j = 1; $j <= 3; ++$j) {
            $user[$j] = new User();
            $user[$j]->setEmail('user' . $j . '@test.lt');
            $user[$j]->setPassword($this->passwordHasher->hashPassword($user[$j], 'slaptazodis' . $j));
            $user[$j]->setRoles(['ROLE_USER']);
            $manager->persist($user[$j]);
        }

        for ($i = 1; $i <= 20; ++$i) {
            $randomNr = rand(1, 3);
            $contact[$i] = new Contact();
            $contact[$i]->setname($faker->name);
            $contact[$i]->setPhone($faker->phoneNumber);
            $contact[$i]->setUser($user[$randomNr]);
            $manager->persist($contact[$i]);
        }

        $manager->flush();
    }


}
