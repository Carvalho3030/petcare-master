<?php
    $para = "petcaremaster24@gmail.com";

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $assunto = $_POST['assunto'];
    $mensagem = $_POST['mensagem'];

    $headers = "From: $email \r\n";
    $headers = 'Content-type: text/html;' . "\r\n";

    $msg_completa = "<h2>Nome: ".$nome."</h2><h2>Email: ".$email."</h2><h3>Mensagem: ".$mensagem."</h3>";

    if(mail($para, $assunto, $msg_completa, $headers)){
    header("Location: index.php");
    }else{
        echo "Erro";
    }
?>