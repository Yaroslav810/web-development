<?php


/**
 * Class for drawing templates
 */

class Template
{
    private $page;
    private $args;

    public function __construct(string $tplPage = 'main', array $args = [])
    {
        $this->page = $tplPage;
        $this->args = $args;
    }

    /**
     * @param string $page
     */
    public function setPage(string $page): void
    {
        $this->page = $page;
    }

    /**
     * @param array $args
     */
    public function setArgs(array $args): void
    {
        $this->args = $args;
    }

    public function renderTemplate(): void
    {
        include __DIR__ . "/../templates/{$this->page}.tpl.php";
    }

}