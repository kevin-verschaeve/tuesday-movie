<?php

namespace AppBundle\Form;

use AppBundle\Entity\Movie;
use AppBundle\Entity\Session;
use AppBundle\Manager\SessionManager;
use AppBundle\Model\Vote;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoteType extends AbstractType
{
    private $sessionManager;

    public function __construct(SessionManager $sessionManager)
    {
        $this->sessionManager = $sessionManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $session = $this->sessionManager->findCurrentSession();
        $builder
            ->add('userName', TextType::class, [
                'attr' => [
                    'placeholder' => 'Votre nom',
                    'autofocus' => true,
                ],
            ])
            ->add('movies', EntityType::class, [
                'class' => Movie::class,
                'choices' => $session->getMovies(),
                'expanded' => true,
                'multiple' => true,
                'choice_label' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vote::class,
        ]);
    }
}
