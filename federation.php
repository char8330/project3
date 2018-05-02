<?php 


class Controller_Federation extends Controller
{

    public function action_attrimage($id){

    $picture = Model_Attractions::find('first', array('where' => array ('id' => $id)));
    return Asset::img($picture->img);
 
    //return Asset::get_file('/s/bach/k/under/char8330/public_html/ct310/assets/img/'.$picture->img, 'img');
    
    
    }
    public function action_attraction($id){
        if(DBUtil::table_exists('attractions')){
            $page= Model_Attractions::find('first', array('where' => array ('id' => $id)));
            $details = array('id'=>$page->id,'name'=>$page->name,'state'=>$page->state, 'descr'=>$page->description);

        
        }
         return Format::forge($details)->to_json();

     
    }
    public function action_listing(){
        if(DBUtil::table_exists('attractions')){
        
            $attractions = Model_Attractions::find('all'); // subject to change
            $listings = array();
            foreach($attractions as $attraction){
                $listings[] = array('id'=>$attraction->id,'name'=>$attraction->name,'state'=>$attraction->state); //, 'descr'=>$attraction->description);

            }

        }
        return Format::forge($listings)->to_json();
     
     }
     
     
    public function action_status(){
    
        $layout = View::forge('federation/layoutfull');
        $content = View::forge('federation/status');
        //$content = View::forge('southdakota/forgot');
        $data = array();
        $status = array('status'=> 'open');
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
    
            
            $layout = View::forge('federation/layoutfull');
            $content = View::forge('federation/allstatus');
            
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
                    try{$json[$i]['status'] = $json_status['status'];
                    }catch (Exception $e){ $json[$i]['status'] = 'unresponsive';}
                }
                
                else {
                    $json[$i]['status'] = 'unresponsive';
                }
                
                if($json[$i]['status'] == '') {
                    $json[$i]['status'] = 'unresponsive';
                }
                
