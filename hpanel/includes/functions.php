<?php
if(session_status() === PHP_SESSION_NONE)
{
	session_start();
}

date_default_timezone_set('Asia/Kolkata');

function protect_session_id()
{
	ob_start();
	
	if(session_status() === PHP_SESSION_NONE)
	{
		session_start();
	}
	/*session_regenerate_id(); 

	$sessname=session_name();
	$sess_ID=session_id();

	header("Set-Cookie: $sessname=$sess_ID; httpOnly");*/
}

function generate_salted_key()
{
	$md5_pwdhash = md5(rand(1000,9999)); 

	$salted_code = substr($md5_pwdhash, 15, 6); 

	$_SESSION['salted_hash'] = $salted_code;
}

function generate_captcha()
{
	$md5_hash = md5(rand(0,999)); 
	$security_code = substr($md5_hash, 15, 6); 
	return $security_code;
}


function save_details($query, $execute)
{
	if($execute == "true")
	{
		$db_response = mysql_query($query);
		if($db_response)
			return 1;
		else
			return 0;
	}	
}
		
	
function get_timestamp()
{
	return strtotime(date("Y-m-d H:i:s"));
}

function filter_xss($data)
{
	// Fix &entity\n;
	$output = preg_replace('/[^a-zA-Z0-9 \/\-@._\:]/', '', trim($data));
	return $output;
	die();
	//$data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
	//$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
	//$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
	//$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
	
	//$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
	
	// Remove javascript: and vbscript: protocols
	//$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
	//$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
	//$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);
	
	// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
	//$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
	//$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
	//$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);
	
	// Remove namespaced elements (we do not need them)
	//$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);
	
	//do
	//{
		// Remove really unwanted tags
		//$old_data = $data;
		//$data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
	//}
	//while ($old_data !== $data);
	
	// we are done...
	//return $data;
}

function editor_xss($data)
{
    /*$string = $data;

    $output = preg_replace( "/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', $string );
    $output = strip_tags( $output , "<p><a><strong><table><tr><td>");
   
    return $output;*/
$val = $data;
$val = preg_replace('/([\x00-\x08][\x0b-\x0c][\x0e-\x20])/', '', $val);
   $search = 'abcdefghijklmnopqrstuvwxyz';
   $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
   $search .= '1234567890!@#$%^&*()';
   $search .= '~`";:?+/={}[]-_|\'\\';
   for ($i = 0; $i < strlen($search); $i++) {
      $val = preg_replace('/(&#[x|X]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
      $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
   }
   $ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
   $ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
   $ra = array_merge($ra1, $ra2);
   $found = true; 
   while ($found == true) {
      $val_before = $val;
      for ($i = 0; $i < sizeof($ra); $i++) {
         $pattern = '/';
         for ($j = 0; $j < strlen($ra[$i]); $j++) {
            if ($j > 0) {
               $pattern .= '(';
               $pattern .= '(&#[x|X]0{0,8}([9][a][b]);?)?';
               $pattern .= '|(&#0{0,8}([9][10][13]);?)?';
               $pattern .= ')?';
            }
            $pattern .= $ra[$i][$j];
         }
         $pattern .= '/i';
         $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2);
         $val = preg_replace($pattern, $replacement, $val);
         if ($val_before == $val) {
            $found = false;
         }
      }
   }
  return $val;
}

function sh_upload_file($sh_filename, $upload_type, $upload_path, $append_name, $max_size = 20)
{
	$default_size = $max_size * 1024 * 1024;  //in bytes
	
	$allowed_doc_mime_type   = array('application/msword', 'application/pdf', "application/zip", "application/x-zip", "application/x-zip-compressed");	
	$allowed_image_mime_type = array('image/gif', 'image/jpeg', 'image/png', 'image/bmp', 'image/png');
	
	$allowed_image_extension = array(".jpg", ".bmp", ".png", ".gif");
	$allowed_doc_extension   = array(".pdf", ".doc", ".docx", ".ppt", ".pptx", ".zip", ".xlx", ".xlsx", ".kml", ".csv");

	if(filter_xss($upload_type) == "image")
	{
		$sh_file = $upload_path . $_FILES[$sh_filename]['name'];		
		
		$original_extension = (false === $pos = strrpos($sh_file, '.')) ? '' : substr($sh_file, $pos);
		
		//$finfo = new finfo(FILEINFO_MIME);		
		//$type = $finfo->file($file);
		
		if($append_name)
		{
			$sh_file = $append_name."_".$_FILES[$sh_filename]['name'];
		}

		$sh_type = $_FILES[$sh_filename]['type'];		
		
		$sh_imageinfo = getimagesize($_FILES[$sh_filename]['tmp_name']);
		
		$sh_size = $_FILES[$sh_filename]['size'];
		
		$source = $_FILES[$sh_filename]['tmp_name'];
		
		$destination = $upload_path . $sh_file;
		
		if (in_array($sh_imageinfo['mime'], $allowed_image_mime_type ) && in_array($original_extension, $allowed_image_extension) && $sh_size <= $default_size)
		{
			if(move_uploaded_file($source, $destination))
			{
				return $sh_file;
			}
			else
			{
				return 0;		
			}
		}
		else
		{
			return 0;
		}
	}

	if(filter_xss($upload_type) == "file")
	{
		$sh_file            = $upload_path . $_FILES[$sh_filename]['name'];		
       		$error              = 0;
		$mimetype           = "";
		$original_extension = (false === $pos = strrpos($sh_file, '.')) ? '' : substr($sh_file, $pos);

   		if(count(explode(".", strtolower( $_FILES[$sh_filename]['name'] ))) > 2 )
   		{
	        	return 0;
        		$error = 1;
     		}
    		/*
		if (!(in_array(end(explode(".", strtolower($_FILES[$sh_filename]['name']))), $allowed_doc_extension)))
		{
	        	return 0;
	        	$error = 1;        	
	    	}
		*/

		if( !$error )
		{
			$source  = $_FILES[$sh_filename]['tmp_name'];
			
			$type    = $_FILES[$sh_filename]['type'];
			
			$sh_size = $_FILES[$sh_filename]['size'];
			
			if($append_name)
			{
				$sh_file = $append_name . "_" . $_FILES[$sh_filename]['name'];
			}
			
			if (function_exists('finfo_open')) 
			{
				$finfo     = finfo_open(FILEINFO_MIME);
				$mimetype  = finfo_file($finfo, $_FILES[$sh_filename]['tmp_name']);
				$mime_type = explode(";", $mimetype);

				finfo_close($finfo);
				$mimetype  = $mime_type[0];
			}

			if(
				!empty($_FILES[$sh_filename]['name']) &&
				($mimetype == "application/msword" || $mimetype == "application/pdf") &&
				($original_extension == ".pdf" || $original_extension == ".doc" || $original_extension == ".docx") &&
				$sh_size <= $default_size
			)
			{
				$upload_path .= $sh_file;
				
				return (move_uploaded_file($_FILES[$sh_filename]['tmp_name'], $upload_path)) ? $sh_file : 0;
			}
			else
			{
				return 0;
			}
		}
	}
	else
	{
		return 0;
	}
}

