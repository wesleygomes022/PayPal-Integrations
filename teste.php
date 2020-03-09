<?php
$activate_postfields_array = array(
    0 => array(
        "op" => "replace",
        "path" => "/",
        "value" => array(
            "state" => "ACTIVE"
        )     
    )
);

echo json_encode($activate_postfields_array);

?>