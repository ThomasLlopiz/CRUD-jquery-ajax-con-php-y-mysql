<?php 
    $host = "localhost";
    $bd = "crud_jquery_ajax_php_mysql";
    $usuario = "root";
    $contrasenia="";

    try {
        $conexion = new PDO("mysql:host=$host;dbname=$bd",$usuario,$contrasenia);
        //echo "Conectando...";
    } catch (Exception $ex){
        echo $ex->getMessage();
    }

    if (isset($_GET['accion'])=="insertar"){
        $nombre=$_POST['nombre'];
        $precio=$_POST['precio'];
        $sentenciaSQL = $conexion -> prepare("INSERT INTO mochilas (nombre,precio) VALUES (:nombre,:precio);");
        $sentenciaSQL -> bindParam(':nombre',$nombre);
        $sentenciaSQL -> bindParam(':precio',$precio);
        $sentenciaSQL -> execute();
        exit();
    }

    if (isset($_GET["borrar"])) {
        $id=$_GET["borrar"];
        $sentenciaSQL= $conexion -> prepare("DELETE FROM mochilas WHERE id=:id");
        $sentenciaSQL -> bindParam(':id',$id);
        $sentenciaSQL -> execute();
        exit();
    }
    
    if (isset($_GET["consultar"])) {
        $id=$_GET["consultar"];
        $sentenciaSQL= $conexion -> prepare("SELECT * FROM mochilas WHERE id=".$id);
        $sentenciaSQL -> execute();
        $listaMochilas = $sentenciaSQL -> fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($listaMochilas);
        exit();
    }

    if(isset($_GET["actualizar"])){
        $id=$_POST['id'];
        $nombre=$_POST['nombre'];
        $precio=$_POST['precio'];
        $sentenciaSQL = $conexion -> prepare("UPDATE mochilas SET nombre=:nombre,precio=:precio WHERE id=:id");
        $sentenciaSQL -> bindParam(':nombre',$nombre);
        $sentenciaSQL -> bindParam(':precio',$precio);
        $sentenciaSQL -> bindParam(':id',$id);
        $sentenciaSQL -> execute();
        echo json_encode(["success"=>1]);
        exit();
    }


    $sentenciaSQL = $conexion -> prepare("SELECT * FROM mochilas");
    $sentenciaSQL -> execute();
    $listaMochilas = $sentenciaSQL -> fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($listaMochilas);
?>