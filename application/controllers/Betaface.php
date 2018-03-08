<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define("DEFAULT_API_KEY", 'd45fd466-51e2-4701-8da8-04351c872236');
define("DEFAULT_API_SECRET", '171e8465-f548-401d-b63b-caf0dc28df5f');
define("DEFAULT_API_URL",'http://www.betafaceapi.com/service_json.svc/');
define("DEFAULT_POLL_INTERVAL",1);

class Betaface extends CI_Controller {
    
        function __construct() {
            parent::__construct();
            $this->load->model('betaface_model');
        }

	
	public function index()
	{
            $pass_arr = array();
            $person_arr = $this->betaface_model->get_persons();
            $pass_arr['persons'] = $person_arr;
            $this->load->view('includes/header');
	    $this->load->view('index',$pass_arr);
            $this->load->view('includes/footer');
	}
        
        public function upload()
        {
            if(isset($_POST['submit']) && isset($_POST['name']) && $_POST['name'] != '')
	    {
		$name  = $_POST['name'];
		$file = $_FILES['image']['name'];
		$data = file_get_contents($_FILES['image']['tmp_name']);
                $base64_encoded_image = base64_encode($data);
		$result = $this->upload_image($file,$base64_encoded_image);
                
		$response_arr = json_decode($result,true);
                
                $insert_arr = array();
                $insert_arr['name'] = $name;
                
                if($response_arr['string_response'] == 'ok')
                {
                    $img_uid = $response_arr['img_uid'];
                    $check_img_uid = $this->betaface_model->get_img_uid($img_uid);
                    if($check_img_uid)
                    {
                    if(move_uploaded_file($_FILES['image']['tmp_name'], './assets/images/persons/'.$_FILES['image']['name']))
                    {
                        $insert_arr['img_uid'] = $img_uid;
                        $insert_arr['photo'] = $file;
                        $image_info_res_json_arr = $this->get_image_info($img_uid);
                        sleep(3);
                        $image_info_res_json_arr = $this->get_image_info($img_uid);
                        
                        $image_info_arr = json_decode($image_info_res_json_arr,true);
                        if($image_info_arr['string_response'] == 'ok')
                        {
                            $face_uid = $image_info_arr['faces'][0]['uid'];
                            $insert_arr['face_uid'] = $face_uid;
                            $person_id = $name.'@nxpert.com';
                            $set_person_res_json_arr = $this->set_person($face_uid,$person_id);
                            $set_person_arr = json_decode($set_person_res_json_arr,true);
                            
                            if($set_person_arr['string_response'] == 'ok')
                            {
                                $insert_arr['i_date'] = time();
                                $insert_arr['u_date'] = time();
                                if($this->betaface_model->insert($insert_arr))
                                {
                                    $this->session->set_flashdata('_success', 'Person Added Successfully');
		                    $this->load->view('show_status_messages_view');
		                    redirect('betaface/index');
                                }else{
                                    
                                    echo "Person Not insert into local database";
                                    exit;
                                }
                               
                            }
                            
                        }else{
                            
                            $this->session->set_flashdata('_error', 'Image Info Not Found');
		            $this->load->view('show_status_messages_view');
		            redirect('betaface/index');
                            
                        }
                        
                    }else{
                        
                        $this->session->set_flashdata('_error', 'file not uploaded successfully');
		        $this->load->view('show_status_messages_view');
		        redirect('betaface/index');
                       
                    }
                    
                }else{
                    
                    $this->session->set_flashdata('_error', 'This Photo is Already Uploaded Please try another');
		    $this->load->view('show_status_messages_view');
		    redirect('betaface/index');
                   
                }
                }else{
                    $this->session->set_flashdata('_error', 'Photo Not Uploaded');
		    $this->load->view('show_status_messages_view');
		    redirect('betaface/search');
                    
                }
                
		
            }else{
                
                $this->load->view('includes/header');
                $this->load->view('image_upload');
                $this->load->view('includes/footer');
                
            }
           
        }
        
