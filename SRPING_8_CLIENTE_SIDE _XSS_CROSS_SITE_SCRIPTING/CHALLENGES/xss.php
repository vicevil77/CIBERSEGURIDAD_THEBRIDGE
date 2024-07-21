

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

//codigo mejorado nivel medio

<?php

// Implementar CSP para mejorar la seguridad contra ataques XSS
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