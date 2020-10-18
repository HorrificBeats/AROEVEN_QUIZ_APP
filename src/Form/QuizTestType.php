<?php

namespace App\Form;

use App\Entity\UserAnswer;
use App\Entity\User;
use App\Entity\Answer;
use App\Entity\Question;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
//use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class QuizTestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username'
            ])

            ->add('question', EntityType::class, [
                'class' => Question::class
            ])
            ->add('answer', EntityType::class, [
                'class' => Answer::class,
                'choice_label' => 'content',
                'expanded' => true,     //Radio-boxes
                'multiple' => false,    //1-btn only
            ])
            ->add('save', SubmitType::class, ['label' => 'FINISH'])
            /* ->getForm(); */

            

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
