var xmlHttp

function showsubhead(str)
{
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  } 
var url="ajax_subhead.php";
url=url+"?cu="+str;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=ClassChanged12;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}

function ClassChanged12() 
{ 
if (xmlHttp.readyState==4)
{
document.getElementById("subhea").innerHTML=xmlHttp.responseText;
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
