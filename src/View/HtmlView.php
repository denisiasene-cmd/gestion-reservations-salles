<?php

declare(strict_types=1);

namespace App\View;

require_once __DIR__ . '/helpers.php';

class HtmlView implements ViewInterface
{
    public function __construct(
        private string $templatesPath
    ) {
    }

    public function render(string $template, array $data = []): void
    {
        $templatePath = $this->templatesPath . '/' . $template . '.php';

        if (!file_exists($templatePath)) {
            throw new \RuntimeException("Template introuvable : {$templatePath}");
        }

        extract($data);

        ob_start();
        require $templatePath;
        $content = ob_get_clean();

        require $this->templatesPath . '/layout/app.php';
    }
}