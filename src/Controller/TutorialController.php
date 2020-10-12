<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TutorialController extends AbstractController
{
    /**
     * @Route("/tutorial", name="tutorial")
     */
    public function index()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        /* DENYING ACCESS */
        
        return $this->render('tutorial/index.html.twig', [
            'controller_name' => 'TutorialController',
        ]);
    }
}
