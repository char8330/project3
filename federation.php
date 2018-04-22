<?php 


class Controller_Federation extends Controller
{

    public function action_status(){
        $data = array();
        $status = array('status'=> 'closed');
        $this->template->title = 'Federation Page';
        $this->template->content = View::forge('federation/status',$data);
        
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
 
 echo $json[0]['eid'];
        
        $this->template->title = 'All Status';
        $this->template->content = View::forge('federation/allstatus');
        $this->template->content->set_safe( 'json_view', $json); //give to view
        
        
        
    
}

}
