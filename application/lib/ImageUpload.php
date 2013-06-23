<?PHP if (!defined('__SITE_PATH')) exit('No direct script access allowed');

/**
* OpenPhpCms
*
* An open CMS for PHP/MYSQL
*
* @author       Maikel Martens
* @copyright    Copyright (c) 20013 - 2013, openphpcms.org.
* @license      http://openphpcms.org/license.html
* @link         http://openphpcms.org
* @since        Version 1.0
*/
// ------------------------------------------------------------------------

/**
* Image Upload class
*
* Upload en resize image
*
* @package      OpenPhpCms
* @subpackage   Core
* @category     Core
* @author       Maikel Martens
*/
// ------------------------------------------------------------------------
class ImageUpload {
	/* @var String contains directory where the image should be uploaded.*/
	private $uploadDirectory;

	/* @var array contains arrays with the information about the ìmage. */
	private $uploadedImage;

	/* @var int contains maximum width of image */
	private $maximumWidth;

	/* @var int contains maximum height of image */
    private $maximumHeight;

    /* @var int contains thumbnail Dimension*/
    private $thumbnailDimension;

    /* @var string contains the name of the uploaded image */
    private $imageFileName;

    /* @var array contains error messages */
    private $errorMessages = array();


    function __construct($image = ''){
    	$this->uploadDirectory 		= __SITE_PATH.'/data/images';
    	$this->maximumWidth 		= 900;
    	$this->maximumHeight 		= 900;
    	$this->thumbnailDimension 	= 200;
    	$this->uploadedImage		= $image;
    	lang()->addSystemLangFile('ImageUpload');
    }

    /**
    * validate
    *
    * Validate if uploaded file is an image. 
    *
    * @access private
    * @return boolean
    */
    private function validate(){
		$valid_mime_types = array(
    		"image/png",
    		"image/jpeg",
    		"image/pjpeg",
		);

		if(!in_array($this->uploadedImage['type'], $valid_mime_types)) {
			$errorMessages[] = lang()->get('image_upload_not_valid');
			return false;
		}
		return true;
    }

    /**
    * getFileName
    *
    * Returns a filename that is not in use. 
    *
    * @access private
    * @return String
    */
    private function getFileName(){
    	$x = explode('.', $this->uploadedImage['name']);
    	unset($x[count($x)-1]);
    	$name = implode('.', $x);
    	
    	$file = $this->uploadDirectory.'/'.$name.'.png';
    	$rand= "";
    	
    	while (file_exists($file)) {
 			$rand = random_string(6);
 			$file = $this->uploadDirectory.'/'.$name.$rand.'.png';
    	}
    	return ($rand != "" ? $name.$rand : $name).'.png';
    }

    /**
    * upload
    *
    * Resize and save image and thumbnail.
    *
    * @access public
    * @return boolean
    */
    public function upload(){
    	if(!$this->validate())
    		return false;
    	
    	// Get new sizes
		list($width, $height) = getimagesize($this->uploadedImage['tmp_name']);
		$newwidth = $width;
		$newheight = $height;
		if($width > $height && $width > $this->maximumWidth) {
			$percentage = $this->maximumWidth / $width;
			$newwidth 	= $this->maximumWidth;
			$newheight 	= $height * $percentage;
		} else if($height > $width && $height->maximumHeight) {
			$percentage	= $this->maximumHeight / $height;
			$newheight 	= $this->maximumHeight;
			$newwidth 	= $height * $percentage;
		}

		//get thumb size
		$percentage = $this->thumbnailDimension / $width;
		$thumbWidth	= $this->thumbnailDimension;
		$thumbHeight = $height * $percentage;

		$image = imagecreatetruecolor($newwidth, $newheight);
		$thumb = imagecreatetruecolor($thumbWidth, $thumbHeight);

		if($this->uploadedImage['type'] == "image/png")
			$source = imagecreatefrompng($this->uploadedImage['tmp_name']);
		else 
			$source = imagecreatefromjpeg($this->uploadedImage['tmp_name']);

		imagecopyresized($image, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		imagecopyresized($thumb, $source, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);

		$this->imageFileName = $this->getFileName();

		imagepng($image, $this->uploadDirectory."/".$this->imageFileName, 9);
		imagepng($thumb, $this->uploadDirectory."/thumbnails/".$this->imageFileName, 9);

		return true;
    }

    /**
    * getImageName
    *
    * Get the image name.
    *
    * @access public
    * @return String
    */
    public function getImageName(){
    	return $this->imageFileName;
    }
}