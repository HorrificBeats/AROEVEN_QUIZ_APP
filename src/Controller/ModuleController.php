<?php

namespace App\Controller;

use App\Entity\Module;
use App\Entity\Slide;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ModuleController extends AbstractController
{
    //Shows all modules
    /**
     * @Route("/module", name="modules_page")
     */
    public function allModules()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');        //DENYING ACCESS

        $modules = $this->getDoctrine()
            ->getRepository(Module::class)
            ->findAll();

        return $this->render('module/index.html.twig', [
            'controller_name' => 'ModuleController',
            'modules' => $modules
        ]);
    }

    // Shows one module
    /**
     * @Route("/module/{id}", name="module")
     */
    public function oneModule($id)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        
        $module = $this->getDoctrine()
            ->getRepository(Module::class)
            ->findAll($id);

        $slides = $this->getDoctrine()
            ->getRepository(Slide::class)
            ->findBy([
            "id_module" => $id    
            ]);

        //dump($module, $id, $slides);

        return $this->render('module/module.html.twig', array(
            'controller_name' => 'ModuleController',
            'module' => $module,
            'slides' => $slides,
            'id' =>$id
        ));
    }
}
