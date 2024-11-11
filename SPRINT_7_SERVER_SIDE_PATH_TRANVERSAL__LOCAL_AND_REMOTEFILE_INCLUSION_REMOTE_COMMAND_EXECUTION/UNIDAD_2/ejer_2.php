

//NIVEL BAJO DE SEGURIDAD - MEJORADO
<?php

if( isset( $_REQUEST[ 'Submit' ] ) ) {
    // Get input
    $id = $_REQUEST[ 'id' ];

    // Prepare statement
    $stmt = $GLOBALS["___mysqli_ston"]->prepare("SELECT first_name, last_name FROM users WHERE user_id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Get results
    while( $row = $result->fetch_assoc() ) {
        // Get values
        $first = $row["first_name"];
        $last  = $row["last_name"];

        // Feedback for end user
        echo "<pre>ID: {$id}<br />First name: {$first}<br />Surname: {$last}</pre>";
    }

    $stmt->close();
    mysqli_close($GLOBALS["___mysqli_ston"]);
}

?>


//NIVEL MEDIO DE SEGURIDAD - MEJORADO
<?php

if( isset( $_POST[ 'Submit' ] ) ) {
    // Get input
    $id = $_POST[ 'id' ];

    // Prepare statement
    $stmt = $GLOBALS["___mysqli_ston"]->prepare("SELECT first_name, last_name FROM users WHERE user_id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Get results
    while( $row = $result->fetch_assoc() ) {
        // Display values
        $first = $row["first_name"];
        $last  = $row["last_name"];

        // Feedback for end user
        echo "<pre>ID: {$id}<br />First name: {$first}<br />Surname: {$last}</pre>";
    }

    $stmt->close();
}

// This is used later on in the index.php page
// Setting it here so we can close the database connection in here like in the rest of the source scripts
$query  = "SELECT COUNT(*) FROM users;";
$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query ) or die( '<pre>' . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) . '</pre>' );
$number_of_rows = mysqli_fetch_row( $result )[0];

mysqli_close($GLOBALS["___mysqli_ston"]);
?>


// VULNERABLE NIVEL MEDIO - EL ORIGINAL
<?php

if( isset( $_POST[ 'Submit' ] ) ) {
    // Get input
    $id = $_POST[ 'id' ];

    $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $id);

    $query  = "SELECT first_name, last_name FROM users WHERE user_id = $id;";
    $result = mysqli_query($GLOBALS["___mysqli_ston"], 
    $query) or die( '<pre>' . mysqli_error($GLOBALS["___mysqli_ston"]) . '</pre>' );

    // Get results
    while( $row = mysqli_fetch_assoc( $result ) ) {
        // Display values
        $first = $row["first_name"];
        $last  = $row["last_name"];

        // Feedback for end user
        echo "<pre>ID: {$id}<br />First name: {$first}<br />Surname: {$last}</pre>";
    }

}

// This is used later on in the index.php page
// Setting it here so we can close the database connection in here like in the rest of the source scripts
$query  = "SELECT COUNT(*) FROM users;";
$result = mysqli_query($GLOBALS["___mysqli_ston"],  
$query ) or die( '<pre>' . ((is_object($GLOBALS["___mysqli_ston"]))
 ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error())
  ? $___mysqli_res : false)) . '</pre>' );
$number_of_rows = mysqli_fetch_row( $result )[0];

mysqli_close($GLOBALS["___mysqli_ston"]); 

// NIVEL BAJO VULNERABLE - ORIGINAL

<?php

if( isset( $_REQUEST[ 'Submit' ] ) ) {
    // Get input
    $id = $_REQUEST[ 'id' ];

    // Check database
    $query  = "SELECT first_name, last_name FROM users WHERE user_id = '$id';";
    $result = mysqli_query($GLOBALS["___mysqli_ston"],  $query ) or die( '<pre>' . ((is_object($GLOBALS["___mysqli_ston"]))
     ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) . '</pre>' );

    // Get results
    while( $row = mysqli_fetch_assoc( $result ) ) {
        // Get values
        $first = $row["first_name"];
        $last  = $row["last_name"];

        // Feedback for end user
        echo "<pre>ID: {$id}<br />First name: {$first}<br />Surname: {$last}</pre>";
    }

    mysqli_close($GLOBALS["___mysqli_ston"]);
}

