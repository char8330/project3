<?php
class Controller_Federation extends Controller_Posts {
	public function action_status() {
		$data = array();     
		$status = array('status' => 'closed');
		
		$this->template->title = 'Federation Page';
		$this->template->content = View::forge('federation/status', $data);
		
		return Format::forge($status)->to_json();
	}
	
// 	public function action_allstatus() {
//             $data = array();
//             
//             $this->template->title = 'All Federation Pages';
//             $this->template->content = View::forge('federation/allstatus', $data);
//             $this->template->content->set_safe('jsonFileVariableHowItLooksInView', $json);
// 
//             
// 	}
	
	public function action_allstatus(){
    //go to url page
    //extract fields
    
    //use eid to generate url where status is listed
    //extract status
            $curl = Request::forge('https://www.cs.colostate.edu/~ct310/yr2018sp/master.json', 'curl');
            $result=$curl->execute();
            $json = json_decode($result, true);
 
//             $test = 'http://www.cs.colostate.edu/~anthos/ct310/index.php/federation/status';
//             echo print_r(get_headers($test));
            
            
            
            
            
            
            
            $size = sizeof($json);
            //echo $size;
            //$json_statuses = [];

            for($i = 0; $i < $size; $i++) {
                $eid_url = 'http://www.cs.colostate.edu/~'. $json[$i]['eid'] .'/ct310/index.php/federation/status';
                $sub_curl = Request::forge($eid_url, 'curl');
                $url_headers = get_headers($eid_url);
                
                if($url_headers[0] === 'HTTP/1.1 200 OK') { 
                    $sub_result = $sub_curl->execute();
                    
                    $json_status = json_decode($sub_result, true);
                    $json[$i]['status'] = $json_status['status'];
                }
                
                else {
                    $json[$i]['status'] = 'unresponsive';
                }
                
                if($json[$i]['status'] == '') {
                    $json[$i]['status'] = 'unresponsive';
                }
                
                //echo '<pre>' . print_r($json[$i], true) . '</pre>';
                
                
            }
            
        
            $this->template->title = 'All Status';
            $this->template->content = View::forge('federation/allstatus');
            $this->template->content->set_safe( 'json_view', $json); //give to view
            $this->template->content->set_safe('size', $size); //give json object list size
        }
}
?>