                //echo '<pre>' . print_r($json[$i], true) . '</pre>';
                
                
            }
            
        
           
            $content->set_safe( 'json_view', $json); //give to view
            $content->set_safe('size', $size); //give json object list size
            return $content;
        }
        
                public function action_getattractionsnew(){
    //go to url page
    //extract fields
    
    //use eid to generate url where status is listed
    //extract status
    
            
            $layout = View::forge('federation/layoutfull');
            $content = View::forge('federation/getattractions');
            
            $curl = Request::forge('https://www.cs.colostate.edu/~ct310/yr2018sp/master.json', 'curl');
            $result=$curl->execute();
            $json = json_decode($result, true);
 
//             $test = 'http://www.cs.colostate.edu/~anthos/ct310/index.php/federation/status';
//             echo print_r(get_headers($test));
            
            
            

            $size = sizeof($json);  //TODO ADD ALL LATER 
            //echo $size;
            //$json_statuses = [];
            $json_listing = [];
            for($i = 0; $i < $size; $i++) {
                $eid_url = 'http://www.cs.colostate.edu/~'. $json[$i]['eid'] .'/ct310/index.php/federation/status';
                $sub_curl = Request::forge($eid_url, 'curl');
                $url_headers = get_headers($eid_url);
                
                if($url_headers[0] === 'HTTP/1.1 200 OK') { 
                    $sub_result = $sub_curl->execute();
                    
                    $json_status = json_decode($sub_result, true);
                    try{$json[$i]['status'] = $json_status['status'];
                    }catch (Exception $e){ $json[$i]['status'] = 'unresponsive';}
                }
                
                else {
                    $json[$i]['status'] = 'unresponsive';
                }
                
                if($json[$i]['status'] == '') {
                    $json[$i]['status'] = 'unresponsive';
                }
                
                //echo '<pre>' . print_r($json[$i], true) . '</pre>';

                
                
                $curl2 = Request::forge('https://www.cs.colostate.edu/~'. $json[$i]['eid'] .'/ct310/index.php/federation/listing', 'curl');
                $result2=$curl2->execute();
                $json2 = json_decode($result2, true);

                
                //array_push($json_listing,array("eid" => $json[$i]['eid'], "attractionData" => $json2));
                //array_push($json_listing,array("attractionData" => $json2,"eid" =>));
                //array_push($json_listing,array("attractionData" => $json2,"eid" => $json[$i]['eid']));
                //print_r($json_listing);
                //print_r($json2[0]);
                //$size2 = sizeof($json_listing); //DOES json2 hold all objects??? pick/ take from it? 
                //echo($size2);
                 $size3 = sizeof($json2);
                 for($j = 0; $j < $size3; $j++) {
                        array_push($json_listing,array("eid" => $json[$i]['eid'], "shortname" => $json[$i]['nameShort'],"name" => $json2[$j]['name'], "state" => $json2[$j]['state'],"attractionid" => $json2[$j]['id'] ));
                 
                 }
//                 //print_r($json_listing);
                
                
                
            }
            $size2 = sizeof($json_listing);
            $content->set_safe( 'json_list', $json_listing); //give to view
            $content->set_safe('size2', $size2); //give json object list size
                
            $content->set_safe( 'json_view', $json); //give to view
            $content->set_safe('size', $size); //give json object list size
            
            //print_r($json_listing);
            return $content;
        }
        
        public function action_getattractions(){
    //go to url page
    //extract fields
    
    //use eid to generate url where status is listed
    //extract status
    
            
            $layout = View::forge('federation/layoutfull');
            $content = View::forge('federation/getattractions');
            
            $curl = Request::forge('https://www.cs.colostate.edu/~ct310/yr2018sp/master.json', 'curl');
            $result=$curl->execute();
            $json = json_decode($result, true);
 
//             $test = 'http://www.cs.colostate.edu/~anthos/ct310/index.php/federation/status';
//             echo print_r(get_headers($test));
            
            
            

            $size = 15; sizeof($json);  //TODO ADD ALL LATER 
            //echo $size;
            //$json_statuses = [];
            $json_listing = [];
            for($i = 0; $i < $size; $i++) {
                $eid_url = 'http://www.cs.colostate.edu/~'. $json[$i]['eid'] .'/ct310/index.php/federation/status';
                $sub_curl = Request::forge($eid_url, 'curl');
                $url_headers = get_headers($eid_url);
                
                if($url_headers[0] === 'HTTP/1.1 200 OK') { 
                    $sub_result = $sub_curl->execute();
                    
                    $json_status = json_decode($sub_result, true);
                    try{$json[$i]['status'] = $json_status['status'];
                    }catch (Exception $e){ $json[$i]['status'] = 'unresponsive';}
                }
                
                else {
                    $json[$i]['status'] = 'unresponsive';
                }
                
                if($json[$i]['status'] == '') {
                    $json[$i]['status'] = 'unresponsive';
                }
                
                //echo '<pre>' . print_r($json[$i], true) . '</pre>';

                
                
                $curl2 = Request::forge('https://www.cs.colostate.edu/~'. $json[$i]['eid'] .'/ct310/index.php/federation/listing', 'curl');
                $result2=$curl2->execute();
                $json2 = json_decode($result2, true);

                
                //array_push($json_listing,array("eid" => $json[$i]['eid'], "attractionData" => $json2));
                //array_push($json_listing,array("attractionData" => $json2,"eid" =>));
                //array_push($json_listing,array("attractionData" => $json2,"eid" => $json[$i]['eid']));
                //print_r($json_listing);
                //print_r($json2[0]);
                //$size2 = sizeof($json_listing); //DOES json2 hold all objects??? pick/ take from it? 
                //echo($size2);
                 $size3 = sizeof($json2);
                 for($j = 0; $j < $size3; $j++) {
                        array_push($json_listing,array("eid" => $json[$i]['eid'], "shortname" => $json[$i]['nameShort'],"name" => $json2[$j]['name'], "state" => $json2[$j]['state'],"attractionid" => $json2[$j]['id'] ));
                 
                 }
//                 //print_r($json_listing);
                
                
                
            }
            $size2 = sizeof($json_listing);
            $content->set_safe( 'json_list', $json_listing); //give to view
            $content->set_safe('size2', $size2); //give json object list size
                
            $content->set_safe( 'json_view', $json); //give to view
            $content->set_safe('size', $size); //give json object list size
            
            //print_r($json_listing);
            return $content;
        }

        
        
        public function action_viewattraction($eid, $attraction){//eid / attraction # 
        
            $layout = View::forge('federation/layoutfull');
            $content = View::forge('federation/viewattraction');
        
            //DESCRIPTION//TODO TAKE name, desc, state from here + add in img/eid/shortname later 
            $curl3 = Request::forge('https://www.cs.colostate.edu/~'.$eid.'/ct310/index.php/federation/attraction/'.$attraction, 'curl');
            $result3=$curl3->execute();
            $json_attraction = json_decode($result3, true);
            $content->set_safe( 'json_att', $json_attraction); //give to view

            //IMAGE
             $json_image  = 'https://www.cs.colostate.edu/~'. $eid.'/ct310/index.php/federation/attrimage/'.$attraction;
            //$result4=$curl4->execute();
            //$json_image = json_decode($result4, true);
            $content->set_safe( 'json_img', $json_image); //give to view
            //print_r($json_image);
            //Image::load($json_image);
            
            return $content;
        
        }
        
    

}


