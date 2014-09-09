function reportes(reporte){
    var xmlhttp;
    if(window.XMLHttpRequest)
        xmlhttp=new XMLHttpRequest();
    else
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState===4 && xmlhttp.status===200)
            document.getElementById("cuerpore").innerHTML=xmlhttp.responseText;
    }
    xmlhttp.open("GET","html/"+reporte,true);
    xmlhttp.send();
}