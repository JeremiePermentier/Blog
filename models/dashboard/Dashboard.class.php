<?php 
/**
 * Class Dashboard
 */
class Dashboard {
        /**
     * @var $cols table column
     * @var $data table data
     * @var $actions possible actions
     */
    private $cols;
    private $data;
    private $actions;

    public function __construct($cols,$data,$actions)
    {
        $this->cols = $cols;
        $this->data = $data;
        $this->actions = $actions;
    }

    /**
     * @return array table column
     */
    public function getCols(){return $this->cols;}
    /**
     * @return array table data
     */
    public function getData(){return $this->data;}
    /**
     * @return array possible actions
     */
    public function getActions(){return $this->actions;}
}