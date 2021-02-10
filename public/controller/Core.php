<?php

class Core
{
    protected $db;
    protected $fl = true;
    protected $m;
    public $nameOption;
    public $amountRecordingInDB;
    public $nameId;
    public $nameTitle;
    public $nameAdditionEN;
    public $nameAdditionRU;
    public $page;
    public $nameEdit;
    public $amountNewMessages = '';

    public function __construct()
    {
        $this->m = new Model();
    }

    protected function getHeader()
    {
        $this->m->getHeader();
    }

    protected function getMenu()
    {
        return $this->m->getMenu();
    }

    protected function getMenuCategories()
    {
        return $this->m->getMenuCategories();
    }

    protected function getSidebar()
    {
        return $this->m->getSidebar();
    }

    protected function getContent()
    {
        $this->nameOption = $this->m->setNameOption($this->nameOption);
        return $this->m->getContent($this->nameOption);
    }

    public function getBody()
    {
        $this->getHeader();
        $resultMenu = $this->getMenu();
        $resultMenuCategories = $this->getMenuCategories();
        $resultSidebar = $this->getSidebar();
        $result = $this->getContent();
        if(preg_match("#(.+admin|(add|edit).+)#i", $_GET['option']) && $this->nameOption !== 'authorization')
            require_once "view/ViewAdmin.php";
        else
            require_once "view/View.php";
    }
}