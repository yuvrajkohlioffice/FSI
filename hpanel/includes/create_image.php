<?php
//Start the session so we can store what the security code actually is
/*
session_start();
session_regenerate_id();
$sessname=session_name();
$sess_ID=session_id();

header("Set-Cookie: $sessname=$sess_ID; httpOnly");*/

$security_code=$_GET['scode'];

function create_image($security_code) 
{ 
//echo $security_code;
	
    //Set the image width and height 
    $width = 100; 
    $height = 25;  

    //Create the image resource 
    $image = ImageCreate($width, $height);  

    //We are making three colors, white, black and gray 
    $white = ImageColorAllocate($image, 255, 255, 255); 
    $black = ImageColorAllocate($image, 0, 10,10); 
    $grey = ImageColorAllocate($image, 204, 204, 204); 

    //Make the background black 
    ImageFill($image, 0,0, $black); 

    //Add randomly generated string in white to the image
    ImageString($image, 10, 23, 5, $security_code, $white); 

    //Throw in some lines to make it a little bit harder for any bots to break 
    ImageRectangle($image,0,0,$width-1,$height-1,$grey); 
    //imageline($image, 0, $height/2, $width, $height/2, $grey); 
    imageline($image, $width/2, 0, $width/3, $height, $grey);
	 //imageline($image, $width/5, 0, $width/3, $height, $grey);
	imageline($image, $width/4, 0, $width/2, $height, $grey);
	//imageline($image, $width/2, 0, $width/5, $height, $grey);
    //imageline($image, 0, $height/2, $width, $height/7, $grey);  
   //imageline($image, 0, $height/2, $width, $height/3, $grey); 

    //Tell the browser what kind of file is come in 
    header("Content-Type: image/jpeg"); 

    //Output the newly created image in jpeg format 
    ImageJpeg($image); 
    
    //Free up resources
    ImageDestroy($image);
	
	 
	 
} 

	create_image($security_code); 
	exit();


?>