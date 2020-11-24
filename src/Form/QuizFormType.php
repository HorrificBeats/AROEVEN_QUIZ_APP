<?php
namespace App\Form;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\Quiz;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use App\Repository\QuizRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;



//use App\Entity\User;
//use App\Entity\UserAnswer;
//use App\Repository\UserAnswerRepository;
//use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
//use Symfony\Component\Form\Extension\Core\Type\EntityType;
//use Symfony\Component\Form\Extension\Core\Type\HiddenType;
//use Symfony\Component\Form\Extension\Core\Type\SubmitType;
//use Symfony\Component\Form\Extension\Core\Type\TextType;
//use Symfony\Component\HttpFoundation\Session\Session;
//use Symfony\Component\OptionsResolver\OptionsResolver;



class QuizFormType extends AbstractType
{
    //For the SF queryBuilder
    public function __construct(QuestionRepository $questionRepository, SessionInterface $session)
    {
        $this->questionRepository = $questionRepository;
        $this->sessionInterface = $session;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // For sending quiz_ID from twig template 
            ->add('quiz', EntityType::class, [
                'class' => Quiz::class,
                'query_builder' => function (QuizRepository $er) {
                    return $er->createQueryBuilder('quiz')
                        ->andWhere('quiz.id = :quiz_id')
                        ->setParameter('quiz_id', $this->sessionInterface->get('quiz_id'));
                        // ^ Prevents SQL Injections ^
                },
                //To hide stuff
                //'disabled' => true, IF ENABLED IT DOESNT SEND ANY DATA
                'attr' => ['style' => 'display:none']       //Hiden field w/ GET value
            ])
            
            // For sending the question_id to UserAnswer
            ->add('question', EntityType::class, [
                'class' => Question::class,
                'query_builder' => function (QuestionRepository $er) {
                    return $er->createQueryBuilder('question') //CORRECT
                        ->andWhere('question.id = :question_id')
                        ->setParameter('question_id', $this->sessionInterface->get('question_id'));
                },
                'attr' => ['style' => 'display:none']       //Hiden field w/ GET value
            ])

            //For chosing the Answer, attached to a Question, attached respectively to a Quiz
            ->add('answer', EntityType::class, [
                'class' => Answer::class,
                'choice_label' => function (Answer $answer) {
                    // Formating each answer string to show Question, Answer ID + the Answer content
                    //return sprintf('Q#%d:(%d) %s', $answer->getQuestion()->getId(), $answer->getId(), $answer->getContent());
                    return sprintf('%s', $answer->getContent());
                },  
                'expanded' => true,     //Radio-boxes
                'multiple' => false,    //1-btn only
                
                //Custom SQL Query to only show the right answers
                'query_builder' => function (AnswerRepository $er) {
                    return $er->createQueryBuilder('answ')
                        ->andWhere('answ.question = :question_id')
                        ->setParameter('question_id', $this->sessionInterface->get('question_id'));
                },
                'attr' => array('id' => 'title-field')
            ])
        ;
    }
}
