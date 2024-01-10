
<?php

function getConnection($file="db_settings.ini")
{

    $con = null;
    try {


        if (!$settings = parse_ini_file($file, TRUE)) throw new exception('Unable to open ' . $file . '.');

        $dsn = $settings['database']['driver'] .
            ':host=' . $settings['database']['host'] .
            ((!empty($settings['database']['port'])) ? (';port=' . $settings['database']['port']) : '') .
            ';dbname=' . $settings['database']['schema'];
        $con = new PDO($dsn, $settings['database']['username'], $settings['database']['password'],  array(
            PDO::ATTR_PERSISTENT => $settings['database']['persistent']
        ));

    } catch (PDOException $ex) {

        echo "Error en la conexión: mensaje: " . $ex->getMessage();
    }
    return $con;
}

?>
