<?php

require_once 'UserManager.php';

$manager = new UserManager();

// Caso 1
echo "Caso 1 — Cadastro válido<br>";
echo "Entrada: nome Maria Oliveira, email maria@email.com, senha Senha123.<br>";
echo $manager->registerUser("Maria Oliveira", "maria@email.com", "Senha123") . "<br><br>";

// Caso 2
echo "Caso 2 — Cadastro com e-mail inválido<br>";
echo "Entrada: nome Pedro, email pedro@@email, senha Senha123.<br>";
echo $manager->registerUser("Pedro", "pedro@@email", "Senha123") . "<br><br>";

// Caso 3
$manager->registerUser("João Silva", "joao@email.com", "SenhaForte1");
echo "Caso 3 — Tentativa de login com senha errada<br>";
echo "Entrada: email joao@email.com, senha Errada123.<br>";
echo $manager->loginUser("joao@email.com", "Errada123") . "<br><br>";

// Caso 4
$usuarios = $manager->listUsers();
$idJoao = $usuarios[0]['id'] ?? null;
echo "Caso 4 — Reset de senha válido<br>";
echo "Entrada: id 1, nova senha NovaSenha1.<br>";
if ($idJoao !== null) {
    echo $manager->resetPassword($idJoao, "NovaSenha1") . "<br><br>";
} else {
    echo "Erro: Usuário não encontrado para reset de senha.<br><br>";
}

// Caso 5
echo "Caso 5 — Cadastro de usuário com e-mail duplicado<br>";
echo "Entrada: email já existente no array.<br>";
echo $manager->registerUser("Outra Maria", "maria@email.com", "SenhaValida1") . "<br><br>";
