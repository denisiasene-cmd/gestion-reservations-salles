<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Validation\ReservationValidator;
use PHPUnit\Framework\TestCase;

class ReservationValidatorTest extends TestCase
{
    public function testEmailInvalide(): void
    {
        $validator = new ReservationValidator();

        $data = [
            'salle_id' => 1,
            'responsable' => 'Denise',
            'email' => 'email-invalide',
            'motif' => 'Réunion test',
            'date_debut' => '2026-09-15 10:00:00',
            'date_fin' => '2026-09-15 12:00:00',
        ];

        $result = $validator->validate($data);

        $this->assertFalse($result->isValid());
        $this->assertArrayHasKey('email', $result->errors());
    }

    public function testResponsableVide(): void
    {
        $validator = new ReservationValidator();

        $data = [
            'salle_id' => 1,
            'responsable' => '',
            'email' => 'denise@test.com',
            'motif' => 'Réunion test',
            'date_debut' => '2026-09-15 10:00:00',
            'date_fin' => '2026-09-15 12:00:00',
        ];

        $result = $validator->validate($data);

        $this->assertFalse($result->isValid());
        $this->assertArrayHasKey('responsable', $result->errors());
    }

    public function testDateInvalide(): void
    {
        $validator = new ReservationValidator();

        $data = [
            'salle_id' => 1,
            'responsable' => 'Denise',
            'email' => 'denise@test.com',
            'motif' => 'Réunion test',
            'date_debut' => 'date-invalide',
            'date_fin' => '2026-09-15 12:00:00',
        ];

        $result = $validator->validate($data);

        $this->assertFalse($result->isValid());
        $this->assertArrayHasKey('date_debut', $result->errors());
    }
}
