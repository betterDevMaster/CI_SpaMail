<?php  
	Class My_multUpload extends CI_Model{
		public function do_upload($path, $inputName){


			// Count # of uploaded files in array

		
				if(!empty($_FILES[$inputName]['name'][0])){
					$total = count($_FILES[$inputName]['name']);

					// Loop through each file
					for($i=0; $i<$total; $i++) {
						$ext = pathinfo($_FILES[$inputName]['name'][$i] , PATHINFO_EXTENSION);
						$newName = $this->randomString().".$ext";
						$orig_name[$i] = $_FILES[$inputName]['name'][$i];
						$_FILES[$inputName]['name'][$i]= $newName;
					
			
						//Get the temp file path
						$tmpFilePath = $_FILES[$inputName]['tmp_name'][$i];

						//Make sure we have a filepath
						if ($tmpFilePath != ""){
							//Setup our new file path
							$newFilePath = $path .'/'. $_FILES[$inputName]['name'][$i];
							
							//Upload the file into the temp dir
							if(move_uploaded_file($tmpFilePath, $newFilePath)) {
								
							//Handle other code here

							}
						}	
					}
					$file['uploaded'] = $_FILES[$inputName];
					$file['original_name']=$orig_name;					
					return $file;
				}
				else{
				
					return null;
				}
				
			
			
		}
		
		public function randomString($length = 15) {
			$str = "";
			$characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
			$max = count($characters) - 1;
			for ($i = 0; $i < $length; $i++) {
				$rand = mt_rand(0, $max);
				$str .= $characters[$rand];
			}
			return $str;
		}
	}
?>
