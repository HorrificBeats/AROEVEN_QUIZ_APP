<?php

namespace App\Form;

/* Entities */
use AppBundle\Entity\Question;
use AppBundle\Entity\UserAnswer;

/* Form shiz */
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserAnswerType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var UserAnswer $userQuizAnswer */
        $UserAnswer = $builder->getData();

        /** @var Question $question */
        $question = $UserAnswer->getQuestion();

        $builder
            ->add('question')
            ->add(
                'answer',
                EntityType::class,
                [
                    'class' => 'AppBundle:Answer',
                    'query_builder' => function (EntityRepository $er) use (
                        $question
                    ) {
                        return $er->createQueryBuilder('a')
                            ->where('a.question = :question')
                            ->setParameter('question', $question);
                    },
                    'choice_label' => 'text',
                ]
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'AppBundle\Entity\UserQuizAnswer',
            ]
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_userquizanswer';
    }
}