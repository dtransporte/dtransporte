<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| ARCHIVO PRINCIPAL DE CONFIGURACION DE LA APLICACION
|--------------------------------------------------------------------------
| Ubicacion: application/config
| 
|
*/

/*
    Diferencia horaria con el servidor en horas
*/
$config['dtr-diff-time-server'] = -1;

/*
    Precios de servicios por categoria en dolares americanos
*/
$config['dtr-service-price'] = [
    'min' => 75,
    'max' => 150,
    'step' => 25
];

/*
    Dias libres de uso de la aplicacion. 
    Solo para empresas registradas.
*/
$config['dtr-assoc-freedays'] = 60;

/*
    Configuracion recordatorios de pago. 
    La aplicacion enviara un recordatorio por email 7 dias 1 dia previo al pago
*/
$config['dtr-payment-reminder'] = 7*24*3600;


/*
	Idioma por defecto
*/
$config['dtr-default-lang'] = 'es';

/*
    Array de idiomas
*/
$config['dtr-languages'] = [
    'es' => 'Espa&ntilde;ol',
    //'en' => 'English',
    //'pt' => 'Portugues'
];

/*
	Configuracion captcha formulario de registro
*/
$config['dtr-captcha'] = [
	'word'          => NULL,
    'img_path'      => 'imgs/captcha/',
    'img_url'       => 'imgs/captcha/',
    'font_path'     => NULL,
    'img_width'     => '150',
    'img_height'    => '40',
    'expiration'    => 7200,
    'word_length'   => 4,
    'font_size'     => 20,
    'font_path'		=> 'https://fonts.googleapis.com/css?family=sans',
    'img_id'        => NULL,
    'pool'          => '0123456789abcdefghijklmnopqrstuvwxyz', //0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ

    // White background and border, black text and red grid
    'colors'        => [
            'background' => [30,87,153],
            'border' => [255, 255, 255],
            'text' => [255, 255, 255],
            'grid' => [30,87,153]
    ]
];

/*
    ---------------------------------------------------------------------------------------------------
    Configuracion cookie dtransporte
    ---------------------------------------------------------------------------------------------------
    $name (mixed) – Cookie name or associative array of all of the parameters available to this function
    $value (string) – Cookie value
    $expire (int) – Number of seconds until expiration
    $domain (string) – Cookie domain (usually: .yourdomain.com)
    $path (string) – Cookie path
    $prefix (string) – Cookie name prefix
    $secure (bool) – Whether to only send the cookie through HTTPS
    $httponly (bool) – Whether to hide the cookie from JavaScript
*/
$config['dtr-cookie'] = [
    'name' => 'dTransporte',
    'value' => 'ok',
    'expire' => 7200,
    'domain' => 'dtransporte.com',
    'path' => '/',
    'secure' => TRUE,
    'httponly' => FALSE
];

$config['dtr-cookie-user'] = [
    'name' => 'dtr-user-logged',
    'value' => 0,
    'expire' => 7200*1000,
    'domain' => 'dtransporte.com',
    'path' => '/',
    'secure' => TRUE,
    'httponly' => FALSE
];

$config['dtr-cookie-accept'] = [
    'name' => 'dtr-cookie-accept',
    'value' => 'ok',
    'expire' => 7200*1000,
    'domain' => 'dtransporte.com',
    'path' => '/',
    'secure' => TRUE,
    'httponly' => FALSE
];

/*
    Directorio en el que se guarda la info de visitantes
*/
$config['dtr-visitors-dir'] = '/home/dtransporte/tmp/.visitors';

/*
    Formatos de fecha y hora
*/
$config['dtr-date-db'] = '%Y-%m-%d';
$config['dtr-datetime-db'] = '%Y-%m-%d %H:%i:%s';

$config['dtr-date-format'] = [
    '%d/%m/%Y' => '23/12/2017 (dd/mm/yyyy)',
    '%m/%d/%Y' => '12/23/2017 (mm/dd/yyyy)',
    '%Y/%m/%d' => '2017/12/23 (yyyy/mm/dd)'
];

$config['dtr-time-format'] = [
    '%H:%i:%s' => '19:45:59',
    '%H:%i' => '19:45',
    '%H:%i %a' => '07:45 am/pm',
    '%H:%i:%s %a' => '07:45:59 am/pm',
];

/*
    Referencia de navegadores (Habilitar Cookies)
*/
$config['dtr-browsers'] = [
    'Chrome' => 'https://support.google.com/accounts/answer/61416?co=GENIE.Platform%3DDesktop&hl=es',
    'Firefox' => 'https://support.mozilla.org/es/kb/habilitar-y-deshabilitar-cookies-sitios-web-rastrear-preferencias',
    'Opera' => 'http://help.opera.com/Mac/12.10/es-LA/cookies.html',
    'Safari' => 'https://support.apple.com/es-mx/guide/safari/sfri11471/mac'
];

/*
    Periodo maximo de validacion en segundos (default: 1 dia)
        _ Registro nuevo usuario
        _ Olvido de contrasenia
        _ Usuario bloqueado
*/
$config['dtr-max-validation-time'] = 24*60*60;

/*
    Configuracion de opciones de contrasenias
*/
$config['dtr-password'] = [
    'minlength' => 6,
    'maxlength' => 12,
    'type'  => 'alfanum', //alfanum, alfa, num, specialchars
    'fixedlength' => 6
];

/*
    Configuracion de archivos a subir al servidor
*/
$config['dtr-upload-files'] =[
    'url' => 'index.php/upload',
    'multi_selection' => 1,
    'filters' => [
        // Maximum file size
        'max_file_size' => '300kb',
        // Specify what files to browse for
        'mime_types'=> [
            ['title' => "Image files", 'extensions' => "jpg,gif,png"],
            ['title' => "Document files", 'extensions' => "pdf,txt"]
        ],
        'prevent_duplicates' => 1
    ],
    'resize'=> [
        'width' => 200,
        'height' => 200,
        'quality' => 90,
        'crop'=> 1 // crop to exact dimensions
    ],
    'multipart_params' => [
        'upload_path' => NULL,
        'isImage' => 1,
        'isUserImage' => 0,
        'deleteFiles' => 1,
        'maxFilesUpload' => 1,
        'previewContainer' => NULL // ID del contenedor de vista previa si esta definido
    ]
];

/*
    Array de monedas
*/
$config['dtr-currencies'] = [
    'native' => [],
    'dolar' => ['currencycode'=> 'USD', 'currencyname'=> 'Dollar'],
    'euro' => ['currencycode'=> 'EUR', 'currencyname'=> 'Euro']
];

/*
    Fuentes por defecto
*/
$config['dtr-font-family'] = [
    'sans',
    'Arial',
    'Courier',
    'Righteous',
    'Raleway',
    'Open Sans Condensed',
    'PT Sans'
];

$config['dtr-font-size'] = ['10px', '12px', '14px', '16px', '18px', '20px'];

/*
    Duracion de bloqueo de pantalla en minutos
*/
$config['dtr-block-screen-duration'] = ['0', '15', '30', '60', '90', '120'];

/*
    Numero de intentos de desbloqueo de pantalla antes de bloquear al usuario
*/
$config['dtr-scr-unblock-attempts'] = 3;