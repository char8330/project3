<?php
 
    for($i = 0; $i < $size; $i++) {
        echo 'Team ' . $json_view[$i]['team'] . ':';
        echo '<br>';
        echo 'nameShort: ' . $json_view[$i]['nameShort'];
        echo '<br>';
        echo 'nameLong: ' . $json_view[$i]['nameLong'];
        echo '<br>';
        echo 'EID: ' . $json_view[$i]['eid'];
        echo '<br>';
        echo 'Status: ' . $json_view[$i]['status'];
        echo '<br><br>';
    }

?>