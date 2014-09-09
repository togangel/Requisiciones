<?php
	include ('connection.php');

	function SemaforoTablaEmpleado(){
		$Squery="select top 1 U.NOECONOMICO Unidad, Z.DESCRIPCION Zona, R.DESCRIPCION Ruta, E.NONOMINA Nomina, ";
		$Squery.="		substring(E.nombres,0,case when charindex(' ',E.nombres,0)>0 then charindex(' ',E.nombres,0) else len(E.nombres)+1 end )+ ' '+E.APPATERNO+' '+E.APMATERNO Operador, ";
		$Squery.="		L.TURNO1257 Turno, L.VUELTAS Vueltas, ";
		$Squery.="		CAST((datediff(minute,L.HORAINICIOPAPELETA,L.HORAFINPAPELETA)/60) AS VARCHAR)+' h '+CAST(datediff(minute,L.HORAINICIOPAPELETA,L.HORAFINPAPELETA)-((datediff(minute,L.HORAINICIOPAPELETA,L.HORAFINPAPELETA)/60)*60) AS VARCHAR ) +' min.' AS HorasTrabajo, ";
		$Squery.="		L.SUBTOTALBOLETOS TotalBoletos, ";
		$Squery.="		case ";
		$Squery.="			when l.subtotalboletos>min(ISNULL(b.PROYECTADO,b.CANTIDAD))then 1";
		$Squery.="			when l.subtotalboletos>min(b.CANTIDAD) then 2";
		$Squery.="			when l.subtotalboletos<min(b.CANTIDAD) then 3";
		$Squery.="			Else 4 end as Color ";
		$Squery.="		FROM tblliquidacion L  ";
		$Squery.="		INNER JOIN CUNIDADES U ON L.IDUNIDAD=U.ID INNER JOIN CRUTAS R ON L.IDRUTA=R.ID and R.id=15  ";
		$Squery.="		INNER JOIN cEmpleados E ON L.IDOPERADOR=E.ID INNER JOIN cZonas Z ON R.IdZona=Z.id  ";
		$Squery.="		LEFT join tblcapturasensores CS on CS.folioliquidacion=L.id ";
		$Squery.="		left join tbldetcajas DC on l.iddetcaja=Dc.id LEFT JOIN TBLDESCUENTOSAUTOMATICOS DA ON DA.FOLIOSENSOR=CS.ID AND DA.ESTATUS=1 and da.idtipo=26  ";
		$Squery.="		left join cbono2013 B on (l.fechaaliquidar between  b.fechareg and isnull(b.fechabaja,getdate())) and b.idruta=l.idruta and b.turno=l.turno1257 and l.vueltas>=b.vueltas "; 
		$Squery.="		WHERE l.estatus=1 AND l.Fecha=convert(varchar, getdate(), 103)";
		$Squery.="		GROUP BY l.idunidad,L.ID,l.FECHA,L.FECHAALIQUIDAR,L.hora, U.NOECONOMICO,Z.DESCRIPCION, R.DESCRIPCION, E.NONOMINA,substring(E.nombres,0,case when charindex(' ',E.nombres,0)>0 then ";
		$Squery.="		charindex(' ',E.nombres,0) else len(E.nombres)+1 end )+ ' '+E.APPATERNO+' '+E.APMATERNO, DC.idturno, L.TURNO1257,L.VUELTAS,  L.HORAINICIOPAPELETA,L.HORAFINPAPELETA, datediff(minute,L.HORAINICIOPAPELETA,L.HORAFINPAPELETA)/60, datediff(minute,L.HORAINICIOPAPELETA,L.HORAFINPAPELETA)-((datediff(minute,L.HORAINICIOPAPELETA,L.HORAFINPAPELETA)/60)*60), L.BOLETOSSENSOR,L.MARCASSENSOR,L.DESCUENTOSAUTOMATICOS, L.SERVICIOSEGURIDAD,L.TRANSBORDOS, L.TURIBONOSESTUDIANTE,L.BECALIBRE,L.TURIBECAADULTOS,L.TURIDIF, L.BOLETOSALIQUIDARSENSOR,L.BOLETOSALIQUIDARTARJETA, L.BOLETOSALIQUIDARTARJETA-L.BOLETOSALIQUIDARSENSOR, case when idturnocaja=0 then '/' when IDTURNOCAJA=1 then 'S' when IDTURNOCAJA=2 then 'T' when IDTURNOCAJA=3 then 'P' End, L.SUBTOTALBOLETOS,L.BONOS,L.TURIBONOS, L.TURIBONOSx,l.TRANSFER, L.TURIBONOSDESCUENTO,L.CANTIDADBOLETOS,L.PRECIOBOLETO,L.CANTIDADDINEROALIQUIDAR,L.idcajero,case  when L.idcajero>0 then ROUND(L.SUBTOTALBOLETOS/L.idcajero,2) else 0 end, CASE WHEN l.INCIDENCIAS='SIN INCIDENCIAS' THEN '' ELSE l.INCIDENCIAS END ";
		$Squery.="		order by l.hora desc";
		$conn=Connection();
		$stmt=$conn->query($Squery);
		$Tabla="[['Unidad', 'Zona', 'Ruta', 'Nomina', 'Operador', 'Turno', 'Vueltas', 'Horas Trabajo', 'Total Boletos', 'Tarjeta']";
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			$Unidad=$row['Unidad'];
			$Zona=$row['Zona'];
			$Ruta=$row['Ruta'];
			$Nomina=$row['Nomina'];
			$Operador=$row['Operador'];
			$Turno=$row['Turno'];
			$Vueltas=$row['Vueltas'];
			$HorasTrabajo=$row['HorasTrabajo'];
			$TotalBoletos=$row['TotalBoletos'];
			$Color=$row['Color'];
			$Tabla.=", ['".$Unidad."', '".$Zona."', '".$Ruta."', '".$Nomina."', '".$Operador."', '".$Turno."', ".$Vueltas.", '".$HorasTrabajo."', ".$TotalBoletos.", ".$Color."]";
		}
		$conn=null;
		$stmt = null;
		return $Tabla."]";
	}

	function SemaforoTablaRuta($Ruta){
		$Squery="select top 10 U.NOECONOMICO Unidad, Z.DESCRIPCION Zona, R.DESCRIPCION Ruta, E.NONOMINA Nomina, ";
		$Squery.="		substring(E.nombres,0,case when charindex(' ',E.nombres,0)>0 then charindex(' ',E.nombres,0) else len(E.nombres)+1 end )+ ' '+E.APPATERNO+' '+E.APMATERNO Operador, ";
		$Squery.="		L.TURNO1257 Turno, L.VUELTAS Vueltas, ";
		$Squery.="		CAST((datediff(minute,L.HORAINICIOPAPELETA,L.HORAFINPAPELETA)/60) AS VARCHAR)+' h '+CAST(datediff(minute,L.HORAINICIOPAPELETA,L.HORAFINPAPELETA)-((datediff(minute,L.HORAINICIOPAPELETA,L.HORAFINPAPELETA)/60)*60) AS VARCHAR ) +' min.' AS HorasTrabajo, ";
		$Squery.="		L.SUBTOTALBOLETOS TotalBoletos, ";
		$Squery.="		case ";
		$Squery.="			when l.subtotalboletos>min(ISNULL(b.PROYECTADO,b.CANTIDAD))then 1";
		$Squery.="			when l.subtotalboletos>min(b.CANTIDAD) then 2";
		$Squery.="			when l.subtotalboletos<min(b.CANTIDAD) then 3";
		$Squery.="			Else 4 end as Color ";
		$Squery.="		FROM tblliquidacion L  ";
		$Squery.="		INNER JOIN CUNIDADES U ON L.IDUNIDAD=U.ID INNER JOIN CRUTAS R ON L.IDRUTA=R.ID and R.id=15  ";
		$Squery.="		INNER JOIN cEmpleados E ON L.IDOPERADOR=E.ID INNER JOIN cZonas Z ON R.IdZona=Z.id  ";
		$Squery.="		LEFT join tblcapturasensores CS on CS.folioliquidacion=L.id ";
		$Squery.="		left join tbldetcajas DC on l.iddetcaja=Dc.id LEFT JOIN TBLDESCUENTOSAUTOMATICOS DA ON DA.FOLIOSENSOR=CS.ID AND DA.ESTATUS=1 and da.idtipo=26  ";
		$Squery.="		left join cbono2013 B on (l.fechaaliquidar between  b.fechareg and isnull(b.fechabaja,getdate())) and b.idruta=l.idruta and b.turno=l.turno1257 and l.vueltas>=b.vueltas "; 
		$Squery.="		WHERE l.estatus=1 AND l.Fecha=convert(varchar, getdate(), 103)";
		$Squery.="		GROUP BY l.idunidad,L.ID,l.FECHA,L.FECHAALIQUIDAR,L.hora, U.NOECONOMICO,Z.DESCRIPCION, R.DESCRIPCION, E.NONOMINA,substring(E.nombres,0,case when charindex(' ',E.nombres,0)>0 then ";
		$Squery.="		charindex(' ',E.nombres,0) else len(E.nombres)+1 end )+ ' '+E.APPATERNO+' '+E.APMATERNO, DC.idturno, L.TURNO1257,L.VUELTAS,  L.HORAINICIOPAPELETA,L.HORAFINPAPELETA, datediff(minute,L.HORAINICIOPAPELETA,L.HORAFINPAPELETA)/60, datediff(minute,L.HORAINICIOPAPELETA,L.HORAFINPAPELETA)-((datediff(minute,L.HORAINICIOPAPELETA,L.HORAFINPAPELETA)/60)*60), L.BOLETOSSENSOR,L.MARCASSENSOR,L.DESCUENTOSAUTOMATICOS, L.SERVICIOSEGURIDAD,L.TRANSBORDOS, L.TURIBONOSESTUDIANTE,L.BECALIBRE,L.TURIBECAADULTOS,L.TURIDIF, L.BOLETOSALIQUIDARSENSOR,L.BOLETOSALIQUIDARTARJETA, L.BOLETOSALIQUIDARTARJETA-L.BOLETOSALIQUIDARSENSOR, case when idturnocaja=0 then '/' when IDTURNOCAJA=1 then 'S' when IDTURNOCAJA=2 then 'T' when IDTURNOCAJA=3 then 'P' End, L.SUBTOTALBOLETOS,L.BONOS,L.TURIBONOS, L.TURIBONOSx,l.TRANSFER, L.TURIBONOSDESCUENTO,L.CANTIDADBOLETOS,L.PRECIOBOLETO,L.CANTIDADDINEROALIQUIDAR,L.idcajero,case  when L.idcajero>0 then ROUND(L.SUBTOTALBOLETOS/L.idcajero,2) else 0 end, CASE WHEN l.INCIDENCIAS='SIN INCIDENCIAS' THEN '' ELSE l.INCIDENCIAS END ";
		$Squery.="		order by l.hora desc";
		$conn=Connection();
		$stmt=$conn->query($Squery);
		$Tabla="[['Unidad', 'Zona', 'Ruta', 'Nomina', 'Operador', 'Turno', 'Vueltas', 'Horas Trabajo', 'Total Boletos', 'Tarjeta']";
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			$Unidad=$row['Unidad'];
			$Zona=$row['Zona'];
			$Ruta=$row['Ruta'];
			$Nomina=$row['Nomina'];
			$Operador=$row['Operador'];
			$Turno=$row['Turno'];
			$Vueltas=$row['Vueltas'];
			$HorasTrabajo=$row['HorasTrabajo'];
			$TotalBoletos=$row['TotalBoletos'];
			$Color=$row['Color'];
			$Tabla.=", ['".$Unidad."', '".$Zona."', '".$Ruta."', '".$Nomina."', '".$Operador."', '".$Turno."', ".$Vueltas.", '".$HorasTrabajo."', ".$TotalBoletos.", ".$Color."]";
		}
		$conn=null;
		$stmt = null;
		return $Tabla."]";
	}
?>