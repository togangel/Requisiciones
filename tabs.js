function newTabs(nombre){
	var tabs = document.getElementById("tabs-lista");
	var li = document.createElement("li");
	valor="<li class=\"ui-state-default ui-corner-top\" role=\"tab\" tabindex=\"-1\" \aria-controls=\""+nombre+"\" aria-labelledby=\"ui-id-"+nombre+"\" aria-selected=\"false\"";
	valor=valor+"aria-expanded=\"false\">";
	valor=valor+"<a href=\"#"+nombre+"\" class=\"ui-tabs-anchor\" role=\"presentation\" tabindex=\"-1\" id=\"ui-id-"+nombre+"\">"+nombre+"</a></li>";
	li.innerHTML=valor
	tabs.appendChild(li);
	var tabs = document.getElementById("tabsa");
	inner.innerHTML="<div id=\""+nombre+"\"></div>";
	tabs.appendChild(inner);
}

function refreshDivs(divid,secs,url){
    var divid, secs, url, fetch_unix_timestamp;
    var xmlHttp;
    try{
        xmlHttp=new XMLHttpRequest(); // Firefox, Opera 8.0+, Safari
    }
    catch (e){
        try{
            xmlHttp=new ActiveXObject("Msxml2.XMLHTTP"); // Internet Explorer
        }
        catch (e){
            try{
                xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch (e){
                alert("Tu explorador no soporta AJAX.");
                return false;
            }
        }
    }
    fetch_unix_timestamp = function(){
        return parseInt(new Date().getTime().toString().substring(0, 10))
    }
    
    var timestamp = fetch_unix_timestamp();
    var nocacheurl = url;
    xmlHttp.onreadystatechange=function(){
        if(xmlHttp.readyState === 4 && xmlHttp.status === 200){
            document.getElementById(divid).innerHTML=xmlHttp.responseText;
            setTimeout(function(){refreshDivs(divid,secs,url);},secs*1000);
        }
    }
    xmlHttp.open("GET",nocacheurl,true);
    xmlHttp.send(null);
}