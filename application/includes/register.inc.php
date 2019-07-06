<?php
$error_msg = "";
 
if (isset($_POST['username'], $_POST['email'], $_POST['p'])) {
    // Sanear y validar los datos provistos.
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // No es un correo electrónico válido.
        $error_msg .= '<p class="error">El email ingresado no es v&aacutelido</p>';
    }
 
    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        // La contraseña con hash deberá ser de 128 caracteres.
        // De lo contrario, algo muy raro habrá sucedido. 
        $error_msg .= '<p class="error">La configuraci&oacuten de password no es v&aacutelido.</p>';
    }
 
    // La validez del nombre de usuario y de la contraseña ha sido verificada en el cliente.
    // Esto será suficiente, ya que nadie se beneficiará de
    // violar estas reglas.
    //
 
    $prep_stmt = "SELECT id FROM login_members WHERE email = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
 
   // Verifica el correo electrónico existente.  
    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
 
        if ($stmt->num_rows == 1) {
            // Ya existe otro usuario con este correo electrónico.
            $error_msg .= '<p class="error">Ya existe el correo electr&oacutenico.</p>';
                        $stmt->close();
        }
                $stmt->close();
    } else {
        $error_msg .= '<p class="error">Database error Line 39</p>';
                $stmt->close();
    }
 
    // Verifica el nombre de usuario existente. 
    $prep_stmt = "SELECT id FROM login_members WHERE username = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
 
    if ($stmt) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
 
                if ($stmt->num_rows == 1) {
                        // Ya existe otro usuario con este nombre de usuario.
                        $error_msg .= '<p class="error">Ya existe el nombre de usuario</p>';
                        $stmt->close();
                }
                $stmt->close();
        } else {
                $error_msg .= '<p class="error">Database error line 55</p>';
                $stmt->close();
        }
 
    // Pendiente: 
    // También habrá que tener en cuenta la situación en la que el usuario no tenga
    // derechos para registrarse, al verificar qué tipo de usuario intenta
    // realizar la operación.
 
    if (empty($error_msg)) {
        // Crear una sal aleatoria.
        //$random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE)); // Did not work
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
 
        // Crea una contraseña con sal. 
        $password = hash('sha512', $password . $random_salt);
 
        // Inserta el nuevo usuario a la base de datos.  
        if ($insert_stmt = $mysqli->prepare("INSERT INTO login_members (username, email, password, salt) VALUES (?, ?, ?, ?)")) {
            $insert_stmt->bind_param('ssss', $username, $email, $password, $random_salt);
            // Ejecuta la consulta preparada.
            if (! $insert_stmt->execute()) {
                header('Location: ../../error.php?err=Fallo el registro');
            } else {
                 //header('Location: ./?modal=register_success&user=' . $_POST['username']);
               echo '<script>
                        window.location.href="application/src/routes.php?op=0z&user=' . $_POST['username'] . '";
                    </script>';
            }
        }
              
    }
}
?>