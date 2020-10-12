<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Quiz;
use App\Entity\Question;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
            'id' =>$id,
        ]);
    }
}
