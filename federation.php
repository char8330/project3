<?php 


class Controller_Federation extends Controller
{

    public function action_status(){
        $data = array();
        $status = array('status'=> 'closed');
        //$this->template->title = 'Federation Page';
        ///$this->template->content = View::forge('federation/status',$data);
        
        return Format::forge($status)->to_json();
        
        //$array = array ('status' => 'closed');
        //return Format::forge($array)->to_json();
        
    
    
    
    
    }
    public function action_allstatus(){
    //go to url page
    //extract fields
    
    //use eid to generate url where status is listed
    //extract status


    $curl = Request::forge('https://www.cs.colostate.edu/~ct310/yr2018sp/master.json', 'curl');
    $result=$curl->execute();
    $json = json_decode($result, true);


 
 
 //$json = json_decode($str, true); // decode the JSON into an associative array
 
    //echo '<pre>' . print_r($json, true) . '</pre>';
        $max = sizeof($json);
        echo $max;
        echo $json[0]['eid'];
        
        
        for($i=0; $i <$max;$i++){

            //echo $json[$i]['eid'];
            
            $url = 'https://www.cs.colostate.edu/~'.$json[$i]['eid'].'/ct310/index.php/federation/status';
            $curl2 = Request::forge($url, 'curl');
            $url_headers= get_headers($url);
            
            if($url_headers[0]==='HTTP/1.1 200 OK'){ //check if header is bad 
                 $result2=$curl2->execute();
                 $json_status= json_decode($result2, true);
                 //echo '<pre>' . print_r($json_status, true) . '</pre>';
                 $json[$i]['status'] = $json_status['status'];
            
            }else{$json[$i]['status'] = 'unresponsive'; } //broken 
            
            if($json[$i]['status'] == ''){$json[$i]['status'] = 'unresponsive';}
            

                echo '<pre>' . print_r($json[$i], true) . '</pre>';
            
            
            }
        
      
        
        //$this->template->title = 'All Status';
      //  $this->template->content = View::forge('federation/allstatus');
        //$this->template->content->set_safe( 'json_view', $json); //give to view
        
        
        
        
    
}

}
