

<?php

// Se sustituye la cabecera de seguridad por la CSP actualizada
header("Content-Security-Policy: default-src 'self'; script-src 'self'; object-src 'none'; style-src 'self'; img-src 'self'; media-src 'none'; frame-src 'none'; font-src 'self'; connect-src 'self'; form-action 'self'; frame-ancestors 'none'; plugin-types 'none'; base-uri 'self';");

// Verificar si hay alguna entrada y no está vacía
if(array_key_exists("name", $_GET) && $_GET['name'] != NULL) {

    // Escapar caracteres especiales de HTML como  "<" ,">","&", '"' y "'"
    // convirtiéndolos en entidades HTML de texto plano para evitar ataques XSS 
    $name = htmlspecialchars($_GET['name'], ENT_QUOTES, 'UTF-8');
    
    // imprime el parametro name junto con un mensaje de bienvenida
    echo '<pre>Hello ' . $name . '</pre>';
}

?>

<script>while(1)alert("Este mensaje saldrá indefinidamente")</script>

//codigo mejorado nivel medio XSS-reflected - ejer-1

<?php

// Implementar CSP para mejorar la seguridad contra ataques XSS, permitiendo solo script de la misma fuente
header("Content-Security-Policy: default-src 'self'; script-src 'none';");

// Verificar si hay alguna entrada y no está vacía
if(array_key_exists("name", $_GET) && !empty($_GET['name'])) {

    // Escapar caracteres especiales de HTML como  "<" ,">","&", '"' y "'"
    // convirtiéndolos en entidades HTML de texto plano para evitar ataques XSS
    $name = htmlspecialchars($_GET['name'], ENT_QUOTES, 'UTF-8');

    // imprime el parametro name junto con un mensaje de bienvenida
    echo "<pre>Hello ${name}</pre>";
}
?>

// codigo ejercicio 2 xss-stored low

<?php

// verifica si se ha enviado el formulario a través del método POST antes de procesar los datos
if( isset( $_POST[ 'btnSign' ] ) ) {

    // Conexión a la base de datos y se selecciona la base de datos donde se almacenarán los mismos
    $message = trim( $_POST[ 'mtxMessage' ] );
    $name    = trim( $_POST[ 'txtName' ] );

    // mediante la funcion stripslashes se eliminan las barras invertidas de un string en versiones antigua de PHP
    // para evitar que se almacenen en la base de datos y se muestren en la página
    $message = stripslashes( $message );

    //uso de una condiccion ternaria que verifica si la variable es un objeto en la base de datos
    //si es asi se escapa el string, y en caso contrario se muestra un mensaje de error
    $message = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], 
     $message ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : "")); 


    // AL igual que con la variable $message, se verifica si la variable $name es un objeto en la base de datos
    $name = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], 
     $name ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));


    // Se ejecuta la consulta SQL para insertar los datos en la base de datos, siendo escrita de manera manual .
    // Esto presenta un riesgo de inyección SQL, ya que no se están utilizando consultas preparadas
    //Finalmente se cierra la conexión a la base de datos, siendo almacenados los datos en la tabla guestbook
    $query  = "INSERT INTO guestbook ( comment, name ) VALUES ( '$message', '$name' );";
    $result = mysqli_query($GLOBALS["___mysqli_ston"],  $query ) or die( '<pre>' . ((is_object($GLOBALS["___mysqli_ston"])) 
    ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) . '</pre>' );

  
}

?>

//codigo mejorado nivel bajo XSS-stored

<?php

// Se erifica si se ha enviado el formulario a través del método POST antes de procesar los datos
if(isset($_POST['btnSign'])) {

    // Conexión a la base de datos y se selecciona la base de datos donde se almacenarán los mismos
    $mysqli = new mysqli("host", "usuario", "contraseña", "base_de_datos");

    // Se verifica si la conexión a la base de datos fue exitosa y en caso contrario se muestra un mensaje de error
    if($mysqli->connect_error) {
        die("Conexión fallida: " . $mysqli->connect_error);
    }

    // Se prepara la consulta SQL para insertar los datos en la base de datos, utilizando consultas preparadas
    $stmt = $mysqli->prepare("INSERT INTO guestbook (comment, name) VALUES (?, ?)");

    // Se vinculan los parámetros de la consulta preparada con las variables que contienen los datos a insertar
    $stmt->bind_param("ss", $message, $name);

    // Se obtienen los datos del formulario inicial y se eliminan los espacios en blanco al inicio y al final
    $message = trim($_POST['mtxMessage']);
    $name = trim($_POST['txtName']);

    // Se ejecuta la consulta preparada para insertar los datos en la base de datos y en caso de error se muestra un mensaje de error
    if(!$stmt->execute()) {
        // Manejar error de manera segura
        error_log("Error en la inserción: " . $stmt->error);
        echo "<pre>Error al procesar su solicitud. Por favor, intente de nuevo más tarde.</pre>";
    } else {
        echo "<pre>Mensaje guardado con éxito.</pre>";
    }

    // Se procede a cerrar la consulta preparada y la conexión a la base de datos
    $stmt->close();
    $mysqli->close();
}

