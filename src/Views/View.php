<?php

namespace Bubblegum\Views;

use Bubblegum\Request;
use Bubblegum\Routes\RoutedComponent;

class View extends RoutedComponent
{
    protected string $destinationName;
    protected static string $path = ROOT_PATH . 'app/Views/';

    public function setDestinationName($destinationName)
    {
        $this->destinationName = $destinationName;
    }

    public function getDestinationName(): string
    {
        return $this->destinationName;
    }

    function handle(Request $request, array $data = []): string
    {
        $path = self::$path.str_replace('.', DIRECTORY_SEPARATOR, $this->destinationName).'.php';
        return self::getContentFromFile($path, $request, $data);
    }

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