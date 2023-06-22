<?php

// Inicia a sessão
session_start();

// Array para armazenar os nomes cadastrados
if (!isset($_SESSION['nombres'])) {
    $_SESSION['nombres'] = [];
}

// Função para adicionar um nome à lista
function adicionarNome($nome) {
    $_SESSION['nombres'][] = $nome;
}

// Função para remover um nome da lista
function removerNome($nome) {
    $indice = array_search($nome, $_SESSION['nombres']);
    if ($indice !== false) {
        unset($_SESSION['nombres'][$indice]);
        $_SESSION['nombres'] = array_values($_SESSION['nombres']);
    }
}

// Função para realizar o sorteio
function sortearNome() {
    $totalNomes = count($_SESSION['nombres']);

    if ($totalNomes > 0) {
        $indiceSorteado = rand(0, $totalNomes - 1);
        $nomeSorteado = $_SESSION['nombres'][$indiceSorteado];

        return $nomeSorteado;
    }

    return false;
}

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["nome"])) {
        $nome = $_POST["nome"];

        if (!empty($nome)) {
            adicionarNome($nome);
        }
    }
}

// Sorteia um nome quando o botão é clicado
if (isset($_POST["sortear"])) {
    $nomeSorteado = sortearNome();
    if ($nomeSorteado !== false) {
        removerNome($nomeSorteado);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Sorteio de Nomes</title>
</head>
<body>
    <h1>Sorteio de Nomes</h1>

    <form method="POST" action="">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome">
        <button type="submit">Adicionar</button>
    </form>

    <h2>Lista de Nomes</h2>
    <?php if (count($_SESSION['nombres']) > 0): ?>
        <ul>
            <?php foreach ($_SESSION['nombres'] as $nome): ?>
                <li><?php echo $nome; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Nenhum nome cadastrado.</p>
    <?php endif; ?>

    <h2>Sortear Nome</h2>
    <?php if (isset($nomeSorteado) && $nomeSorteado !== false): ?>
        <p>O nome sorteado é: <?php echo $nomeSorteado; ?></p>
    <?php elseif (isset($nomeSorteado) && $nomeSorteado === false): ?>
        <p>Nenhum nome disponível para sorteio.</p>
    <?php endif; ?>

    <?php if (count($_SESSION['nombres']) > 0): ?>
        <form method="POST" action="">
            <button type="submit" name="sortear">Sortear</button>
        </form>
    <?php endif; ?>
</body>
</html>
