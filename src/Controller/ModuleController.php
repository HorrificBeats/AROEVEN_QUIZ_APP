<?php

namespace App\Controller;

use App\Entity\Module;
use App\Entity\Slide;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ModuleController extends AbstractController
{
    /**
     * @Route("/module", name="modules_page")
     */
    public function allModules()
    {
        $modules = $this->getDoctrine()
            ->getRepository(Module::class)
            ->findAll();

        return $this->render('module/index.html.twig', [
            'controller_name' => 'ModuleController',
            'modules' => $modules
        ]);
    }

    /**
     * @Route("/module/{id}", name="module")
     */
    public function oneModule()
    {
        $modules = $this->getDoctrine()
            ->getRepository(Module::class)
            ->findAll();

        /* $slides = $this->getDoctrine()
            ->getRepository(Slide::class)
            ->findAll(); */

        return $this->render('module/module.html.twig', [
            'controller_name' => 'ModuleController',
            'modules' => $modules,
/*             'slides' => $slides, */
        ]);
    }
}
