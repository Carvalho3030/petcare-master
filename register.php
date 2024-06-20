<?php
session_start();
?>

<!DOCTYPE html>
<html lang="zxx">
<head>
	<title>Register</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/img-01.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" method="post" action="register.php">
					<span class="login100-form-title">
						Register
					</span>

					<div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="username" placeholder="Username">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>
					<br>
					<div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="email" placeholder="Email">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>
					<br>
					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit" name="register">
							Register
						</button>
					</div>
				</form>

				<?php
				if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
					include 'bd_acess.php'; // Incluir o arquivo de conexão

					$username = $_POST['username'];
					$email = $_POST['email'];
					$password = $_POST['password'];
					
					// Valores predefinidos
					$tentativas = 5;
					$permissao = 2;
					
					// Gerar número de processo aleatório
					$n_processo = mt_rand(100000, 999999); // Gera um número aleatório de 6 dígitos
					
					// Verificar se os campos estão vazios
					if (empty($username) || empty($email) || empty($password)) {
						echo "<div class='alert alert-danger' role='alert'>All fields are required.</div>";
					} else {
						// Verificar se o usuário já existe
						$sql = "SELECT * FROM users WHERE username = ?";
						$stmt = $conexao->prepare($sql);
						$stmt->bind_param("s", $username);
						$stmt->execute();
						$result = $stmt->get_result();

						if ($result->num_rows > 0) {
							echo "<div class='alert alert-danger' role='alert'>Username already exists.</div>";
						} else {
							// Inserir novo usuário
							$hashed_password = password_hash($password, PASSWORD_DEFAULT);
							$sql = "INSERT INTO users (username, email, password, tentativas, permissao, n_processo) VALUES (?, ?, ?, ?, ?, ?)";
							$stmt = $conexao->prepare($sql);
							$stmt->bind_param("sssiii", $username, $email, $hashed_password, $tentativas, $permissao, $n_processo);

							if ($stmt->execute()) {
								echo "<div class='alert alert-success' role='alert'>Registration successful!</div>";
								header("Location: /petcare-master/cliente/interface_cliente.php");
								exit();
							} else {
								echo "Error: " . $stmt->error;
							}
						}
						$stmt->close();
					}
					mysqli_close($conexao); // Fechar conexão
				}
				?>
			</div>
		</div>
	</div>
	
<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script>
		$('.js-tilt').tilt({
			scale: 1.1
		});
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>
