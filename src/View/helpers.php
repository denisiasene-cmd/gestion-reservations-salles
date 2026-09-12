<?php
declare(strict_types=1);

function e_html(mixed $value): string
{
    if ($value instanceof \DateTimeInterface) {
        $value = $value->format('d/m/Y H:i');
    }

    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        'UTF-8'
    );
}


