<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserAnswer;
use App\Entity\Module;
use App\Entity\Quiz;
use App\Entity\Answer;
use App\Entity\Slide;

use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    private function getData()
    {
        /**
         * @var $user User[]
         */
        $list = [];
        $userAnswers = $this->entityManager->getRepository(UserAnswer::class)->findAll();

        foreach ($userAnswers as $usr_answ) {
            $list[] = [
                $usr_answ->getUser()->getUsername(),
                $usr_answ->getQuizType(),
                $usr_answ->getAnswer()->getContent(),
                $usr_answ->getQuestion()->getContent(),
                $usr_answ->getQuestion()->getId()
            ];
        }
        return $list;
    }

    /**
     * @Route("/export",  name="export")
     */
    public function export()
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle('User List');

        $sheet->getCell('A1')->setValue('User');
        $sheet->getCell('B1')->setValue('Quiz_type');
        $sheet->getCell('C1')->setValue('Question');
        $sheet->getCell('D1')->setValue('Answer');
        $sheet->getCell('D1')->setValue('Answer ID');


        // Increase row cursor after header write
        $sheet->fromArray($this->getData(), null, 'A2', true);


        $writer = new Xlsx($spreadsheet);

        $writer->save('helloworld.xlsx');

        return $this->redirectToRoute('admin_panel');
    }

    /**
     * @Route("/export",  name="export_csv")
     */
    public function export_csv()
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle('User List');

        $sheet->getCell('A1')->setValue('User');
        $sheet->getCell('B1')->setValue('Quiz_type');
        $sheet->getCell('C1')->setValue('Question');
        $sheet->getCell('D1')->setValue('Answer');
        $sheet->getCell('D1')->setValue('Answer ID');


        // Increase row cursor after header write
        $sheet->fromArray($this->getData(), null, 'A2', true);


        //NEW INSTANCE
        $writer = new Csv($spreadsheet);

        //CONFIG
        $writer->setDelimiter(';');
        $writer->setEnclosure('"');
        $writer->setLineEnding("\r\n");
        $writer->setSheetIndex(0);

        // SAVE
        $writer->save("whyyyyy.csv");

        return $this->redirectToRoute('admin_panel');
    }
}
