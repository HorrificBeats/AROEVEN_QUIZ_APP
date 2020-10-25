<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Quiz;
use App\Entity\Question;
use App\Entity\UserAnswer;
use App\Form\QuizFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/* For Grafikart */
use App\Repository\QuestionRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/* Form stuff */
use Symfony\Component\HttpFoundation\Request;
use App\Form\QuizType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/* Embedded Form Stuff */
use App\Entity\User;
use App\Repository\AnswerRepository;
use App\Repository\UserAnswerRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
//use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/* SESSION STUFF */
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class QuizController extends AbstractController
{
    /**
     * STATIC FORM w/o submission | ToBeDelete
     * @Route("/quiz/{id}", name="quiz")
     */
    public function quiz($id)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        /* DENYING ACCESS */

        $questions = $this->getDoctrine()
            ->getRepository(Question::class)
            ->findBy(['quiz' => $id]);

        $answers = $this->getDoctrine()
            ->getRepository(Answer::class)
            ->findBy([
                "question" => $id
            ]);

        return $this->render('quiz/index.html.twig', [
            'controller_name' => 'QuizController',
            'questions' => $questions,
            'answers' => $answers,
            'id' => $id,
        ]);
    }

    
    //TODO
    /**
     * Quiz POST
     * @Route("quizPOST_{quiz_id}/{question_id}", name="quizPOST_")
     */
    public function quizPOST_(EntityManagerInterface $em, Request $request, SessionInterface $session, QuestionRepository $questionRepo, $quiz_id, $question_id)
    {
        $q_number = 1;

        //Showing QUESTIONS withOUT the form
        $questions = $this->getDoctrine()
            ->getRepository(Question::class)
            ->findOneBy(['quiz' => $quiz_id, 'id' => $question_id]);

        //Putting QuizID & QuestionID in the SESSION
        $session->set('quiz_id', $quiz_id);
        $session->set('question_id', $question_id);
        //dump($session);

        //$foo = $session->get('quiz_id');
        //dump($foo);
        //$foo2 = $session->get('question_id');
        //dump($foo2); 


        $form = $this->createForm(QuizFormType::class);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $data['quiztype'] = 'ASS';
            dump($data);  //all good?

            $userAnswer = new UserAnswer();

            $userAnswer->setUser($this->getUser());          // generat automat prin $userAnswer->setUser($this->getUser());
            $userAnswer->setQuiz($data['quiz']);             // specificate cu GET gen, "quizz_{id}/question_{nbr}"
            $userAnswer->setQuestion($data['question']);
            $userAnswer->setAnswer($data['answer']);
            //$userAnswer->setQuizType('PRE');
            $userAnswer->setQuizType($data['quiztype']);

            //dd($userAnswer);


            $em->persist($userAnswer);
            $em->flush();

            //$question_id++;

            if ($question_id < 5) {
                $question_id = $question_id + 1;
                return $this->redirectToRoute('quizPOST_', [
                    'form' => $form->createView(),
                    'questions' => $questions,
                    'quiz_id' => $quiz_id,
                    'question_id' => $question_id

                ]);
            } else {
                return $this->redirectToRoute('CONGRATULATIONS-POST', [
                    'id' => 1
                ]);
            }
        }

        return $this->render('quiz/form.html.twig', [
            'quizForm' => $form->createView(),
            'questions' => $questions,
            'quiz_id' => $quiz_id,
            'question_id' => $question_id
        ]);
    }



    /**
     * @Route(" ", name="CONGRATULATIONS-PRE")
     */
    public function congratsPagePRE()
    {
        return $this->render('quiz/congrats.html.twig', []);
    }

    /**
     * @Route(" ", name="CONGRATULATIONS-POST")
     */
    public function congratsPagePOST()
    {
        return $this->render('quiz/congrats.html.twig', []);
    }





    
    // ================================ TRIALS ========================================
    /**
     * @Route("/test", name="quiz")
     */
    /* public function new(Request $request)
    {
        //$usr_answer = new UserAnswer();

        $questions = $this->getDoctrine()
            ->getRepository(Question::class)
            ->findAll();

        

        $form = $this->createForm(QuizType::class, $questions);

        return $this->render('quiz/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
 */


    /**
     * TODO replacer id par slug
     * a voir pour bloqué l
     * @Route("quizz_{id}/question_{nbr}", name="quizz_play")
     *
     */
    public function play($id, Quiz $quiz, Request $request, $nbr, QuestionRepository $questionRepo)
    {

        // AFFICHAGE QUESTION SANS FORMULAIRE
        $question = $questionRepo->findOneBy(['quiz' => $id, 'q_number' => $nbr]);

        $user = $this->getUser();

        $responses = [
            $question->getContent() => 'reponse 1',
            $question->getContent() => 'reponse 2',
            $question->getContent() => 'reponse 3',
            $question->getContent() => 'reponse 4',
            $question->getContent() => 'reponse 5'
        ];

        //dump($responses);
        //shuffle($responses);
        //dump($responses);

        $form = $this->createFormBuilder()
            ->add('response', ChoiceType::class, [
                'label' => $question->getContent(),
                // 'choices' => $responses, 
                'expanded' => true,
                'multiple' => false,

            ])
            ->getForm();


        // COD CA SA AVANSEZI LA URMATOAREA SOLUTIE
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $nbr++;

            if ($nbr <= 10) {
                return $this->redirectToRoute('quizz_play', [
                    'form' => $form->createView(),
                    'question' => $question,
                    'q_number' => $nbr,
                    'id' => $id,
                ]);
            }
            dump($data);
        }

        return $this->render('quiz/play.html.twig', [
            'form' => $form->createView(),
            'question' => $question,


        ]);
    }
}
