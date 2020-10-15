<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Quiz;
use App\Entity\Question;
use App\Entity\UserAnswer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/* Form stuff */
use Symfony\Component\HttpFoundation\Request;
use App\Form\QuizType;


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
     * @Route("/test", name="quiz")
     */
    public function new(Request $request)
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

    
}