?> 

// MEJORA DE SEGURIDAD - NIVEL BAJO

<?php
// preguntamos si se ha enviado el formulario
if( isset( $_REQUEST[ 'Submit' ] ) ) {
    // obtenemos el id del usuario
    $id = $_REQUEST[ 'id' ];

    // preparamos la consulta para evitar inyecciones SQL (tecnica sentencias preparadas)
    $stmt = mysqli_prepare($GLOBALS["___mysqli_ston"], // preparamos la consulta  

    // consulta SQL con un marcador de posición para el id()
    "SELECT first_name, last_name FROM users WHERE user_id = ?");

    // se vincula la preparación de la consulta con el marcador de posición de la id,
    // consiguiendo que el valor de la id y de la setencia SQL no se mezclen, evitando inyecciones SQL
    mysqli_stmt_bind_param($stmt, "s", $id);

    // ejecutamos la consulta y guradammos el resultado en una variable
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Si exiten resultados, se mostraran al usuario 
    while( $row = mysqli_fetch_assoc( $result ) ) { 
        // Se obtiene los valores nombre y apellido del usuario
        $first = $row["first_name"];
        $last  = $row["last_name"];

        // Se muestran los valores al usuario
        echo "<pre>ID: {$id}<br />First name: {$first}<br />Surname: {$last}</pre>";
    }

    // cierra la consulta y la conexión a la base de datos
    mysqli_stmt_close($stmt);
    mysqli_close($GLOBALS["___mysqli_ston"]);
}
?> 
// MEJORA DE SEGURIDAD - NIVEL MEDIO

<?php

// Se Comprueba si se ha enviado el formulario y se obtene el id del usuario
if( isset( $_POST[ 'Submit' ] ) ) {
    $id = $_POST[ 'id' ];

    // Se prepara la consulta a la BBDDs "GLOBALS["___mysqli_ston"]" de MySQL, usando la tecnica de sentencias preparadas,
    //usando en user_id un marcador de posición (?), vinculando el valor de la id con la consulta, evitando inyecciones SQL
    $stmt = mysqli_prepare($GLOBALS["___mysqli_ston"], "SELECT first_name, last_name FROM users WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, "s", $id);

    // Se ejecuta la consulta y se guarda el resultado en una variable para mayor seguridad
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Se obtienen  los valores de nombre y apellido
    // y se muesstra el resultado al usuario en formato html 
    while( $row = mysqli_fetch_assoc( $result ) ) {
        $first = $row["first_name"];
        $last  = $row["last_name"];
        echo "<pre>ID: {$id}<br />First name: {$first}<br />Surname: {$last}</pre>";
    }

    // Se finaliza la sentencia y la conexión
    mysqli_stmt_close($stmt);
}
mysqli_close($GLOBALS["___mysqli_ston"]);

?>//MEJORA DE MANEJO DE ERRORES - NIVEL BAJO Y MEDIO

<?php
....
....
....
// Se preparara la consulta para evitar inyecciones SQL, usando la técnica de sentencias preparadas
$stmt = mysqli_prepare($GLOBALS["___mysqli_ston"], "SELECT first_name, last_name FROM users WHERE user_id = ?");
if (!$stmt) {
    // Antes de la vinculacion del marcador, se comprueba si el servidor de BBDDs puede preparar la consulta,
    // En caso negativo,  se muestra un mensaje de error
    error_log("Error de preparación de consulta: " . mysqli_error($GLOBALS["___mysqli_ston"]));
    // Se muestra un mensaje genérico al usuario
    die("Ocurrió un error. Por favor, inténtelo de nuevo más tarde.");
}
// Se vincula el valor de la id con la sentencia SQL preparada
mysqli_stmt_bind_param($stmt, "s", $id);

// Se ejecuta la consulta y se guardan el resultado en una variable
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Se comproba si la consulta se ha podido ejecutar
if ($result === false) {
    // si la consulta no se puede ejecutar, se muestra un mensaje de error
    error_log("Error al ejecutar la consulta: " . mysqli_error($GLOBALS["___mysqli_ston"]));
    // Mostrar un mensaje genérico al usuario
    die("Ocurrió un error. Por favor, inténtelo de nuevo más tarde.");
}
....
....
....
?>