?>

//codigo nivel medio XSS-stored

<?php

//Se verifica si se ha enviado el formulario a través del método POST antes de procesar los datos
if( isset( $_POST[ 'btnSign' ] ) ) {

    // Se selecciona la base de datos donde se almacenarán los datos y se eliminan los espacios en blanco al inicio y al final
    $message = trim( $_POST[ 'mtxMessage' ] );
    $name    = trim( $_POST[ 'txtName' ] );

    // Se eliminan las barras invertidas de un string en versiones antiguas de PHP para evitar que se almacenen en la base de datos y se muestren en la página
    $message = strip_tags( addslashes( $message ) );

    // Se verifica si la variable $message es un objeto en la base de datos y smediante la funciona mysqli_real_escape_string se escapa el string, 
    //y en caso contrario se muestra un mensaje de error
    $message = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $message ) : 
    ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
    
    // Se convierten los caracteres especiales en entidades HTML de texto plano para evitar ataques XSS
    $message = htmlspecialchars( $message );

    // Se sanitiza el nombre para evitar ataques XSS y se eliminan las barras invertidas de un string en versiones antiguas de PHP
    $name = str_replace( '<script>', '', $name );

    // Se verifica si la variable $name es un objeto en la base de datos y smediante la funciona mysqli_real_escape_string se escapa el string, 
    //y en caso contrario se muestra un mensaje de error
    $name = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $name ) : 
    ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));

    // Se crea la consulta SQL para insertar los datos en la base de datos, siendo escrita de manera manual
    // Esto presenta un riesgo de inyección SQL, ya que no se están utilizando consultas preparadas
    $query  = "INSERT INTO guestbook ( comment, name ) VALUES ( '$message', '$name' );";

    // Se ejecuta la consulta SQL realizada anteriormente y en caso de error se muestra un mensaje de error, cerraando la conexión a la base de datos
    $result = mysqli_query($GLOBALS["___mysqli_ston"],  $query ) or die( '<pre>' . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : 
    (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) . '</pre>' );

   }

?> 

//mejora de coidigo nivel medio xss-stored

<?php

// Implementación de CSP para mejorar la seguridad contra ataques XSS
header("Content-Security-Policy: default-src 'self'; script-src 'self' https://trustedscripts.example.com; object-src 'none'; 
style-src 'self'  https://trustedscripts.example.com; img-src 'self'; media-src 'none'; frame-src 'none'; font-src 'self'; 
connect-src 'self'; plugin-types 'none'; base-uri 'self';");

// Se verifica si se ha enviado el formulario a través del método POST antes de procesar los datos
if( isset( $_POST[ 'btnSign' ] ) ) {

    // Se selecciona la base de datos donde se almacenarán los datos y se eliminan los espacios en blanco al inicio y al final
    $message = trim( $_POST[ 'mtxMessage' ] );
    $name    = trim( $_POST[ 'txtName' ] );

    // Se eliminan las etiquetas HTML y las barras invertidas de un string en versiones antiguas de PHP para evitar que se almacenen en la base de datos 
    $message = strip_tags( addslashes( $message ) );

    // Se verifica si la variable $message es un objeto en la base de datos y mediante la función mysqli_real_escape_string se escapa el string, 
    // y en caso contrario se muestra un mensaje de error
    $message = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $message ) : 
    ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
    
    // Se convierten los caracteres especiales en entidades HTML de texto plano para evitar ataques XSS
    $message = htmlspecialchars( $message, ENT_QUOTES, 'UTF-8' );

    // Se sanitiza el nombre para evitar ataques XSS y se eliminan las barras invertidas de un string en versiones antiguas de PHP
    $name = str_replace( '<script>', '', $name );

    // Se verifica si la variable $name es un objeto en la base de datos y mediante la función mysqli_real_escape_string se escapa el string, 
    // y en caso contrario se muestra un mensaje de error
    $name = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $name ) : 
    ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));

    // Se crea la consulta SQL para insertar los datos en la base de datos, utilizando consultas preparadas para evitar inyecciones SQL
    $stmt = $GLOBALS["___mysqli_ston"]->prepare("INSERT INTO guestbook ( comment, name ) VALUES (?, ?)");
    if ($stmt) {
        $stmt->bind_param("ss", $message, $name);
        $stmt->execute();
        $stmt->close();
    } else {
        // Manejo de errores seguro
        error_log("Error en la preparación de la consulta: " . $GLOBALS["___mysqli_ston"]->error);
        echo "Ha ocurrido un error. Por favor, inténtelo de nuevo más tarde.";
    }
}

