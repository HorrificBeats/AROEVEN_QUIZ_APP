<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Slide;
use App\Entity\UserAnswer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class AdminController extends AbstractController
{
// ==================================== READ ============================================
    /**
     * @Route("/admin/results", name="admin_results")
     */
    public function resultsALL()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');       // DENYING ACCESS 
        
        $userAnswer = $this->getDoctrine()
            ->getRepository(UserAnswer::class)
            ->findAll();
        dump($userAnswer);

        return $this->render('admin/read.html.twig', [
            'controller_name' => 'AdminController',
            'userAnswer' => $userAnswer
        ]);
    }

    /**
     * @Route("/admin/modules", name="admin_modules")
     */
    public function modulesALL()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');       // DENYING ACCESS 

        //J'accède tout avec l'entité SLIDE, pour utiliser ses FK
        $slides = $this->getDoctrine()
            ->getRepository(Slide::class)
            ->findAll();

        return $this->render('admin/read.html.twig', [
            'controller_name' => 'AdminController',
            'slides' => $slides                             //Passing object in a Twig variable
        ]);
    }

    /**
     * @Route("/admin/quizzes", name="admin_quizzes")
     */
    public function quizzesALL()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');       // DENYING ACCESS 

        $answers = $this->getDoctrine()
            ->getRepository(Answer::class)
            ->findAll();

        return $this->render('admin/read.html.twig', [
            'controller_name' => 'AdminController',
            'answers' => $answers,
        ]);
    }


    //TODOs
        // ================================= UPDATE / EDIT =====================================
            // H: Permet d'éditer MODULE+Slides et QUIZ+Questions+Answers 

            /**
             * @Route("/admin/module/{id}", name="admin_module_edit")
             */
            public function moduleEDIT()
            {
            }

            /**
             * @Route("/admin/quiz/{id}", name="admin_quiz_edit")
             */
            public function quizEDIT()
            {
            }


        // ==================================== ADD ============================================
            // H: Formular care permite sa adaugi: Modular+Slides & Quiz + Question + Answer (hard af)
            /**
             * @Route("/admin/moduleAdd/{id}", name="admin_module_add")
             */
            public function moduleADD()
            {
            }

            /**
             * @Route("/admin/quizAdd/{id}", name="admin_quiz_add")
             */
            public function quizADD()
            {
            }


        // ==================================== DELETE ============================================

            // Delete WHOLE Module AND its SLIDES
            /**
             * @Route("/admin/moduleDelete/{id}", name="admin_module_delete")
             */
            public function deleteOneModule()
            {
            }

            // Delete WHOLE Quiz AND its Questions 
            /**
             * @Route("/admin/moduleDelete/{id}", name="admin_module_delete")
             */
            public function deleteOneQuiz()
            {
            }



            // DELETE Singles 
            /**
             * @Route("/admin/moduleDelete/{id}", name="admin_module_delete")
             */
            public function deleteOneSlide()
            {
            }

            /**
             * @Route("/admin/moduleDelete/{id}", name="admin_module_delete")
             */
            public function deleteOneQuestion()
            {
            }

            /**
             * @Route("/admin/moduleDelete/{id}", name="admin_module_delete")
             */
            public function deleteOneAnswer()
            {
            }
        
}
