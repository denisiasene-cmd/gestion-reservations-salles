<?php

declare(strict_types=1);

namespace App\Validation;

use Respect\Validation\Validator as v;

class AuthValidator implements ValidatorInterface
{
    public function validate(array $data): ValidationResult
    {
        return $this->validateRegister($data);
    }

    public function validateRegister(array $data): ValidationResult
    {
        $errors = [];

        if (!v::stringType()->notEmpty()->length(2, 120)->validate($data['nom'] ?? null)) {
            $errors['nom'] = 'Le nom doit contenir entre 2 et 120 caractères.';
        }

        if (!v::stringType()->notEmpty()->length(2, 120)->validate($data['prenom'] ?? null)) {
            $errors['prenom'] = 'Le prénom doit contenir entre 2 et 120 caractères.';
        }

        if (!v::email()->validate($data['email'] ?? null)) {
            $errors['email'] = 'L’adresse email est invalide.';
        }

        if (!v::stringType()->notEmpty()->length(8, null)->validate($data['password'] ?? null)) {
            $errors['password'] = 'Le mot de passe doit contenir au moins 8 caractères.';
        }

        if (
            !v::stringType()->notEmpty()->validate($data['password_confirmation'] ?? null)
        ) {
            $errors['password_confirmation'] = 'La confirmation du mot de passe est obligatoire.';
        } elseif (
            ($data['password'] ?? '') !== ($data['password_confirmation'] ?? '')
        ) {
            $errors['password_confirmation'] = 'Les mots de passe ne correspondent pas.';
        }

        return new ValidationResult(
            empty($errors),
            $errors,
            $data
        );
    }

    public function validateLogin(array $data): ValidationResult
    {
        $errors = [];

        if (!v::email()->validate($data['email'] ?? null)) {
            $errors['email'] = 'L’adresse email est invalide.';
        }

        if (!v::stringType()->notEmpty()->validate($data['password'] ?? null)) {
            $errors['password'] = 'Le mot de passe est obligatoire.';
        }

        return new ValidationResult(
            empty($errors),
            $errors,
            $data
        );
    }
}
