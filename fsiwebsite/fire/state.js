var xmlHttp

function showclass(str)
{
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  } 
var url="ajax_state.php";
url=url+"?cu="+str;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=ClassChanged;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}

function ClassChanged() 
{ 
if (xmlHttp.readyState==4)
{
document.getElementById("classHint").innerHTML=xmlHttp.responseText;
document.getElementById("classHint1").innerHTML=xmlHttp.responseText;
document.getElementById("classHint2").innerHTML=xmlHttp.responseText;
document.getElementById("classHint3").innerHTML=xmlHttp.responseText;
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
