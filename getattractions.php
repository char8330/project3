<html>
<head>
</head>
</html>

<?php
 
    for($i = 0; $i < $size2; $i++) {
        echo($json_list[$i]['eid']);
        echo ', ';
        echo($json_list[$i]['shortname']);
        echo ', ';
        $link_address = "viewattraction/".$json_list[$i]['eid']."/".$json_list[$i]['attractionid'];
        echo "<a href='".$link_address."'>".$json_list[$i]['name']."</a>";
        echo ', ';
        echo 'state: ' . $json_list[$i]['state'];
       // echo 'EID: ' . $json_list[$i]['nameShort'];
        //echo '<br>';
        //echo 'Status: ' . $json_view[$i]['status'];
        
       // echo '<br><br>';
        
        
        echo '<br><br><br>';
    }
?>

