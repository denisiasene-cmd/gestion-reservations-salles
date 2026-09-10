<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Validation\SalleValidator;
use PHPUnit\Framework\TestCase;

class SalleValidatorTest extends TestCase
{
    public function testCapaciteNegative(): void
    {
        $validator = new SalleValidator();

        $data = [
            'nom' => 'Salle test',
            'batiment' => 'B',
            'capacite' => -5,
            'type' => 'cours',
            'active' => true,
        ];

        $result = $validator->validate($data);

        $this->assertFalse($result->isValid());
        $this->assertArrayHasKey('capacite', $result->errors());
    }

    public function testTypeInconnu(): void
    {
        $validator = new SalleValidator();

        $data = [
            'nom' => 'Salle test',
            'batiment' => 'B',
            'capacite' => 30,
            'type' => 'bureau',
            'active' => true,
        ];

        $result = $validator->validate($data);

        $this->assertFalse($result->isValid());
        $this->assertArrayHasKey('type', $result->errors());
    }
}
