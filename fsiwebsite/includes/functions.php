<?php

class config
{
 	public function __construct ($host, $UserName, $Password, $DbName ) 
 	{
    	$this->userName = $UserName;
    	$this->password = $Password;
    	$this->dbName = $DbName;
    	$this->hostName= $host;  	
    	mysql_connect($this->hostName,$this->userName,$this->password, 0, 1);
		mysql_select_db("$this->dbName");
  	}		
}




class common
{
	var $pagename;
	var $page2;
	var $dir_path;
	var $finalpage;
	public $front;
	public $website_name;
	public $site_name;
	public $facebook;
	public $youtube;
	public $twitter;
	public $linkedin;
	public $skype;
	public $googleplus;
	public $tripadvisor;
	public $google_map_code;
	public $footer_note;
	public $default_address;
	public $default_mobile;
	public $default_phone;
	public $use_friendly_urls;
	public $default_access_password;
	public $default_email;
	public $default_additional_note;
	
	public function __construct()
	{
		$this->site_name="Welcome To Forest Survey of India";		
		$this->front=0;	
		$this->use_friendly_urls = 0;
		date_default_timezone_set("Asia/Calcutta");		
		$pagename=$_SERVER['PHP_SELF'];
		$page2=explode('/', $pagename);
		$dir_path=$page2[count($page2) - 2];
		$finalpage=$page2[count($page2) - 1];
		if(isset($finalpage) && $finalpage=="index.php")
		{
			$this->front=1;
		}	
		
		$res_settings = mysql_query("select website_name,meta_desc,meta_key,meta_title, twitter,facebook,youtube,linkedin,footer_note,address,phone,mobile,tripadvisor, friendly_url, skype, googlemap, googleplus, email_id, default_additional_note from settings");
		$row_settings = mysql_fetch_array($res_settings);
		$this->website_name=html_entity_decode(strip_tags($row_settings['website_name']));
		$this->facebook=html_entity_decode(strip_tags($row_settings['facebook']));
		$this->twitter=html_entity_decode(strip_tags($row_settings['twitter']));
		$this->youtube=html_entity_decode(strip_tags($row_settings['youtube']));	
		$this->linkedin=html_entity_decode(strip_tags($row_settings['linkedin']));
		$this->googleplus=html_entity_decode(strip_tags($row_settings['googleplus']));	
		$this->tripadvisor = html_entity_decode(strip_tags($row_settings['tripadvisor']));	
		$this->skype = html_entity_decode(strip_tags($row_settings['skype']));	
		$this->google_map_code = html_entity_decode(strip_tags($row_settings['googlemap']));	
		$this->footer_note=html_entity_decode(strip_tags($row_settings['footer_note']));
		$this->default_address=html_entity_decode($row_settings['address']);
		$this->default_phone=html_entity_decode(strip_tags($row_settings['phone']));
		$this->default_mobile=html_entity_decode(strip_tags($row_settings['mobile']));	
		$this->use_friendly_urls = html_entity_decode(strip_tags($row_settings['friendly_url']));		
		$this->default_email = html_entity_decode(strip_tags($row_settings['email_id']));		
		$this->default_additional_note = html_entity_decode(strip_tags($row_settings['default_additional_note']));
		$this->meta_desc = 	html_entity_decode(strip_tags($row_settings['meta_desc']));
		$this->meta_key = 	html_entity_decode(strip_tags($row_settings['meta_key']));
		$this->meta_title = 	html_entity_decode(strip_tags($row_settings['meta_title']));

	}
	
	function send_sms($mobile_no, $sms_texts)
    {	
    	$method="POST";
    	$mobile = $mobile_no;
    	$domain = "webline.bulksms5.com";
    
    	$message = $sms_texts;
    
    	$uid = urlencode("fsi");
    	$pin = urlencode("fsi@2017%");
    	$sender = urlencode("FSIDDN");
    	$message = urlencode($message);
    		
    	$url = "http://$domain/sendmessage.php";
    
    	$parameters = "?user=$uid&password=$pin&mobile=$mobile&message=$message&sender=$sender&type=".urlencode('3');
    	$url = $url.$parameters;
    	$ch = curl_init($url);
    	if($method=="POST")
    	{
    		curl_setopt($ch, CURLOPT_POST,1);
    		curl_setopt($ch, CURLOPT_POSTFIELDS,$parameters);
    	}
    	else
    	{
    		$get_url=$url."?".$parameters;
    
    		curl_setopt($ch, CURLOPT_POST,0);
    		curl_setopt($ch, CURLOPT_URL, $get_url);
    	}
    	//curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1); 
    	curl_setopt($ch, CURLOPT_HEADER,0);  // DO NOT RETURN HTTP HEADERS 
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);  // RETURN THE CONTENTS OF THE CALL
    	$return_val = curl_exec($ch);
    
