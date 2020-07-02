<?php

namespace App\DataFixtures;

use App\Entity\Like;
use App\Entity\User;
use App\Entity\Books;
use App\Entity\Chapter;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = \Faker\Factory::create('fr_FR');
        $users = [];

        //Créer des users
        for($j = 0; $j < 6; $j++){
            
            $user = new User();
            $user->setEmail($faker->email)
                    ->setUsername($faker->name)
                    ->setPassword('password');
            
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

            //Créer des likes dans les books
            for($j = 0; $j < mt_rand(0, 5); $j++){
                $like = new Like();
                $like->setUser($faker->randomElement($users))
                    ->setBook($book)
                    ->setCreatedAt($faker->dateTimeBetween('-6 months'));

                $manager->persist($like);
            }

            // Créer 4 chapters
            for($j = 1; $j <= mt_rand(3, 8); $j++)
            {
                $status = rand(0,1);
                $status2 = rand(0,1);

                $chapter = new Chapter();
                $chapter->setTitle($faker->sentence())
                        ->setContent($faker->paragraph(4))
                        ->setPublishedDate($faker->dateTimeBetween('-6 months'))
                        ->setBooks($book)
                        ->setPublic($status)
                        ->setCompleted($status2);

                $manager->persist($chapter);

                //Créer des likes dans les chap
                for($j = 0; $j < mt_rand(0, 5); $j++){
                    $like = new Like();
                    $like->setUser($faker->randomElement($users))
                        ->setChapter($chapter)
                        ->setCreatedAt($faker->dateTimeBetween('-6 months'));

                    $manager->persist($like);
                }


                //Créer 4 comments
                for($k = 1; $k <= mt_rand(3, 6); $k++)
                {
                    $content = '<p>'. join($faker->paragraphs(2));

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
                    for($j = 0; $j < mt_rand(0, 4); $j++){
                        $like = new Like();
                        $like->setUser($faker->randomElement($users))
                            ->setComment($comment)
                            ->setCreatedAt($faker->dateTimeBetween('-6 months'));

                        $manager->persist($like);
                    }

                }

                
            }

        }

        // for($i=0; $i < 5; $i++){
        //     $user = new User();
        //     $user->setEmail($faker->email)
        //         ->setPassword($this->encoder->encodePassword($user, 'password'));

        //     $manager->persist($user);

        //     $users[] = $user;
        // }

        $manager->flush();
    }
}
