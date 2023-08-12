<?php
require('../lib/fpdf/fpdf.php');
include_once('../config/bd.php');

$conexionDB = BD::crearInstancia();

function agregarTexto($pdf,$texto,$x,$y,$align='L',$fuente,$size=10,$r=0,$g=0,$b=0){
    $pdf -> SetFont($fuente,'',$size);
    $pdf -> SetXY($x,$y);
    $pdf -> SetTextColor($r,$g,$b);
    $pdf -> Cell(0,10,$texto,0,0,$align);
}

function agregarImagen($pdf,$imagen,$x,$y){
    $pdf -> Image($imagen,$x,$y,0);
}

$id_curso = isset($_GET['id_curso'])? $_GET['id_curso'] : '';
$id_alumno = isset($_GET['id_alumno'])? $_GET['id_alumno']: '';

$sql = "SELECT alumnos.nombre, alumnos.apellidos, cursos.nombre_curso
        FROM alumnos, cursos WHERE alumnos.id = :id_alumno AND cursos.id = :id_curso";
$sql = $conexionDB->prepare($sql);
$sql->bindParam(':id_alumno', $id_alumno);
$sql->bindParam(':id_curso', $id_curso);
$sql->execute();
$alumno = $sql->fetch(PDO::FETCH_ASSOC);


$pdf = new FPDF('L', 'mm',array(254,194));
$pdf -> AddPage();
$pdf -> SetFont('Arial','B',16);
agregarImagen($pdf,'../src/certificado_.jpg',0,0);
agregarTexto($pdf,ucwords(mb_convert_encoding($alumno['nombre']. ' ' . $alumno['apellidos'],'ISO-8859-1', 'UTF-8')),30,95,'C','Helvetica',30,0,84,115);
agregarTexto($pdf,$alumno['nombre_curso'],35,140,'C','Helvetica',20,0,84,115);
agregarTexto($pdf,date('d/m/Y'),110,160,'C','Helvetica',15,0,84,115);
$pdf -> Output();