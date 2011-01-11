<?php 

// pr($supervisores);

$valores = NULL;

$valores = "<option value='0'>Selecione supervisor</option>";
if (isset($supervisores)) {
    foreach ($supervisores as $cada_supervisor) {
    $valores .= "<option value=". $cada_supervisor['id'] . ">" . $cada_supervisor['nome'] . "</option>";
    }
}

if ($valores) {
    echo $valores;
    } else {
    echo $valores .= "<option value=0>Não há supervisores cadastrados</option>";
}

exit();

?>
