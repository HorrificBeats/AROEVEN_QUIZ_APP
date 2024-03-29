<?php

namespace App\Controller;

use App\Entity\UserAnswer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/* Php Spreadsheet */
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\Routing\Annotation\Route;


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

    // Populates a tabel with the results data from UserAnswer
    private function getData()
    {
        $list = [];
        $userAnswers = $this->entityManager->getRepository(UserAnswer::class)->findAll();
        foreach ($userAnswers as $usr_answ) {
            $list[] = [
                $usr_answ->getUser()->getUsername(),
                $usr_answ->getQuestion()->getContent(),
                $usr_answ->getAnswer()->getContent(),
                $usr_answ->getAnswer()->getId()
            ];
        }
        return $list;
    }

    // Creates .xlsx file with results
    /**
     * @Route("/export",  name="export")
     */
    public function export()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        date_default_timezone_set('Europe/Berlin');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle('User List');
        $sheet->getCell('A1')->setValue('User');
        $sheet->getCell('B1')->setValue('Question');
        $sheet->getCell('C1')->setValue('Answer');
        $sheet->getCell('D1')->setValue('Answer_ID');

        // Increase row cursor after header write
        $sheet->fromArray($this->getData(), null, 'A2', true);

        $writer = new Xlsx($spreadsheet);

        // Create a Temporary file in the system
        $fileName = "Results " . date('d-m-Y h:i a') . ".xlsx";
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);

        // Return the excel file as an attachment
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }
}
