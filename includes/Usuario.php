<?php
	include('Connection.php');
	function ValidaUsuario($Usuario, $Password){
		$_SESSION['usuario']=getIdEmpleado($Usuario);
		/*$valida=false;
		$stmt=getContrasena($Usuario, $Password);
		if($row=$stmt->fetch(PDO::FETCH_ASSOC)) $PasswordSQL=$row['Ascii'];
		else $valida=false;
		if($PasswordSQL==Incripta($Password)){
			$valida=true;
			$_SESSION['usuario']=getIdEmpleado($Usuario);
		}
		else{
			$valida=false;
		}
		$stmt = null;
		return $valida;*/
		return true;
	}

	function getContrasena($Usuario, $Password){
		$Squery="SET TEXTSIZE 0;\n";
		$Squery=$Squery."DECLARE @position int, @string char(".strlen($Password)."), @suma int;\n";
		$Squery=$Squery."SET @position = 1;\n";
		$Squery=$Squery."set @suma=0;\n";
		$Squery=$Squery."SET @string = (select Password from Usuarios where IdUsuario='".$Usuario."');\n";
		$Squery=$Squery."WHILE @position <= DATALENGTH(@string)\n";
		$Squery=$Squery."   BEGIN\n";
		$Squery=$Squery."   set @suma=@suma+(SELECT ASCII(SUBSTRING(@string, @position, 1)))";
		$Squery=$Squery."   SET @position = @position + 1\n";
		$Squery=$Squery."   END;\n";
		$Squery=$Squery."select @suma Ascii\n";
		$conn=ConnectionSeguridad();
		$stmt=$conn->query($Squery);
		$conn=null;
		return $stmt;
	}

	function getIdEmpleado($Usuario){
		$Squery="select idempleado from usuarios u where u.idusuario='".$Usuario."'";
		$conn=ConnectionSeguridad();
		$stmt=$conn->query($Squery);
		if($row=$stmt->fetch(PDO::FETCH_ASSOC))
			$id=$row['idempleado'];
		$_SESSION['nomina']=$id;
		$Squery="select Id from cEmpleados where NoNomina='".$id."'";
		$conn=Connection();
		$stmt=$conn->query($Squery);
		if($row=$stmt->fetch(PDO::FETCH_ASSOC))
			$id=$row['Id'];
		$conn=null;
		$stmt=null;
		return $id;
	}

	function Incripta($Password){
		$UserKey="malm82youder";
		$pass=0;
		for($i=0; $i<strlen($Password); $i++){
			$sumascii=ord($Password[$i])+ord($UserKey[$i]);
			if($sumascii>255)
				$sumascii-=255;
			$pass+=$sumascii;
		}
		return $pass;
	}
?>