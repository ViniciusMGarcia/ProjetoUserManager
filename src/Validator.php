<?php

class Validator {
    public static function validateEmail(string $email): string|bool {
        if (empty($email)) {
            return "Email é obrigatório";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Email inválido";
        }

        if (strlen($email) > 255) {
            return "Email muito longo";
        }
        return true;
    }

    public static function validatePassword(string $password): string|bool {
        if (empty($password)) {
            return "Senha é obrigatória";
        }

        if (strlen($password) < 8) {
            return "Senha deve ter pelo menos 8 caracteres";
        }

        if (!preg_match('/[A-Z]/', $password)) {
            return "Senha deve ter pelo menos uma letra maiúscula";
        }

        if (!preg_match('/[0-9]/', $password)) {
            return "Senha deve ter pelo menos um número";
        }

        return true;
    }
}
