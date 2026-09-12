<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\UserRepositoryInterface;
use App\Session\SessionManagerInterface;
use App\Model\User;

final class AuthentificationService implements AuthentificationServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private SessionManagerInterface $session
    ) {
    }

    public function inscrire(array $data): User
    {
        if ($this->userRepository->findByEmail($data['email']) !== null) {
            throw new \DomainException('Cette adresse email est déjà utilisée.');
        }

        return $this->userRepository->create([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role' => 'responsable',
        ]);
    }

    public function authentifier(string $email, string $password): ?User
    {
        $user = $this->userRepository->findByEmail($email);

        if ($user === null || !password_verify($password, $user->password)) {
            return null;
        }

        session_regenerate_id(true);

        $this->session->set('user_id', $user->id);
        $this->session->set('user_name', $user->prenom . ' ' . $user->nom);
        $this->session->set('user_role', $user->role);

        return $user;
    }

    public function deconnecter(): void
    {
        $this->session->remove('user_id');
        $this->session->remove('user_name');
        $this->session->remove('user_role');
    }
}