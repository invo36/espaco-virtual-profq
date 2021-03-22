<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Itinerários</title>
</head>

<body>
    <?php
    require_once "includes/banco.php";
    require_once "includes/funcoes.php";
    require_once "includes/login.php";

    if (!$_SESSION['user'] == "") {
        echo "<script>window.location='usu-login.php'</script>";
    }

    ?>

    <div>
        <?php
        $user = $_POST['user'] ?? null;
        $pass = $_POST['senha'] ?? null;

        if (is_null($user) || is_null($pass)) {
            require "user-login-form.php";
        } else {
            $q = "select nick, nome, senha, nivel from usuarios where nick = '$user'";
            $busca = $banco->query($q);
            if (!$busca) {
                echo 'Errado!';
            } else {
                if ($busca->num_rows > 0) {
                    $reg = $busca->fetch_object();
                    if (testarHash($pass, $reg->senha)) {
                        $_SESSION['user'] = $reg->nick;
                        $_SESSION['nome'] = $reg->nome;
                        $_SESSION['nivel'] = $reg->nivel;
                        echo "<script>window.location='home.php'</script>";
                    } else {
                        echo 'Senha inválida!';
                    }
                } else {
                    echo 'Usuario n existe';
                }
            }
        }
        ?>


    </div>
</body>

</html>