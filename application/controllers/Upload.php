<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {

	public function __construct()
	{		
		parent::__construct();				
	}


	public function index()
	{
		$this->load->view('form');
	}


	function saveGambar()
    {
     		
		$data = array ('success' => false, 'messages'=> array());	
		$config['file_name'] 	= random_string('numeric',3);
        $config['upload_path'] 	= './assets/sample/';  
        $config['max_size']     = 2000;
        $config['allowed_types']= 'gif|jpeg|jpg|png';   
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);  
        if(!$this->upload->do_upload('gambar'))  
        {	        	

        	foreach($_FILES as $key => $value) 
			{
				$data['messages'][$key] = strip_tags($this->upload->display_errors());
			}	
        }  
        else  
        {
             $data['success'] = true;   
        	 $path = base_url().'assets/sample/'.$this->upload->data('file_name');      		
        	 $upload = array ('upload_id' => random_string('numeric',5),
        					  'upload_path'=>$path);
        	 // proses insert database
             //$this->mdata->insert_all('upload_tb',$upload);				
		}
		echo json_encode($data);	

	}
 
}