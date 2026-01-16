var xmlHttp

function subheadchange(str)
{
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  } 
var url="ajax_subsubhead.php";
url=url+"?cu="+str;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=ClassChangedsub;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}

function ClassChangedsub() 
{ 
if (xmlHttp.readyState==4)
{
document.getElementById("subsubhea").innerHTML=xmlHttp.responseText;
}
}

function GetXmlHttpObject()
{
var xmlHttp=null;
try
  {
  // Firefox, Opera 8.0+, Safari
  xmlHttp=new XMLHttpRequest();
  }
catch (e)
  {
  try
    {
    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
  catch (e)
    {
    xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
return xmlHttp;
}
