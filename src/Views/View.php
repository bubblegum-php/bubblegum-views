<?php

namespace Bubblegum\Views;

use Bubblegum\Request;
use Bubblegum\Routes\RoutedComponent;

class View extends RoutedComponent
{
    /**
     * @var string
     */
    protected string $destinationName;

    /**
     * @var string
     */
    protected static string $path = ROOT_PATH . 'app/Views/';

    /**
     * @param $destinationName
     * @return void
     */
    public function setDestinationName($destinationName)
    {
        $this->destinationName = $destinationName;
    }

    /**
     * @return string
     */
    public function getDestinationName(): string
    {
        return $this->destinationName;
    }

    /**
     * @param Request $request
     * @param array $data
     * @return string
     */
    function handle(Request $request, array $data = []): string
    {
        $path = self::$path.str_replace('.', DIRECTORY_SEPARATOR, $this->destinationName).'.php';
        return self::getContentFromFile($path, $request, $data);
    }

    /**
     * @param string $filePath
     * @param Request $request
     * @param array $data
     * @return string
     */
    protected static function getContentFromFile(string $filePath, Request $request, array $data): string
    {
        extract(['request' => $request->all(), 'data' => $data], EXTR_SKIP);
        ob_start();
        require $filePath;
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }
}