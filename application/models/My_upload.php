<?php  
	Class My_upload extends CI_Model
	{
	 	public function do_upload($file, $path){

			$config['upload_path'] = $path;
			$config['allowed_types'] = 'gif|jpg|png|html|pdf';
			$config['max_size']	= '1000';
			$config['encrypt_name'] = TRUE;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$file =$file;
			if(!empty($file) || isset($file)){
				
			
				if ( ! $this->upload->do_upload($file))
				{
					$error = array('error' => $this->upload->display_errors());			
				}
				else
				{

					$data = $this->upload->data();
					
					return $data;				
				}
				
			}
		}
	}
?>
