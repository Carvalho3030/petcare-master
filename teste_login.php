<?php
session_start();
include ($_SERVER['DOCUMENT_ROOT']."/petcare-master/bd_acess.php"); // script de acesso à base de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se os campos do formulário estão definidos
    if (isset($_POST['username']) && isset($_POST['pass'])) {
        // Obtém os dados do formulário de login
        $username = $_POST['username'];
        $password = $_POST['pass'];

        // Consulta para verificar as credenciais do usuário
        $stmt = $conexao->prepare("SELECT * FROM users WHERE username = ? AND eliminado = 0");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // As credenciais estão corretas, verifica a senha
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Senha está correta, inicia a sessão
                $_SESSION['username'] = $username;
                // Outras variáveis de sessão podem ser definidas aqui

                // Redireciona com base no nível de permissão
                if ($user['permissao'] == 1) {
                    header("Location: /petcare-master/admin/interface_administrador.php");
                } else if ($user['permissao'] == 2 || $user['permissao'] == 3) {
                    header("Location: /petcare-master/cliente/interface_cliente.php");
                } else {
                    // Nível de permissão inválido
                    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>";
                    echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong! Invalid permission level',
                        footer: '<a href=\"#\">Why do I have this issue?</a>'
                    }).then(function() {
                        window.location = 'login.php';
                    });
                    </script>";
                }
                exit();
            } else {
                // Senha incorreta
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>";
                echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Invalid username or password',
                    footer: '<a href=\"#\">Why do I have this issue?</a>'
                }).then(function() {
                    window.location = 'login.php';
                });
                </script>";
            }
        } else {
            // Usuário não encontrado ou múltiplos usuários encontrados
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>";
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Invalid username or password',
                footer: '<a href=\"#\">Why do I have this issue?</a>'
            }).then(function() {
                window.location = 'login.php';
            });
            </script>";
        }
        $stmt->close();
    } else {
        // Campos do formulário não foram enviados
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>";
        echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Please fill in both fields',
            footer: '<a href=\"#\">Why do I have this issue?</a>'
        }).then(function() {
            window.location = 'login.php';
        });
        </script>";
    }
}
?>
