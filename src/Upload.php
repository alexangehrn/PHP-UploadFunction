<?php
class Upload {
	private $fileName;
	private $fileTmpName;
	private $fileSize;
	private $fileMaxSize;
	private $fileType;
	private $fileFolder;
	private $fileCode;
	private $rectHeight;
	private $rectWidth;
	private $squareDim;
	private $fileShape;
	private $fileCropPosition;
	private $fileExtension;
	private $fileAllExtension;
	private $fileAdress;
	private $fileCustomName;
	public  $log = "";

	public function __construct($name,$tmpname,$size,$maxsize,$type,$folder,$rectHeight,$rectWidth,$squareDim,$fileShape,$fileCropPosition,$fileAllExtension,$fileCustomName){
		$this->fileName = $name;
		$this->fileTmpName = $tmpname;
		$this->fileSize = $size;
		$this->fileType = $type;
		$this->fileCode = md5(uniqid(mt_rand()));
		$this->rectHeight = $rectHeight;
		$this->rectWidth = $rectWidth;
		$this->squareDim = $squareDim;
		$this->fileShape = $fileShape;
		$this->fileCropPosition = $fileCropPosition;
		$this->fileExtension = strtolower( substr( strrchr($this->fileName, '.') ,1));
		$this->fileCustomName = $fileCustomName;

		if($maxsize != NULL){
			$this->fileMaxSize = $maxsize;
		}else{
			throw new InvalidArgumentException("Taille Maximale non renseignée !");
		}

		if($folder != NULL){
			$this->fileFolder = $folder;
		}else{
			throw new InvalidArgumentException("Dossier de destination non renseigné !");
		}

		if($fileAllExtension != NULL){
			$this->fileAllExtension = $fileAllExtension;
		}else{
			throw new InvalidArgumentException("Extensions non renseignées !");
		}

		$this->fileAdress = self::_fileAdress();
		$this->log .= " Le renommage a été correctement effectué<br/>";

		if (!self::_checkExtension())
		{
			throw new InvalidArgumentException("Extension invalide !");
		}

		if (!self::_checkSize())
		{
			throw new InvalidArgumentException("Poid du fichier invalide !");
		}
		if (!move_uploaded_file($this->fileTmpName, $this->fileAdress)){
			throw new InvalidArgumentException("Problème de upload !");
		}
		else{
			$this->log = "Le fichier à été correctement enregistré dans le dossier " . $folder . "<br/>";

			if (self::_isImage())
			{
				$this->resizeImage();
			}
		}

	}


	private function _fileAdress(){


		if(!empty($this->fileCustomName)){
			return $adresse = $this->fileFolder."/".$this->fileCustomName.".".$this->fileExtension;
		}
		else
		{
			return $adresse = $this->fileFolder."/".$this->fileCode.".".$this->fileExtension;
		}
	}

	private function _checkExtension(){

		if (!empty($this->fileAllExtension)) {
			$allExtension = explode(",", $this->fileAllExtension);

			if(in_array($this->fileExtension, $allExtension)){
				return true;
			}
			else{
				return false;
			}
		}

	}

	private function _checkSize(){

		if($this->fileMaxSize > $this->fileSize){
			return true;
		}
		else{
			return false;
		}
	}

	private function _isImage(){
		$imgExt = array('png', 'jpeg', 'gif', 'svg', 'jpg');

		if(in_array($this->fileExtension, $imgExt)){
			return true;
		}
		else{
			return false;
		}
	}

	public function getLogs(){

		return $this->log;

	}

	private function resizeImage(){


		if (!self::_isImage()) {
			throw new Exception("Error Processing Request", 1);
		}

		else
		{

			switch ($this->fileExtension) {
				case 'jpg';
				case 'jpeg';
				$extension_upload = "jpeg";
				break;
				case 'png':
				$extension_upload = "png";
				break;
				case 'gif':
					$extension_upload = "gif";
					break;
					case 'svg':
					$extension_upload = "svg";
					break;
				}

				$image_fonction = "ImageCreateFrom" . $extension_upload;

				$image = $image_fonction($this->fileAdress);

				$width = imagesx($image);
				$height = imagesy($image);


				if ($this->fileShape == "rectangle" ) {

					if(!empty($this->rectWidth) || !empty($this->rectHeight)){

						$image = $image_fonction($this->fileAdress);
						$width = imagesx($image);
						$height = imagesy($image);

						if($width>$height)
						{
							//format horizontal
							if($this->rectWidth != NULL){
								$new_width = $this->rectWidth;
							}else{
								$new_width = $width;
							}
							$new_height = ($new_width * $height) / $width ;
						}
						else
						{
							// format vertical
							if($this->rectHeight != NULL){
								$new_height = $this->rectHeight;
							}else{
								$new_height = $height;
							}
							$new_width = ($new_height * $width) / $height;
						}


						$thumb = imagecreatetruecolor($new_width,$new_height);
						imagecopyresized($thumb, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
						$format = 'Image' . $extension_upload;
						$format($thumb, $this->fileAdress);
						//chmod ("uploaded/".$adresse."jpg", 0644);
						imagedestroy($image);

						$this->log .= " L'image à été correctement redimensionnée au format rectangle<br/>";

					}
				}
				else if($this->fileShape == "carre"){

					if($this->squareDim){

						$new_width = $this->squareDim;
						$new_height = $this->squareDim;

					}
					else{

						$new_width = $width;
						$new_height = $height;

					}

					$resize = imagecreatetruecolor($new_width,$new_height);

					if($width<$height)
					{

						if($this->fileCropPosition == 'centre2'){
							imagecopyresized($resize, $image, 0, 0, 0, (($new_height-$new_width)/2), $new_width, $new_height, $width, $height);
						}
						else if($this->fileCropPosition == 'haut'){
							imagecopyresized($resize, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
						}
						else if($this->fileCropPosition == 'bas'){
							imagecopyresized($resize, $image, 0, 0, 0, ($new_height-$new_width), $new_width, $new_height, $width, $height);
						}

					}
					else
					{

						if($this->fileCropPosition == 'centre'){
							imagecopyresized($resize, $image, (($new_height-$new_width)/2), 0, 0, 0, $new_width, $new_height, $width, $height);
						}
						else if($this->fileCropPosition == 'gauche'){
							imagecopyresized($resize, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
						}
						else if($this->fileCropPosition == 'droite'){
							imagecopyresized($resize, $image, ($new_height-$new_width), 0, 0, 0, $new_width, $new_height, $width, $height);
						}
					}

					$resize= imagecreatetruecolor($new_width,$new_height);
					imagecopyresized($resize, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
					$format = 'Image' . $extension_upload;
					$format($resize, $this->fileAdress);

					imagedestroy($image);

					$this->log .= " L'image à été correctement redimensionnée au format carré<br/>";

				}
			}
		}
	}

	?>
