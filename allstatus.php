<html>
<head>
<style>
    .red {color: red;}
    .yellow {color: yellow;}
    .green {color: green;}
</style>
</head>
</html>

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
        
        if($json_view[$i]['status'] === 'open') {
            echo '<p class=green>' . 'Status: ' . $json_view[$i]['status'] . '</p>';
        }
        
        if($json_view[$i]['status'] === 'closed') {
            echo '<p class=red>' . 'Status: ' . $json_view[$i]['status'] . '</p>';
        }
        
        if($json_view[$i]['status'] === 'unresponsive') {
            echo '<p class=yellow>' . 'Status: ' . $json_view[$i]['status'] . '</p>';
        }
        
        //echo 'Status: ' . $json_view[$i]['status'];
        echo '<br><br>';
    }

?>