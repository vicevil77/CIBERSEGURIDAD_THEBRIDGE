// Definir un mapeo de identificadores a archivos reales
$allowed_pages = [
    'home' => 'home.php',
    'about' => 'about_us.php',
    'contact' => 'contact_form.php'
];
// Obtener el identificador de la página
$page = $_GET['page'];

if (isset($allowed_pages[$page])) {
    include($allowed_pages[$page]);
} else {
    // Si la página no está permitida, mostrar un error 404
    include('404.php');
}

<?php
    define('BASE_PATH', '/var/www/html/allowed_pages/');

	$allowed_pages = ['home.php', 'about.php', 'contact.php'];
	
	$page = isset($_GET['page']) ? $_GET['page'] : 'home.php';
	
	if (in_array($page, $allowed_pages) && file_exists(BASE_PATH . $page)) {
	    include(BASE_PATH . $page);
	} else {
	    // Manejar error o redirigir a página por defecto
	    include(BASE_PATH . '404.php');
	}
?>

<?php
function validateInput($input) {
    // Definir patrones de entrada malintencionada (lista negra)
    $pattern = '/(http|https|ftp|sftp|data):\/\/|\.php|\.exe|\.htaccess|\.config|\.js|\.css|\.svg|\.ico|\.gif|\.jpg|\.jpeg|\.png|\.bmp|\.tiff|\.pdf|\.doc|\.docx|\.xls|\.xlsx|\.ppt|\.pptx|\.zip|\.rar|\.7z|\.tar|\.gz|\.bz2|\.xz|\.iso|\.mp3|\.wav|\.ogg|\.flac|\.mp4|\.avi|\.mov|\.wmv|\.flv|\.swf|\.exe|\.msi|\.dll|\.ocx|\.sys|\.vbs|\.vbe|\.js|\.jse|\.ws|\.wsc|\.wsh|\.hta|\.htc|\.sct|\.vb|\.vba|\.vbs|\.vbe|\.vbscript|\.asp|\.aspx|\.ascx|\.asmx|\.ashx|\.axd|\.vbhtml|\.vb|\.vbs|\.vbe|\.vbscript/i';

    // Verificar si la entrada coincide con el patrón de entrada malintencionada (lista negra)
    if (preg_match($pattern, $input)) {
        // Entrada no válida, mostrar mensaje de error
        return false;
    }

    // Entrada válida
    return true;
}

// Ejemplo de uso
$input = $_GET['file'];
if (validateInput($input)) {
    // Procesar la entrada
} else {
    // Entrada no válida, mostrar mensaje de error
}
?>

<?php
// Definir una lista blanca de páginas permitidas
function sanitizeInput($input) {
    // Eliminar etiquetas HTML y PHP de la entrada del usuario (XSS)
    $input = urldecode($input);

    // Eliminar caracteres especiales y espacios en blanco al principio y al final
    $input = preg_replace('/[^a-zA-Z0-9_\-\.]/', '', $input);

    // Convertir la entrada a minúsculas para evitar problemas de sensibilidad
    $input = strtolower($input);

    return $input;
}

// Obtener la página solicitada desde la URL, previamente sanitizada
$page = sanitizeInput($_GET['page']);

“allow_url_include” es una directiva de configuración de PHP que permite o prohíbe la inclusión de archivos remotos en un script PHP. 
Si está habilitado, un atacante podría incluir un archivo remoto malicioso y ejecutar código arbitrario en el servidor.
 Por lo tanto, es una buena práctica deshabilitar esta configuración en entornos de producción para evitar posibles vulnerabilidades de seguridad.
#ponerin ejemplo del uso de allow_url_include de manera maliciosa y explicando porque es peligroso

<?php
// Deshabilitar la configuración "allow_url_include" para evitar la inclusión de archivos remotos
ini_set('allow_url_include', 0);

// Obtener la URL del archivo remoto desde la entrada del usuario
$file = $_GET['file'];

// Verificar si la URL es válida antes de incluir el archivo de forma segura, evitando posibles vulnerabilidades
if (filter_var($file, FILTER_VALIDATE_URL)) { #FILTER_VALIDATE_URL es una constante que se utiliza para validar una URL
    // La URL es válida, incluir el archivo de forma segura
    include($file);
} else {
    // La URL no es válida, mostrar un mensaje de error
    echo 'URL no válida';
}
?>

    
 
<?php
// Definir las páginas permitidas en un array (lista blanca)
$allowedPages = array('home', 'about', 'contact');

// Obtener la página solicitada desde la URL
$page = $_GET['page'];

// Verificar si la página solicitada está permitida y existe en la lista blanca
if (in_array($page, $allowedPages)) {
    // Incluir el archivo correspondiente a la página solicitada
    include_once($page . '.php');
} else {
    // Mostrar un mensaje de error, si la página no está permitida y no existe en la lista blanca
    echo 'Página no encontrada';
}
?>


<?php
# mapear identificadores a archivos reales con 
#la finalidad de evitar la inclusión de archivos arbitrarios
$allowed_pages = [ 
    'home' => 'home.php',
    'about' => 'about_us.php',
     'contact' => 'contact_form.php'
    ];
$page = $_GET['page'];
if (isset($allowed_pages[$page])) {
    include($allowed_pages[$page]);
} else {
    include('404.php');
}
    