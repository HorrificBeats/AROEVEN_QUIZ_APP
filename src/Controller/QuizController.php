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

class QuizController extends AbstractController
{
    /**
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

    /**
     * @Route("quizTest/", name="quizTest")
     */
    public function quizTest(EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(QuizFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            //dd($data);  //all good?

            $userAnswer = new UserAnswer();

            $userAnswer->setUser($data['username']);
            $userAnswer->setQuiz($data['quiz']);
            $userAnswer->setQuestion($data['question']);
            $userAnswer->setAnswer($data['answer']);

            $em->persist($userAnswer);
            $em->flush();
        }

        return $this->render('quiz/form.html.twig', [
            'quizForm' => $form->createView(),
        ]);
    }

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
    /* public function play($id, Quiz $quiz, Request $request, $nbr, QuestionRepository $questionRepo)
    {

        // IMPORTANT / FUNCTIONAL 
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
    } */
}
