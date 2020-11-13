<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\UserAnswer;
use App\Form\QuizFormType;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/* SESSION STUFF */
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class QuizController extends AbstractController
{ 
    /**
     * Quiz POST
     * @Route("quizPOST_{quiz_id}/{question_id}", name="quizPOST_")
     */
    public function quizPOST_(EntityManagerInterface $em, Request $request, SessionInterface $session, QuestionRepository $questionRepo, $quiz_id, $question_id)
    {
        //$q_number = 1;

        //Showing the specific question outside the form
        $questions = $this->getDoctrine()
            ->getRepository(Question::class)
            ->findOneBy(['quiz' => $quiz_id, 'id' => $question_id]);

        //Putting QuizID & QuestionID in the SESSION
        $session->set('quiz_id', $quiz_id);
        $session->set('question_id', $question_id);
        //dump($session);

        //Creating form
        $form = $this->createForm(QuizFormType::class);
        
        //Form submission
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $data['quiztype'] = 'ASS';
            //dump($data);  //all good?

            $userAnswer = new UserAnswer();

            $userAnswer->setUser($this->getUser());          // Extras automat prin $userAnswer->setUser($this->getUser());
            $userAnswer->setQuiz($data['quiz']);             // specificate cu GET gen, "quizz_{id}/question_{nbr}"
            $userAnswer->setQuestion($data['question']);
            $userAnswer->setAnswer($data['answer']);
            $userAnswer->setQuizType($data['quiztype']);

            //dd($userAnswer);
            $em->persist($userAnswer);
            $em->flush();

            // Manual redirection to CONGRATS Page
            if ($question_id < 5) {
                $question_id = $question_id + 1;
                //dump($question_id);
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
     * @Route(" ", name="CONGRATULATIONS-POST")
     */
    public function congratsPagePOST()
    {
        return $this->render('quiz/congrats.html.twig', []);
    }
}
