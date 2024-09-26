<?php
if (!function_exists('view')) {
    function view(string $viewName, array $data = []): string
    {
        return (new \Bubblegum\Views\View($viewName))->content(new \Bubblegum\Request(), $data);
    }
}