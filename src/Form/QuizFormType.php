<?php

namespace App\Form;

use App\Entity\UserAnswer;
use App\Entity\User;
use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\Quiz;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use App\Repository\QuizRepository;
use App\Repository\UserAnswerRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
//use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Session;


class QuizFormType extends AbstractType
{
    //For the SF queryBuilder
    private $questionRepository;
    public function __construct(QuestionRepository $questionRepository, SessionInterface $session)
    {
        $this->questionRepository = $questionRepository;
        $this->sessionInterface = $session;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$quiz_id = $session->get('quiz_id');

        $builder
            ->add('quiz', EntityType::class, [
                'class' => Quiz::class,
                'query_builder' => function (QuizRepository $er) {
                    return $er->createQueryBuilder('quiz')
                        ->andWhere('quiz.id = :quiz_id')
                        ->setParameter('quiz_id', $this->sessionInterface->get('quiz_id'));
                    },
                    //To hide stuff
                    //'disabled' => true, IF ENABLED IT DOESNT SEND ANY DATA
                'attr' => ['style' => 'display:none'] //Hiden field w/ GET value
            ])

            ->add('question', EntityType::class, [
                'class' => Question::class,
                'query_builder' => function (QuestionRepository $er) {
                    return $er->createQueryBuilder('question') //CORRECT
                        ->andWhere('question.id = :question_id')
                        ->setParameter('question_id', $this->sessionInterface->get('question_id'))
                        //->orWhere("d = 2")
                        ;
                },
                'attr' => ['style' => 'display:none'] //Hiden field w/ GET value
            ])

            ->add('answer', EntityType::class, [
                'class' => Answer::class,
                'choice_label' => function (Answer $answer) {
                    return sprintf('Q#%d:(%d) %s', $answer->getQuestion()->getId(), $answer->getId(), $answer->getContent());
                },
                'expanded' => true,     //Radio-boxes
                'multiple' => false,    //1-btn only
                'query_builder' => function (AnswerRepository $er) {
                    return $er->createQueryBuilder('answ')
                        ->andWhere('answ.question = :question_id')
                        ->setParameter('question_id', $this->sessionInterface->get('question_id'));
                        //->setParameter('question_id', 1);
                },
                'attr' => array('id'=>'title-field')
            ])

            /* ->add('quiztype', TextType::class, [
                //'class' => UserAnswer::class,
                'data' => 'pre',
                'attr' => ['style' => 'display:none'] //Hiden field w/ GET value
            ]) */
            ->add('save', SubmitType::class, ['label' => 'NEXT QUESTION'])
            // ->getForm();
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            //'quiz_id' => null
        ]);
    }
}
