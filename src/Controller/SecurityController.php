<?php

namespace App\Controller;


use App\Entity\User;
use App\Entity\Books;
use App\Entity\Chapter;
use App\Form\SearchType;
use App\Form\RegistrationType;
use Symfony\Component\Form\FormView;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        //barre de recherche
        $searchForm = $this->createForm(SearchType::class, null);

        if($request->isMethod("POST")){
            $searchForm->handleRequest($request);

            if($searchForm->isSubmitted() && $searchForm->isValid()){
                return $this->redirectToRoute("search", [
                    'search' => $searchForm["search"]->getData()
                ]);
            }
        }

        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            // password
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(),
            'formSearch' => $searchForm->createView()
            ]);
    }

    /**
     * @Route("/connexion", name="security_login")
     */
    public function login(Request $request){

        //barre de recherche
        $searchForm = $this->createForm(SearchType::class, null);

        if($request->isMethod("POST")){
            $searchForm->handleRequest($request);

            if($searchForm->isSubmitted() && $searchForm->isValid()){
                return $this->redirectToRoute("search", [
                    'search' => $searchForm["search"]->getData()
                ]);
            }
        }

        return $this->render('security/login.html.twig', [
            'formSearch' => $searchForm->createView()
        ]);
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout() {}


    /**
     * @Route("/search/{search}", name="search")
     */
    public function search($search, Request $request, UserInterface $user = null)
    {
        $searchForm = $this->createForm(SearchType::class, null);

        if($request->isMethod("POST")){
            $searchForm->handleRequest($request);

            if($searchForm->isSubmitted() && $searchForm->isValid()){
                return $this->redirectToRoute("search", [
                    'search' => $searchForm["search"]->getData()
                ]);
            }
        }
        
        //pour les titres de livres
        $bookRepository = $this->getDoctrine()->getRepository(Books::class);
        $books = $bookRepository->findAll();
        $bookslength = count($books);
        $booksFound = [];

        for($i=0; $i < $bookslength ; $i++){
            $title = $books[$i]->getTitle();
            $result = stristr($title, $search);
            $publicOrNot = $books[$i]->getPublic();
            if($result == true && $publicOrNot == true){
                $booksFound[] = $books[$i];
            }

        }

        if($booksFound == null){
            $booksFound = '';   
        }

        //pour les titres de chapitre
        $chapterRepository = $this->getDoctrine()->getRepository(Chapter::class);
        $chapters = $chapterRepository->findAll();
        $chapterslength = count($chapters);
        $chaptersFound = [];

        for($i=0; $i < $chapterslength ; $i++){
            $title = $chapters[$i]->getTitle();
            $result = stristr($title, $search);
            $publicOrNot = $chapters[$i]->getPublic();
            if($result == true && $publicOrNot == true){
                $chaptersFound[] = $chapters[$i];
            }
        }

        if($chaptersFound == null){
            $chaptersFound = '';   
        }


        //pour les utilisateurs
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $users = $userRepository->findAll();
        $userslength = count($users);
        $usersFound = [];

        for($i=0; $i < $userslength ; $i++){
            $username = $users[$i]->getUsername();
            $result = stristr($username, $search);
            if($result == true){
                $usersFound[] = $users[$i];
            }
        }

        if($usersFound == null){
            $usersFound = '';   
        }


        return $this->render('security/results.html.twig', [
            'booksFound' => $booksFound,
            'chaptersFound' => $chaptersFound,
            'usersFound' => $usersFound,
            'formSearch' => $searchForm->createView(),
            'user' => $user
        ]);

    }
}
