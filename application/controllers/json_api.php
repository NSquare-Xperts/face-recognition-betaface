<?php
define("DEFAULT_API_KEY", 'd45fd466-51e2-4701-8da8-04351c872236');
define("DEFAULT_API_SECRET", '171e8465-f548-401d-b63b-caf0dc28df5f');
define("DEFAULT_API_URL",'http://www.betafaceapi.com/service_json.svc/');
define("DEFAULT_POLL_INTERVAL",1);
/* echo "<pre>";
		print_r($_FILES);
		exit; */
class betaFaceApi
{
	function upload_new_image_url($file)
	{
		/* echo "http://" . $_SERVER['SERVER_NAME'] .'/'.$file ;
		exit; */
		//$file = "http://" . $_SERVER['SERVER_NAME'] .'/'.$file ;
		$image_raw = file_get_contents($file);
		$image_encoded = base64_encode($image_raw);

		$request_arr = array();
		$request_arr['api_key'] = DEFAULT_API_KEY;
		$request_arr['api_secret'] = DEFAULT_API_SECRET;
		$request_arr['detection_flags'] = 0;
		$request_arr['imagefile_data'] = $image_encoded;
		$request_arr['original_filename'] = $file;

		$request_arr = json_encode($request_arr);
		
		/* echo "<pre>";
		print_r($request_arr);
		exit; */

		$url = DEFAULT_API_URL.'UploadNewImage_Url';
		$headers[] = "Content-Type: application/json";
		
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$request_arr);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		
		return $result;
				
	}
	
	function upload_image($file,$image_encoded)
	{
		/* $image_raw = file_get_contents($file);
		$image_encoded = base64_encode($image_raw); */

		$request_arr = array();
		$request_arr['api_key'] = DEFAULT_API_KEY;
		$request_arr['api_secret'] = DEFAULT_API_SECRET;
		$request_arr['detection_flags'] = 0;
		$request_arr['image_base64'] = $image_encoded;
		$request_arr['original_filename'] = $file;

		$request_arr = json_encode($request_arr);
		
		/* echo "<pre>";
		print_r($request_arr);
		exit; */

		$url = DEFAULT_API_URL.'UploadImage';
		$headers[] = "Content-Type: application/json";
		
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$request_arr);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		
		return $result;
	}
	
	function get_image_info($img_uid)
	{
		$request_arr = array();
		$request_arr['api_key'] = DEFAULT_API_KEY;
		$request_arr['api_secret'] = DEFAULT_API_SECRET;
		$request_arr['img_uid'] = $img_uid;
		
		$request_arr = json_encode($request_arr);
		
		/* echo "<pre>";
		print_r($request_arr);
		exit; */

		$url = DEFAULT_API_URL.'GetImageInfo';
		$headers[] = "Content-Type: application/json";
		
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$request_arr);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		
		return $result;
		
	}
	
	function set_person($face_uid,$person_id)
	{
		$request_arr = array();
		$request_arr['api_key'] = DEFAULT_API_KEY;
		$request_arr['api_secret'] = DEFAULT_API_SECRET;
		$request_arr['faces_uids'] = $face_uid;
		$request_arr['person_id'] = $person_id;
		
		
		$request_arr = json_encode($request_arr);
		
		/* echo "<pre>";
		print_r($request_arr);
		exit; */

		$url = DEFAULT_API_URL.'SetPerson';
		$headers[] = "Content-Type: application/json";
		
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$request_arr);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		
		return $result;
		
	}
	
	function recognize_faces($face_uid)
	{
		//echo $face_uid;
		
		$request_arr = array();
		$request_arr['api_key'] = DEFAULT_API_KEY;
		$request_arr['api_secret'] = DEFAULT_API_SECRET;
		//$request_arr['faces_uids'] = '0d375bfb-1194-11e8-867b-0cc47a6c4dbd';
		$request_arr['faces_uids'] = $face_uid;
		$request_arr['targets'] = 'all@nxpert.com';
		
		
		
		$request_arr = json_encode($request_arr);
		
		

		$url = DEFAULT_API_URL.'RecognizeFaces';
		$headers[] = "Content-Type: application/json";
		
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$request_arr);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		 
		return $result;
		
	}
	function recognize_result($recognize_uid)
	{
		$request_arr = array();
		$request_arr['api_key'] = DEFAULT_API_KEY;
		$request_arr['api_secret'] = DEFAULT_API_SECRET;
		$request_arr['recognize_uid'] = $recognize_uid;
		
		$request_arr = json_encode($request_arr);
		
		/* echo "<pre>";
		print_r($request_arr);
		exit; */

		$url = DEFAULT_API_URL.'GetRecognizeResult';
		$headers[] = "Content-Type: application/json";
		
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$request_arr);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		
		return $result;
		
	}
}
    
	if(isset($_POST['submit']) && isset($_POST['name']) && $_POST['name'] != '')
	{
		$name  = $_POST['name'];
		/* echo "<pre>";
		print_r($_FILES);
		exit; */
		$file = $_FILES['image']['name'];
		$data = file_get_contents($_FILES['image']['tmp_name']);
                $base64_encoded_image = base64_encode($data);
		$betaFaceApi = new betaFaceApi();
		$result = $betaFaceApi->upload_image($file,$base64_encoded_image);
		$response_arr = json_decode($result,true);
		$img_uid = $response_arr['img_uid'];
		$image_info_res_json_arr = $betaFaceApi->get_image_info($img_uid);
		$image_info_arr = json_decode($image_info_res_json_arr,true);
		$face_uid = $image_info_arr['faces'][0]['uid'];
		$person_id = $name.'@nxpert.com';
		$result = $betaFaceApi->set_person($face_uid,$person_id);
		
	}
	
	if(isset($_FILES['search_image']))
	{
		//echo "shailesh";
		//exit;
		$file = $_FILES['search_image']['name'];
		$data = file_get_contents($_FILES['search_image']['tmp_name']);
                 $base64_encoded_image = base64_encode($data);
		$betaFaceApi = new betaFaceApi();
		$result = $betaFaceApi->upload_image($file,$base64_encoded_image);
		$response_arr = json_decode($result,true);
		$img_uid = $response_arr['img_uid'];
		$image_info_res_json_arr = $betaFaceApi->get_image_info($img_uid);
		$image_info_arr = json_decode($image_info_res_json_arr,true);
		$face_uid = $image_info_arr['faces'][0]['uid'];
	        $rec_res_json_arr = $betaFaceApi->recognize_faces($face_uid);
		$rec_faces_arr = json_decode($rec_res_json_arr,true);
		$recognize_uid = $rec_faces_arr['recognize_uid'];
		$rec_res_json_arr = $betaFaceApi->recognize_result($recognize_uid);
		$rec_res_arr = json_decode($rec_res_json_arr,true);
		
		if(!empty($rec_res_arr))
		{
			if(!empty($rec_res_arr['faces_matches']))
			{
				echo  '<table>
				<tr>
				<th style="width:184px;">Person Name</th>
				<th>Confidance</th>
				</tr>';
				foreach($rec_res_arr['faces_matches'][0]['matches'] as $person)
				{
					echo  '<tr>
					            <td >'.$person['person_name'].'</td>
					            <td>'.$person['confidence'].'</td>  
					        </tr>';
				}
				
				
			}else{
				
				echo 'No Match Found';
			}
		}
	}
	
	
	//$result = $betaFaceApi->upload_new_image('obama_normal.jpg');
	 //$result = $betaFaceApi->upload_image('shailesh2.jpg');
	//$result = $betaFaceApi->get_image_info('bb9623c8-7ec9-4127-8ffb-541ef586bcbf');
	//$result = $betaFaceApi->set_person();
	//$result = $betaFaceApi->recognize_faces();
	//$result = $betaFaceApi->recognize_result();
	 echo "<pre>";
		print_r($result);
		exit;  
	

?>