// Se cierra la conexión a la base de datos
mysqli_close($GLOBALS["___mysqli_ston"]);

?>


//script de ataque xss-stored


<script>alert("XSS.Stored_sinNada")</script>


<imag """=""><script>alert("XSS-Stored")</script>">


//codifo completo de validacion y saneamiento en PHP

<?php
// Se verifica si el email es valido, retornando true si lo es y false en caso contrario
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}
// se verifica si el número es un entero, retornando true si lo es y false en caso contrario
function validateInteger($number) {
    return filter_var($number, FILTER_VALIDATE_INT);
}
// se sanitiza la entrada de datos, usando la funcion htmlspecialchars para escapar caracteres especiales
 // y ENT_QUOTES para convertir comillas dobles y simples en entidades HTML de texto plano
function sanitizeInput($input) {
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}
// Se sanitiza las entradas $conn y $input con la funcion mysqli_real_escape_string 
//para evitar ataques XSS e inyección SQL
function sanitizeForSQL($conn, $input) {
    return mysqli_real_escape_string($conn, $input);
}
// Se verifica si se ha enviado el formulario a través del método POST antes de procesar los datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Se establece la conexión a la base de datos con el servidor, nombre de usuario, contraseña y database
    $conn = new mysqli("localhost", "username", "password", "database");
// Se comprueba que las variables del formulario existan y han sido enviadas a través del método POST
    $email = $_POST['email'];
    $age = $_POST['age'];
    $comment = $_POST['comment'];
// se validad finalmente los datos,  usando la funcion de sanitizeForSQL para evitar inyección SQL
    if (validateEmail($email) && validateInteger($age)) {
        $email = sanitizeForSQL($conn, $email);
        $age = sanitizeForSQL($conn, $age);
        $comment = sanitizeInput($comment);
// Se ejecuta la consulta SQL para insertar los datos en la base de datos, utilizando consultas preparadas
        $query = "INSERT INTO users (email, age, comment) VALUES ('$email', '$age', '$comment')";
        if ($conn->query($query) === TRUE) {
            echo "Nuevo registro creado con éxito";
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }
    } else {
        echo "Datos inválidos";
    }kal
// Se cierra la conexión a la base de datos
    $conn->close();
}
?>

//encabezado CSP muy completo para evitar ataques XSS

// Se establece la política de seguridad de contenido (CSP) para proteger contra script externos. conn
// https//trustedscripts.example.com consegimos que solo se carguen scripts de ese dominio. con object -none no se permiten objetos, 
//con style-src se permiten estilos de trustedstyles.example.com y con base-url se permite la URL base del documento y con form-action se permiten formularios de la misma URL
<?php
http-equiv="Content-Security-Policy"
content=" default-src 'self'; script-src 'self' https://trustedscripts.example.com; object-src 'none'; 
style-src 'self' https://trustedstyles.example.com; base-uri 'self'; form-action 'self';" />

//resgitro de errores en bases de dastos y mensaje generico de error usuario final

//Se ejecuta la culsulta SQL para ser insertada en la BBDD, y en caso de error se muestra un mensaje de error
$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query ) or die( '<pre>' . ((is_object($GLOBALS["___mysqli_ston"])) 
? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) . '</pre>' );

//recoge el error en un archivo de registro o base de datos de errores y muestra al usurio un mensaje de error generico
if (!$result) {

    // Registra el error en un archivo de registro o base de datos de errores
    error_log("Error en la consulta SQL: " . mysqli_error($GLOBALS["___mysqli_ston"]));

    // Muestra un mensaje de error genérico al usuario
    echo "Ha ocurrido un error. Por favor, inténtelo de nuevo más tarde.";
} else {
    echo "Datos guardados con éxito.";

}