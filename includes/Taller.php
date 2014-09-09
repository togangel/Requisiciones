<?php
	include ('connection.php');

	function Taller(){
		$Squery="select U.NoEconomico Unidad, R.Descripcion Ruta, T.Descripcion Taller ";
		$Squery.="from tblFallas F ";
		$Squery.="inner join cUnidades U on U.Id=F.IdUnidad "; 
		$Squery.="inner join cRutas R on R.Id=F.IdRuta ";
		$Squery.="inner join cTalleres T on T.id=F.IdTipoEntrada ";
		$Squery.="where convert(varchar, F.FechaEntra, 103)=convert(varchar, getdate(), 103)";
		$conn=Connection();
		$stmt=$conn->query($Squery);
		$Tabla="";
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			$Unidad=$row['Unidad'];
			$Ruta=$row['Ruta'];
			$Taller=$row['Taller'];
			$Tabla.="Unidad: ".$Unidad." Ruta: ".$Ruta." Taller: ".$Taller."<br>";
		}
		$conn=null;
		$stmt = null;
		return $Tabla;
	}
	echo Taller();
?>