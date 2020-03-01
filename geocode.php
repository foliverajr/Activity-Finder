<?php
function geocode($address){

    $address = urlencode($address);
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyDAKlSsp_FMrFds0Iijd_BO3BQtpypjEHc";
 
    $resp_json = file_get_contents($url);
     
    $resp = json_decode($resp_json, true);
	
    if($resp['status']=='OK'){
 
        $lati = isset($resp['results'][0]['geometry']['location']['lat']) ? $resp['results'][0]['geometry']['location']['lat'] : "";
        $longi = isset($resp['results'][0]['geometry']['location']['lng']) ? $resp['results'][0]['geometry']['location']['lng'] : "";
        $formatted_address = isset($resp['results'][0]['formatted_address']) ? $resp['results'][0]['formatted_address'] : "";
         
        if($lati && $longi && $formatted_address){
         
            $data_arr = array();            
             
            array_push(
					$data_arr, 
                    $lati, 
                    $longi, 
                    $formatted_address
                );
             
            return $data_arr;
             
        }else{
            return false;
        }
         
    }
 
    else{
        echo "<strong>ERROR: {$resp['status']}</strong>";
        return false;
    }
}
?>