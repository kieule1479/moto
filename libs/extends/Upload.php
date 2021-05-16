<?php

require_once PATH_SCRIPT . 'PhpThumb' . DS . 'ThumbLib.inc.php';

class Upload
{
	public function uploadFile($fileObj, $folderUpload, $width = 220, $height = 147, $options = null)
	{


		$fileName = [];
		if (!empty($fileObj['tmp_name'])) { // neu ton tai anh thi vao day
			if ($options == 'multi') {
				$length = count($fileObj['name']);

				for ($i = 0; $i < $length; $i++) {
					if ($fileObj['tmp_name'][$i] != null) {
						$uploadDir		= PATH_UPLOAD . $folderUpload . DS;
						$fileName[]		= $this->randomString(8) . '.' . pathinfo($fileObj['name'][$i], PATHINFO_EXTENSION);

						copy($fileObj['tmp_name'][$i], $uploadDir . $fileName[$i]);
						$thumb = PhpThumbFactory::create($uploadDir . $fileName[$i]);
						$thumb->adaptiveResize($width, $height);
						$prefix = $width . 'x' . $height . '-';
						$thumb->save($uploadDir . $prefix . $fileName[$i]);
					}
				}
			}
			
			if ($options == null) {

				$uploadDir		= PATH_UPLOAD . $folderUpload . DS;
				$fileName		= $this->randomString(8) . '.' . pathinfo($fileObj['name'], PATHINFO_EXTENSION);

				copy($fileObj['tmp_name'], $uploadDir . $fileName);
				$thumb = PhpThumbFactory::create($uploadDir . $fileName);
				$thumb->adaptiveResize($width, $height);
				$prefix = $width . 'x' . $height . '-';
				$thumb->save($uploadDir . $prefix . $fileName);
			}
		}


		return $fileName;
	}

	public function removeFile($folderUpload, $fileName)
	{
		

		$fileName	= PATH_UPLOAD . $folderUpload . DS . $fileName;
		unlink($fileName);
	}

	private function randomString($length = 5)
	{

		$arrCharacter = array_merge(range('a', 'z'), range(0, 9));
		$arrCharacter = implode('', $arrCharacter);
		$arrCharacter = str_shuffle($arrCharacter);
		$result		= substr($arrCharacter, 0, $length);
		return $result;
	}
}
