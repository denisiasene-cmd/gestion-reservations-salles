<?php

declare(strict_types=1);

namespace App\View;

final class JsonView implements ViewInterface
{
    public function render(string $template, array $data = []): void
    {
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode(
            $data,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR
        );
    }
}