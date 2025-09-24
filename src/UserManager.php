<?php

require_once 'User.php';
require_once 'Validator.php';

class UserManager {
    private array $usuarios = [];
    private int $nextId = 1;

    private function addUser(string $nome, string $email, string $senha): void {
        $senhaHash = password_hash($senha, PASSWORD_BCRYPT);
        $usuario = new User($this->nextId++, $nome, $email, $senhaHash);
        $this->usuarios[] = $usuario;
    }

    public function registerUser(string $nome, string $email, string $senha): string {
        foreach ($this->usuarios as $usuario) {
            if ($usuario->getEmail() === $email) {
                return "Erro: E-mail já está em uso.";
            }
        }

        $emailCheck = Validator::validateEmail($email);
        if ($emailCheck !== true) {
            return "Erro: " . $emailCheck;
        }

        $senhaCheck = Validator::validatePassword($senha);
        if ($senhaCheck !== true) {
            return "Erro: " . $senhaCheck;
        }

        $this->addUser($nome, $email, $senha);
        return "Usuário cadastrado com sucesso.";
    }

    public function loginUser(string $email, string $senha): string {
        $emailCheck = Validator::validateEmail($email);
        if ($emailCheck !== true) {
            return "Erro: " . $emailCheck;
        }

        foreach ($this->usuarios as $usuario) {
            if ($usuario->getEmail() === $email && password_verify($senha, $usuario->getPassword())) {
                return "Login de " . $usuario->getName() . " realizado com sucesso.";
            }
        }
        return "Erro: Credenciais inválidas.";
    }

    public function resetPassword(int $id, string $novaSenha): string {
        foreach ($this->usuarios as $usuario) {
            if ($usuario->getId() === $id) {
                $senhaCheck = Validator::validatePassword($novaSenha);
                if ($senhaCheck !== true) {
                    return "Erro: " . $senhaCheck;
                }
                $senhaHash = password_hash($novaSenha, PASSWORD_BCRYPT);
                $usuario->setPassword($senhaHash);
                return "Senha do usuário " . $usuario->getName() . " alterada com sucesso.";
            }
        }
        return "Erro: Usuário não encontrado.";
    }

    public function listUsers(): array {
        $lista = [];
        foreach ($this->usuarios as $usuario) {
            $lista[] = [
                'id' => $usuario->getId(),
                'nome' => $usuario->getName(),
                'email' => $usuario->getEmail()
            ];
        }
        return $lista;
    }
}