function sh_upload_file2($sh_filename, $upload_type, $upload_path, $append_name, $max_size = 20)
{
	
$default_size = $max_size * 1024 * 1024;  //in bytes
	
	$allowed_doc_mime_type = array('application/msword', 'application/pdf', "application/zip", "application/x-zip", "application/x-zip-compressed");	
	$allowed_image_mime_type = array('image/gif', 'image/jpeg', 'image/png', 'image/bmp', 'image/png');
	
	$allowed_image_extension = array(".jpg", ".bmp", ".png", ".gif");
	$allowed_doc_extension = array(".pdf", ".doc", ".docx", ".ppt", ".pptx", ".zip", ".xlx", ".xlsx", ".kml", ".csv");
	
	if(filter_xss($upload_type) == "image")
	{
		$sh_file = $upload_path.$_FILES[$sh_filename]['name'];		
		
		$original_extension = (false === $pos = strrpos($sh_file, '.')) ? '' : substr($sh_file, $pos);
		
		//$finfo = new finfo(FILEINFO_MIME);		
		//$type = $finfo->file($file);
		
		if($append_name)
			$sh_file = $append_name."_".$_FILES[$sh_filename]['name'];
	
		$sh_type = $_FILES[$sh_filename]['type'];		
		
		$sh_imageinfo = getimagesize($_FILES[$sh_filename]['tmp_name']);
		
		$sh_size = $_FILES[$sh_filename]['size'];
		
		$source = $_FILES[$sh_filename]['tmp_name'];
		
		$destination = $upload_path.$sh_file;
		
		if (in_array($sh_imageinfo['mime'], $allowed_image_mime_type ) && in_array($original_extension, $allowed_image_extension) && $sh_size <= $default_size)
		{
			
			if(move_uploaded_file($source, $destination))
				return $sh_file;
			else
				return 0;		
		}
		else
			return 0;
	}
	if(filter_xss($upload_type) == "file")
	{
		$sh_file = $upload_path.$_FILES[$sh_filename]['name'];		
       	$error = 0;
		$original_extension = (false === $pos = strrpos($sh_file, '.')) ? '' : substr($sh_file, $pos);
		
   		if(count(explode(".", strtolower( $_FILES[$sh_filename]['name'] ))) > 2 )
   		{
        	return 0;
        	$error = 1;
     	}
    	/*if (!(in_array(end(explode(".", strtolower($_FILES[$sh_filename]['name']))), $allowed_doc_extension))){
        	return 0;
        	$error = 1;        	
    	}*/
		if( $error == 0 )
		{
			$source = $_FILES[$sh_filename]['tmp_name'];
			
			$type = $_FILES[$sh_filename]['type'];
			
			$sh_size = $_FILES[$sh_filename]['size'];

			//echo mime_content_type("$_FILES[$sh_filename]['tmp_name']");
$finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $_FILES[$sh_filename]['tmp_name']);
            finfo_close($finfo);
//            print_r($mimetype);

			if($append_name)
				$sh_file = $append_name."_".$_FILES[$sh_filename]['name'];

			if($_FILES[$sh_filename]['name']!='' && ($type=="application/msword" || $type=="application/pdf") && ($original_extension == ".pdf" || $original_extension == ".doc" || $original_extension == ".docx") && $sh_size <= $default_size)
			{		
				if(move_uploaded_file($_FILES[$sh_filename]['tmp_name'], $upload_path.$sh_file))
					return $sh_file;
				else
					return 0;
			}
			else
			{
				return 0;
			}
		}
	}
	else
		return 0;
}

if(!function_exists('mime_content_type')) {

    function mime_content_type($filename) {

        $mime_types = array(

            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        $ext = strtolower(array_pop(explode('.',$filename)));
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }
        elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        }
        else {
            return 'application/octet-stream';
        }
    }
}

?>
