<?php

namespace EsnTest;

use EsnTest\Controller\EsnFetcher;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

/**
 * Class for the exercise.
 */
class TestController extends EsnFetcher
{

    /**
     * Returns the needed data for solving task 4.
     *
     * You might need extra functions for this test.
     *
     * @return
     *   The data you decide to return.
     */
    public function getDataT4()
    {
        $sections = json_decode($this->getRequest('sections'), TRUE);

        foreach ($sections as $section)
        {
            $result[$section['country']][] = $section;
        }

        return $result;
    }

    /**
     * Returns the needed data for solving task 5.
     *
     * You might need extra functions for this test.
     *
     * @return
     *   The data you decide to return.
     */
    public function getDataT5()
    {
        //$excel =  IOFactory::load('codes.xlsx');
        $results = [];
        $reader = new Xlsx(); //   PhpOffice\PhpSpreadsheet\Reader\Xlsx
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load('codes.xlsx');
        $sheet = $spreadsheet->getActiveSheet();
        $cards = array();

        foreach ($sheet->getRowIterator() as $index => $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(TRUE);

            foreach ($cellIterator as $cell) {

                if ($cell->getValue() != 'Code')
                    $codes[] = $cell->getValue();
            }
        }


        foreach ($codes as $code) {

            $fetch = $this->getCardData($code);

            if (!empty($fetch) && isset($fetch))
                array_push($cards, $fetch);
        }

        return $cards;
    }

}