    	if($return_val=="")
    		return "700701";
    	else	
    		return $return_val;
    
    }
	
	
	function get_current_url()
	{		
		$curr_path = $_SERVER['REQUEST_URI'];
		$path_array = explode('/', $curr_path);
		//print_r($path_array);
		$current_url = $path_array[1];
		return $current_url;
	}
	
	function get_auto_friendly_url($convert_this)
	{	
		$input = str_replace(array("'", "-"), "", $convert_this); 
		//$input = mb_convert_case($input, MB_CASE_LOWER, "UTF-8"); 
		$input = strtolower($input);
		$input = preg_replace("#[^a-zA-Z0-9]+#", "-", $input); 
		$input = preg_replace("#(-){2,}#", "$1", $input); 
		$input = trim($input, "-"); 
		return $input;
	}
	function last_updated( $dateformat )
	{	
		$response = mysql_fetch_array( mysql_query("select crdate as date from update_tab") );		
		if( $dateformat != "" )
			$resData = date( $dateformat, strtotime( $response['date'] ));
		else
			$resData = $response['date'];
		
		return $resData;
	}
	function is_front()
	{
		$pagename = $_SERVER['PHP_SELF'];
		$page2 = explode('/', $pagename);
		$dir_path = $page2[count($page2) - 2];
		$finalpage = $page2[count($page2) - 1];
		if( isset($finalpage) && $finalpage=="index.php" )
			return 1;
		else
			return 0;
	}
	
	function get_header()
	{
		if($this->front)
		{
			include "common/header.php";
		}
		else
		{
			include "common/header.php";
		}
	}
	function get_inner_header()
	{		
		include "common/header-inner.php";		
	}
	
	function get_common_head()
	{
		include_once "common/head.php";
	}
	
	function get_sidebar()
	{
		include_once "common/side_bar.php";
	}
	
	function get_slider()
	{
		include_once "common/sliders.php";
	}
	
	function get_banner()
	{
		include_once "common/banner.php";
	}
	
	function get_footer()
	{
		include_once "common/footer.php";	
	}
	function get_footer2()
	{
		include_once "common/footer2.php";	
	}
	
	
	function get_footer_scripts()
	{
		include_once "common/footer-scripts.php";	
	}
	
	function get_results($query="")
	{
		$resource_id="";

		if(!empty($query))
		{
			$resource = mysql_query($query);
			$resource_id = mysql_fetch_array($resource) or die(mysql_error());	
		}
		
		return $resource_id;
	}
	
	function get_array($query="")
	{
		$resource_id="";

		if(!empty($query))
		{
			$resource_id = mysql_query($query);
		}
		
		return $resource_id;
	}

}

class catalog
{
	var $name;
	var $description;
	var $teaser;
	var $slug;
	var $meta_title;
	var $meta_keywords;
	var $meta_description;
	var $thumb;
	var $banner;
	
	
	function get_product_info($product_id="")
	{
		if(!empty($product_id))
		{
			$row_product = mysql_fetch_array(mysql_query("select * from prod_products where status='active' and sno='$product_id'"));
			$this->name = $row_product['prod_name'];
			$this->teaser = $row_product['teaser'];
			$this->thumb = $row_product['prod_thumb'];
		}
		else
		{
			return 0;
		}
	}
	function get_catalog($category_id="", $order_by="",$criteria="",$limit="")
	{
		if(!empty($category_id))
		{
			$catalog_query = "select * from prod_products where status='active'";
			
			if(!empty($criteria))
			{
				if($criteria=="best_seller")
					$catalog_query.=" and prod_type='bestseller'";
			}
			
			if(!empty($order_by))			
				$catalog_query.= " order by prod_sorder ".$order_by;
			else
				$catalog_query.= " order by prod_sorder asc";
			if(!empty($limit))
				$catalog_query.=" ".$limit;
			$res_catalog = mysql_query($catalog_query);			
					
			if(mysql_num_rows($res_catalog)>0)
				return $res_catalog;			
			else
				return 0;
		}
		else
		{
			return 0;
		}
	}
	
	function get_category($order_by="")
	{
		$catalog_query = "select * from prod_category where status='active'";
			
		if(!empty($order_by))			
			$catalog_query.= " order by sorder ".$order_by;
		else
			$catalog_query.= " order by sorder asc";
			
		$res_catalog = mysql_query($catalog_query);
		
		if(mysql_num_rows($res_catalog)>0)
			return $res_catalog;			
		else
			return 0;
	}

	function get_category_info($category_id="")
	{
		if(!empty($category_id))
		{
			$row_category = mysql_fetch_array(mysql_query("select * from prod_category where status='active' and sno='$category_id'"));
			$this->name = $row_category['category'];		
		}
		else
		{
			return 0;
		}
	}
}

	
function get_num_rows($table_name,$column,$criteria,$order_by="", $group_by="",$limit="")
{
	$count=0;
	$query="";

	
	$query="select ".$column." from ".$table_name;
	
	if(trim($criteria)!="")
	{
		$query.=" where ".$criteria;
	}
	if(trim($group_by)!="")
	{
		$query.=" group by ".$group_by;
	}
	if(trim($order_by)!="")
	{
		$query.=" order by ".$order_by;
	}
	if(trim($limit)!="")
	{
		$query.=" limit ".$limit;
	}
	
	$count = mysql_num_rows(mysql_query($query));
	
	return $count;
}

function get_data($required,$table_name,$column,$criteria,$order_by="", $group_by="",$limit="")
{
	$resource_id="";
	$query="";
	
	$query="select ".$column." from ".$table_name;
	
	if(trim($criteria)!="")
	{
		$query.=" where ".$criteria;
	}
	if(trim($group_by)!="")
	{
		$query.=" group by ".$group_by;
	}
	if(trim($order_by)!="")
	{
		$query.=" order by ".$order_by;
	}
	if(trim($limit)!="")
	{
		$query.=" limit ".$limit;
	}

	$resource_id = mysql_query($query);
	
	$response_array=mysql_fetch_assoc($resource_id);

	if($required=="query")
		return $resource_id;
	else if($required=="array")
		return $response_array;
	else
		return "error";

}


?>
