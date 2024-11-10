<?php
// CONEXÃO COM BANCO DE DADOS
$hostname = 'localhost';
$bancodedados = 'crude';
$usuario = 'root';
$senha = '';
$mysqli = new mysqli($hostname, $usuario, $senha, $bancodedados);

// Função de deletar registro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['excluir'])) {
    $id = $_POST['id'];
    $instru = $mysqli->prepare("DELETE FROM formulario WHERE id=?");
    $instru->bind_param("i", $id);
    $instru->execute();
    $instru->close();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Função de editar registro
$email = $date = $endereco = $senha = "";
if (isset($_POST['edit'])) {
    $id = $_POST['edit'];
    $instru = $mysqli->prepare("SELECT * FROM formulario WHERE id=?");
    $instru->bind_param("i", $id);
    $instru->execute();
    $result = $instru->get_result();
    $row = $result->fetch_assoc();
    $email = $row['email'];
    $date = $row['datan'];
    $endereco = $row['endereco'];
    $senha = $row['senha'];
    $instru->close();
}

// Validação de inserção de dados
$erro_email = $erro_date = $erro_endereco = $erro_senha = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $email = $_POST["email"];
    $date = $_POST["date"];
    $endereco = $_POST["endereco"];
    $senha = $_POST["senha"];
    $id = $_POST["id"];

    if (empty($email)) {
        $erro_email = "border: 2px solid red;";
    }
    if (empty($date)) {
        $erro_date = "border: 2px solid red;";
    }
    if (empty($endereco)) {
        $erro_endereco = "border: 2px solid red;";
    }
    if (empty($senha)) {
        $erro_senha = "border: 2px solid red;";
    }

    if ($email && $date && $endereco && $senha) {
        if (!empty($id)) {
            $instru = $mysqli->prepare("UPDATE formulario SET email=?, senha=?, endereco=?, datan=? WHERE id=?");
            $instru->bind_param("ssssi", $email, $senha, $endereco, $date, $id);
        } else {
            $instru = $mysqli->prepare("INSERT INTO formulario (email, senha, endereco, datan) VALUES (?, ?, ?, ?)");
            $instru->bind_param("ssss", $email, $senha, $endereco, $date);
        }
        $instru->execute();
        $instru->close();
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Exibição na tabela
$result = $mysqli->query("SELECT id, email, datan, endereco FROM formulario ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
    <h2>Starting <span class="destaque">COMPANY</span></h2>
    <h1>Bem-vindo!</h1>
    <form class="row g-3" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
        <div class="col-md-6">
          <label for="inputEmail4" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" style="<?php echo $erro_email; ?>">
        </div>
        <div class="col-md-6">
          <label for="inputPassword4" class="form-label">Aniversário</label>
          <input type="date" class="form-control" id="date" name="date" value="<?php echo htmlspecialchars($date); ?>" style="<?php echo $erro_date; ?>">
        </div>
        <div class="col-12">
          <label for="inputAddress" class="form-label">Endereço</label>
          <input type="text" class="form-control" id="endereco" name="endereco" value="<?php echo htmlspecialchars($endereco); ?>" placeholder="Rua, Bairro, nº" style="<?php echo $erro_endereco; ?>">
        </div>
        <div class="col-12">
          <label for="inputAddress" class="form-label">Senha</label>
          <input type="password" class="form-control" id="senha" name="senha" value="<?php echo htmlspecialchars($senha); ?>" style="<?php echo $erro_senha; ?>">
        </div>
        <div class="col-12">
          <input type="submit" style="cursor: pointer;" class="btn btn-primary" value="<?php echo isset($id) ? 'Atualizar' : 'Login'; ?>" name="submit">
        </div>
    </form>
    <table class="table2">
        <thead style="background-color: black;">
          <tr>
            <th>Email</th>
            <th>Aniversário</th>
            <th>Endereço</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody style="background-color: black;">
          <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['datan']); ?></td>
            <td><?php echo htmlspecialchars($row['endereco']); ?></td>
            <td>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" style="display:inline; border:none;" class="button-editar">
                  <input type="hidden" name="edit" value="<?php echo htmlspecialchars($row['id']); ?>">
                  <button type="submit" value="Editar" class="button-editar btn btn-primary">Editar</button>
                </form>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" style="display:inline; border:none;" class="button-excluir">
                  <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                  <button type="submit" value="Excluir" name="excluir" class="button-excluir btn btn-danger" onclick="return confirm('Confirma que deseja excluir o registro?');">Excluir</button>
                </form>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
