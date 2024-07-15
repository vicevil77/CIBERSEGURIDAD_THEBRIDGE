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