function newTabs(nombre){
	var tabs = document.getElementById("tabs-lista");
	var li = document.createElement("li");
    lista='<li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="Lista" aria-labelledby="ui-id-6" aria-selected="false" aria-expanded="false">';
	li.innerHTML=lista+'<a href="#'+nombre+'" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-6">'+nombre+'</a></li>';
	tabs.appendChild(li);
	var tabs = document.getElementById("tabs");
    var div = document.createElement("div");
    div.innerHTML='<div id="'+nombre+'" aria-labelledby="ui-id-6" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-hidden="true" style="display: none;">';
	//inner.innerHTML="<div id=\""+nombre+"\"></div>";
	tabs.appendChild(div);
}
//<a href="#Lista" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-6">Lista</a>
//<li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="Lista" aria-labelledby="ui-id-6" aria-selected="false" aria-expanded="false"><a href="#Lista" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-6">Lista</a></li>

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