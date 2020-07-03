<?php

namespace App\DataFixtures;

use App\Entity\Like;
use App\Entity\User;
use App\Entity\Books;
use App\Entity\Chapter;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager)
    {

        $faker = \Faker\Factory::create('fr_FR');
        $users = [];

        //Créer des users
        for($j = 0; $j < 3; $j++){
            
            $user = new User();
            // $password = "$2a$0DnDOFNZF78bH88iobfdsn_çEdhZHNSiieUnhe8-B2bdH0-JDJ.fuqipbN8ZhdJSèhedcoisnfHNenIH56#eFVD";
            $password = $this->encoder->encodePassword($user, 'password');
            $user->setEmail($faker->email)
                    ->setUsername($faker->name)
                    ->setPassword($password);
            
            $users[] = $user;
    
            $manager->persist($user);
        }

        for($i=1; $i <= 4; $i++){
            $book = new Books();

            $content = join($faker->paragraphs(5), '');
 
            $categories = [
            'littérature',
            'fantastique',
            'romance',
            'poésie',
            'policier',
            'essai'];

            $status = rand(0,1);
            $status2 = rand(0,1);

            $book->setTitle($faker->sentence())
                ->setContent($content)
                ->setAuthor($faker->name)
                ->setDate($faker->dateTimeBetween('-6 months'))
                ->setPublic($status)
                ->setCompleted($status2)
                ->setCategory($faker->randomElement($categories));

            $manager->persist($book);

            // //Créer des likes dans les books
            // for($j = 0; $j < mt_rand(0, 5); $j++){
            //     $like = new Like();
            //     $like->setUser($faker->randomElement($users))
            //         ->setBook($book)
            //         ->setCreatedAt($faker->dateTimeBetween('-6 months'));

            //     $manager->persist($like);
            // }

            // Créer chapters
            for($j = 1; $j <= mt_rand(3, 8); $j++)
            {
                $status = rand(0,1);
                $status2 = rand(0,1);

                $chapter = new Chapter();
                $chapter->setTitle($faker->sentence())
                        ->setContent($faker->paragraph(24))
                        ->setPublishedDate($faker->dateTimeBetween('-6 months'))
                        ->setBooks($book)
                        ->setPublic($status)
                        ->setCompleted($status2);

                $manager->persist($chapter);

                //Créer des likes dans les chap
                for($j = 0; $j < mt_rand(0, 8); $j++){
                    $like = new Like();
                    $like->setUser($faker->randomElement($users))
                        ->setChapter($chapter)
                        ->setCreatedAt($faker->dateTimeBetween('-6 months'));

                    $manager->persist($like);
                }


                //Créer comments
                for($k = 1; $k <= mt_rand(3, 6); $k++)
                {
                    $content = join($faker->paragraphs(2));

                    $comment = new Comment();

                    $now = new \DateTime();
                    $interval = $now->diff($chapter->getPublishedDate());
                    $days = $interval->days;
                    $min = '-'.$days. ' days'; //-100 days

                    $comment->setAuthor($faker->name)
                            ->setContent($content)
                            ->setCreatedAt($faker->dateTimeBetween($min))
                            ->setChapter($chapter);

                    $manager->persist($comment);

                    //Créer des likes dans les com
                    // for($j = 0; $j < mt_rand(0, 4); $j++){
                    //     $like = new Like();
                    //     $like->setUser($faker->randomElement($users))
                    //         ->setComment($comment)
                    //         ->setCreatedAt($faker->dateTimeBetween('-6 months'));

                    //     $manager->persist($like);
                    // }

                }

                
            }

        }
        $manager->flush();
    }
}
