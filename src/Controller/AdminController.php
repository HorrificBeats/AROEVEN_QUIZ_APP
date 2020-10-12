<?php

namespace App\Controller;

use App\Entity\UserAnswer;
use App\Entity\Module;
use App\Entity\Question;
use App\Entity\Quiz;
use App\Entity\UserModule;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    /**
     * @Route("/admin", name="admin_panel")
     */
    public function index()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        /* DENYING ACCESS */

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }



    /**
     * @Route("/admin/results", name="admin_results")
     */
    public function resultsALL()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        /* DENYING ACCESS */

        $userAnswer = $this->getDoctrine()
            ->getRepository(UserAnswer::class)
            ->findAll();

        /* $userModule = $this->getDoctrine()
            ->getRepository(UserAnswer::class)
            ->findAll(); */


        return $this->render('admin/read.html.twig', [
            'controller_name' => 'AdminController',
            'userAnswer' => $userAnswer
        ]);
    }

    /**
     * @Route("/admin/modules", name="admin_modules")
     */
    public function modulesALL() {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        /* DENYING ACCESS */

        $modules = $this->getDoctrine()
            ->getRepository(Module::class)
            ->findAll();


        return $this->render('admin/read.html.twig', [
            'controller_name' => 'AdminController',
            'modules' => $modules
        ]);
    }

    /**
     * @Route("/admin/quizzes", name="admin_quizzes")
     */
    public function quizzesALL() {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        /* DENYING ACCESS */

        $quizzes = $this->getDoctrine()
            ->getRepository(Quiz::class)
            ->findAll();

        $questions = $this->getDoctrine()
        ->getRepository(Question::class)
        ->findAll();

        /* $userModule = $this->getDoctrine()
            ->getRepository(UserAnswer::class)
            ->findAll(); */


        return $this->render('admin/read.html.twig', [
            'controller_name' => 'AdminController',
            'quizzes' => $quizzes,
            /* 'questions' => $questions */

        ]);
    }


    /* EDITING */
    /**
     * @Route("/admin/module/{id}", name="admin_module_edit")
     */
    public function moduleEDIT() {}

    /**
     * @Route("/admin/quiz/{id}", name="admin_quiz_edit")
     */
    public function quizEDIT() {}
    
    /* ADDING */
    /**
     * @Route("/admin/moduleAdd/{id}", name="admin_module_add")
     */
    public function moduleADD() {}

    /**
     * @Route("/admin/quizAdd/{id}", name="admin_quiz_add")
     */
    public function quizADD() {}
}