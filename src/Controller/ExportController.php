<?php

namespace App\Controller;

use App\Entity\UserAnswer;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/* Php Spreadsheet */
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\ResponseHeaderBag;


class ExportController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }


    private function getData()
    {
        
        $list = [];
        $userAnswers = $this->entityManager->getRepository(UserAnswer::class)->findAll();

        foreach ($userAnswers as $usr_answ) {
            $list[] = [
                $usr_answ->getUser()->getUsername(),
                $usr_answ->getQuizType(),
                $usr_answ->getQuestion()->getContent(),
                $usr_answ->getAnswer()->getContent(),
                $usr_answ->getAnswer()->getId()
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
        $sheet->getCell('E1')->setValue('Answer_ID');


        // Increase row cursor after header write
        $sheet->fromArray($this->getData(), null, 'A2', true);


        $writer = new Xlsx($spreadsheet);

        // Create a Temporary file in the system
        $fileName = "Results". date('d-m-Y_h.i a') . ".xlsx";
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

        // Create the excel file in the tmp directory of the system
        $writer->save($temp_file);

        // Return the excel file as an attachment
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }
}