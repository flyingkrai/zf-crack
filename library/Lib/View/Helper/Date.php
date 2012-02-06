<?php

/**
 * Description of Date
 *
 * @author davi
 */
class Lib_View_Helper_Date extends Zend_View_Helper_Abstract
{

    protected $_monthsBr = array(
        1 => 'Janeiro',
        2 => 'Fevereiro',
        3 => 'Março',
        4 => 'Abril',
        5 => 'Maio',
        6 => 'Junho',
        7 => 'Julho',
        8 => 'Agosto',
        9 => 'Setembro',
        10 => 'Outuro',
        11 => 'Novembro',
        12 => 'Dezembro',
    );

    /**
     * @param DateTine|string $date
     * @return string
     */
    public function dateToBr($date)
    {
        if (!$date) {
            return null;
        }

        if ($date instanceof DateTime) {
            @$date = $date->format('d-m-Y H:i');
        } else {
            $zDate = new Zend_Date($date);
            $date = $zDate->toString('dd-MM-yyyy H:m');
        }

        return $date;
    }

    /**
     * @param DateTime $date
     * @return string 
     */
    public function timelineDate($date)
    {
        if (!$date) {
            return null;
        }

        if(!$date instanceof DateTime){
            $date = new DateTime($date);
        }

        $month = $date->format('n');
        $day = $date->format('d');

        return "{$day} de {$this->_monthsBr[$month]}";
    }

}
