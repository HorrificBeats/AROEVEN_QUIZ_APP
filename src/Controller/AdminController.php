<?php

namespace App\Controller;

/* Accesing Entities */

use App\Entity\UserAnswer;
use App\Entity\Module;
use App\Entity\Quiz;
use App\Entity\Answer;
use App\Entity\Slide;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\ContainerBuilder;

//PHP OFFICE Resources
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

//Sonata Exporter
use Exporter\Handler;
use Exporter\Source\PDOStatementSourceIterator;
use Exporter\Writer\CsvWriter;
use Sonata\Exporter\Writer\XlsWriter;



class AdminController extends AbstractController
{

    /**
     * @Route("/admin", name="admin_panel")
     */
    public function index()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        /* DENYING ACCESS */

        /* ALL MODULES */

        $modules = $this->getDoctrine()
            ->getRepository(Module::class)
            ->findAll();

        $quizzes = $this->getDoctrine()
            ->getRepository(Quiz::class)
            ->findAll();

        $message = '';
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'modules' => $modules,
            'quizzes' => $quizzes,
        ]);
    }


    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /*  public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }
 */


    /*  private function getData()
    {
        /**
         * @var $user_answer UserAnswer[]
         */
    //$list = [];
    //$user_answer = $this->entityManager
    //->getRepository(UserAnswer::class)
    //->findAll();

    /* foreach ($user_answer as $usr_answ) {
            $list[] = [
                $usr_answ->getId(),
                $usr_answ->getQuizType(),
                $usr_answ->getUser(),
                $usr_answ->getAnswer()
            ];
        } */
    /* return $list; */
    /* }  */

    /**
     * @Route("/admin/export", name="admin_panel_export")
     */
    /* public function export()
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle('UserANSWER List');

        $sheet->getCell('A1')->setValue('ID');
        $sheet->getCell('B1')->setValue('Quiz Type');
        $sheet->getCell('C1')->setValue('User');
        $sheet->getCell('D1')->setValue('Answer');

        // Increase row cursor after header write
        $sheet->fromArray($this->getData(), null, 'A2', true);

        $writer = new Xlsx($spreadsheet);

        $writer->save('helloworld.xlsx');

        return $this->redirectToRoute('admin_panel');
    } */









    // ==================================== READ ============================================
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
    public function modulesALL()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        /* DENYING ACCESS */

        /* ACCESEZ TOT PRIN SLIDES rather */
        $slides = $this->getDoctrine()
            ->getRepository(Slide::class)
            ->findAll();


        return $this->render('admin/read.html.twig', [
            'controller_name' => 'AdminController',
            'slides' => $slides
        ]);
    }

    /**
     * @Route("/admin/quizzes", name="admin_quizzes")
     */
    public function quizzesALL()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        /* DENYING ACCESS */

        $answers = $this->getDoctrine()
            ->getRepository(Answer::class)
            ->findAll();

        return $this->render('admin/read.html.twig', [
            'controller_name' => 'AdminController',
            'answers' => $answers,
            /* 'questions' => $questions */

        ]);
    }



    // ================================= UPDATE / EDIT =====================================
    // H: Permite sa editezi (intr-un singur Formular) TOT ce tine de un MODUL / QUIZ

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

    /* ??? */
    /**
     * @Route("/admin/moduleDelete/{id}", name="admin_module_delete")
     */
    public function deleteOneAnswer()
    {
    }
}
