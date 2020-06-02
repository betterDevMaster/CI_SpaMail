<?php  
require_once './vendor/phpoffice/phpexcel/Classes/PHPExcel.php';
require_once './vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php';

	Class My_exelExtract extends CI_Model{
		private $data;
		public function extract($file){


			try {
			    $inputFileType = PHPExcel_IOFactory::identify($file);
			    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
			    $objPHPExcel = $objReader->load($file);
			} catch(Exception $e) {
			    die('Error loading file "'.pathinfo($file,PATHINFO_BASENAME).'": '.$e->getMessage());
			}

			//  Get worksheet dimensions
			$sheet = $objPHPExcel->getSheet(); 
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();
			$data = array();

			//  Loop through each row of the worksheet in turn
			for ($row = 1; $row <= $highestRow; $row++){ 
			    //  Read a row of data into an array
			    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
			                                    NULL,
			                                    TRUE,
			                                    FALSE);
			    //  Insert row data array into your database of choice here
			    array_push($data,$rowData);
			}
			 return $data;
			
			
		}
	}
			
			
?>
