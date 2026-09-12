<?php

declare(strict_types=1);

namespace App\Session;

interface SessionManagerInterface
{
    public function set(string $key, mixed $value): void;

    public function get(string $key): mixed;

    public function remove(string $key): void;
}