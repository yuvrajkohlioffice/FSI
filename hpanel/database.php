<?php
header('X-Frame-Options: SAMEORIGIN');
if (function_exists('mysql_connect') == false) {
    function mysql_connect($server, $username, $password, $new_link = false, $client_flags) {
        $key = $server.$username.$password;
        if (isset($GLOBALS['mysql_cons']) == false) {
            $GLOBALS['mysql_cons'] = false;
        }
        if ($new_link == false && isset($GLOBALS['mysql_cons'][$key])) {
            return $GLOBALS['mysql_cons'][$key];
        }

        $con = new mysqli($server, $username, $password);

        if (isset($GLOBALS['mysql_cons'][$key]) == false) {
            $GLOBALS['mysql_cons'][$key] = $con;
        }

        if (isset($GLOBALS['mysql_cons']['default']) == false) {
           $GLOBALS['mysql_cons']['default'] = $con;
        }

        $r = $con->connect($server, $username, $password);
        // $r = $con->connect($server, 'root', 'Fs!@2)@3WeBDb');

        if ($r === false)
            return false;

        return $con;
    }

    function mysql_select_db($dbname, $con=null) {
        if ($con == null) {
            $con = $GLOBALS['mysql_cons']['default'];
        }

        $r = $con->select_db($dbname);
        return $r;
    }

    function mysql_query($query, $con=null) {
        if ($con == null) {
            $con = $GLOBALS['mysql_cons']['default'];
        }

        return $con->query($query);
    }

    function mysql_real_escape_string($val, $con=null) {
        if ($con == null) {
            $con = $GLOBALS['mysql_cons']['default'];
        }

        return $con->escape_string($val);
    }


    function mysql_insert_id($con=null) {
        if ($con == null) {
            $con = $GLOBALS['mysql_cons']['default'];
        }

        return $con->insert_id;
    }

    function mysql_error($con=null) {
        if ($con == null) {
            $con = $GLOBALS['mysql_cons']['default'];
        }

        return $con->error;
    }

    function mysql_fetch_assoc($result) {
        $row = $result->fetch_assoc();

        return $row;
    }

    function mysql_fetch_array($result) {
        $row = $result->fetch_array();

        return $row;
    }
 
    function mysql_num_rows($result) {
        return $result->num_rows;
    }
    function mysql_data_seek($data, $rowPointer) {        
        mysqli_data_seek($data, $rowPointer);
    }
}
function db_connect()
{
$hostname = "localhost";
$username = "root";
// $password = "Fs!@2)@3WeBDb";
$password = "";
$dbName   = "fsiWebsiteDb";
// $dbName   = "db_main";

 
	MYSQL_CONNECT($hostname,$username,$password, 0, 1);

	mysql_select_db("$dbName");
}




function imageresize($max_width,$max_height,$image)
{
$dimensions=getimagesize($image);

$width_percentage=$max_width/$dimensions[0];
$height_percentage=$max_height/$dimensions[1];

if($width_percentage <= $height_percentage)
{
$new_width=$width_percentage*$dimensions[0];
$new_height=$width_percentage*$dimensions[1];
}
else
{
$new_width=$height_percentage*$dimensions[0];
$new_height=$height_percentage*$dimensions[1];
}

$new_image=array($new_width,$new_height);
return $new_image;
}


function cropImage($nw, $nh, $source, $stype, $dest) {
	$size = getimagesize($source);
	$w = $size[0];
	$h = $size[1];
	switch($stype) {
		case 'gif':
		$simg = imagecreatefromgif($source);
		break;
		case 'jpg':
		$simg = imagecreatefromjpeg($source);
		break;
		case 'jpeg':
		$simg = imagecreatefromjpeg($source);
		break;
		case 'JPG':
		$simg = imagecreatefromjpeg($source);
		break;
		case 'JPEG':
		$simg = imagecreatefromjpeg($source);
		break;
		case 'png':
		$simg = imagecreatefrompng($source);
		break;
		case 'bmp':
		$simg = imagecreatefrompng($source);
		break;
		
	}
	$dimg = imagecreatetruecolor($nw, $nh);
	
	$wm = $w/$nw;
	$hm = $h/$nh;
	$h_height = $nh/2;
	$w_height = $nw/2;
	if($w> $h) {
		$adjusted_width = $w / $hm;
		$half_width = $adjusted_width / 2;
		$int_width = $half_width - $w_height;
		imagecopyresampled($dimg,$simg,-$int_width,0,0,0,$adjusted_width,$nh,$w,$h);
	} elseif(($w <$h) || ($w == $h)) {
		$adjusted_height = $h / $wm;
		$half_height = $adjusted_height / 2;
		$int_height = $half_height - $h_height;
		imagecopyresampled($dimg,$simg,0,-$int_height,0,0,$nw,$adjusted_height,$w,$h);
	} else {
		imagecopyresampled($dimg,$simg,0,0,0,0,$nw,$nh,$w,$h);
	}
	imagejpeg($dimg,$dest,100);
}



function GetCartId()
	{


		
		if(isset($_COOKIE["cartId"]))
		{
			return $_COOKIE["cartId"];
		}
		else
		{


			
			session_start();
			setcookie("cartId", session_id(), time() + ((3600 * 24) * 30));
			return session_id();

		}

	}

	
	$site_name="Welcome to FSI Dehradun....";


	$front=0;	
	
	$pagename=$_SERVER['PHP_SELF'];

	$page2=explode('/', $pagename);
	
	$dir_path=$page2[count($page2) - 2];
	
	$finalpage=$page2[count($page2) - 1];
	
	if(isset($finalpage) && $finalpage=="index.php")
	{
		$front=1;
	}
	
	//$SITEURL="";
?>