        public function search()
        {
            $pass_arr = array();
            if(isset($_FILES['search_image']))
	    {
		$file = $_FILES['search_image']['name'];
		$data = file_get_contents($_FILES['search_image']['tmp_name']);
                //$name  = $_POST['name'];
                
                $base64_encoded_image = base64_encode($data);
		$result = $this->upload_image($file,$base64_encoded_image);
		$response_arr = json_decode($result,true);
                
                $insert_arr = array();
                //$insert_arr['name'] = $name;
                
                if($response_arr['string_response'] == 'ok')
                {
                    if(move_uploaded_file($_FILES['search_image']['tmp_name'],'./assets/images/persons/'.$_FILES['search_image']['name']))
                    {
                        $img_uid = $response_arr['img_uid'];
                        $insert_arr['img_uid'] = $img_uid;
                        $insert_arr['photo'] = $file;
                        $image_info_res_json_arr = $this->get_image_info($img_uid);
                        sleep(3);
                        $image_info_res_json_arr = $this->get_image_info($img_uid);
//                        echo "<pre>";
//                        print_r($image_info_res_json_arr);
//                        exit;
                        $image_info_arr = json_decode($image_info_res_json_arr,true);
                        if($image_info_arr['string_response'] == 'ok')
                        {
                            $face_uid = $image_info_arr['faces'][0]['uid'];
                            $insert_arr['face_uid'] = $face_uid;
                            //$person_id = $name.'@nxpert.com';
                            //$set_person_res_json_arr = $this->set_person($face_uid,$person_id);
                            //$set_person_arr = json_decode($set_person_res_json_arr,true);
                            
                            //if($set_person_arr['string_response'] == 'ok')
                            //{
                                $insert_arr['i_date'] = time();
                                $insert_arr['u_date'] = time();
                                //$check_img_uid = $this->betaface_model->get_img_uid($img_uid);
                                //if($check_img_uid)
                                //{
                                   // $this->betaface_model->insert($insert_arr);
                                //}
                                //if($this->betaface_model->insert($insert_arr))
                               // {
                                    $rec_res_json_arr = $this->recognize_faces($face_uid);
                                    $rec_faces_arr = json_decode($rec_res_json_arr,true);
                                    $recognize_uid = $rec_faces_arr['recognize_uid'];
                                    $rec_res_json_arr = $this->recognize_result($recognize_uid);
                                    sleep(3);
                                    $rec_res_json_arr = $this->recognize_result($recognize_uid);
//                                    echo "<pre>";
//                                    print_r($rec_res_json_arr);
//                                    exit;
                                    $rec_res_arr = json_decode($rec_res_json_arr,true);
                                    
                                    //$pass_arr['search_person'] = $name;
                                    $pass_arr['search_photo'] = $file;
                                    $pass_arr['persons'] = $rec_res_arr;
                                    //$this->session->set_flashdata('_success', 'Person Added Successfully');
		                    //$this->load->view('search_result',$pass_arr);
                                    $this->session->set_userdata("pass_arr",$pass_arr);
		                    redirect('betaface/search_result/');
//                                }else{
//                                    
//                                    echo "Person Not insert into local database";
//                                    exit;
//                                }
                               
                           // }
                            
                        }else{
                            
                            $this->session->set_flashdata('_error', 'Image Info Not Found');
		            $this->load->view('show_status_messages_view');
		            redirect('betaface/index');
                            
                        }
                        
                    }else{
                        
                        $this->session->set_flashdata('_error', 'file not uploaded successfully');
		        $this->load->view('show_status_messages_view');
		        redirect('betaface/index');
                       
                    }
                    
                }else{
                    
                    $this->session->set_flashdata('_error', 'Photo Not Uploaded');
		    $this->load->view('show_status_messages_view');
		    redirect('betaface/index');
                   
                }
	    }
            $this->load->view('includes/header');
            $this->load->view('search');
            $this->load->view('includes/footer');
        }
        
        public function search_result()
        {
            $pass_arr['persons'] = $this->session->userdata('pass_arr');
            //echo "<pre>";
            //print_r($pass_arr);
            //exit;
            $this->load->view('includes/header');
            $this->load->view('search_result',$pass_arr);
            $this->load->view('includes/footer');
        }
        public function upload_new_image_url($file)
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
	
	public function upload_image($file,$image_encoded)
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
	
	public function get_image_info($img_uid)
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
	
	public function set_person($face_uid,$person_id)
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
	
	public function recognize_faces($face_uid)
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
	public function recognize_result($recognize_uid)
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
        
        
        public function search_new($img_uid)
        {
            echo $img_uid;
             $image_info_res_json_arr = $this->get_image_info($img_uid);
                        
            $image_info_arr = json_decode($image_info_res_json_arr,true);
            echo "<pre>";
            print_r($image_info_res_json_arr);
            exit;
           
        }
}


