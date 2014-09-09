<?php
	include ('connection.php');
	class CatalogosSelect{
		public function cTalleres(){
			$Option="";
			$Squery="select T.Id, T.Descripcion Taller from cTalleres T where T.Estatus=1 and id!=0";
			$conn=Connection();
			$stmt=$conn->query($Squery);
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
				$Id=$row['Id'];
				$Taller=$row['Taller'];
				$Option.="<option value=\"".$Id."\">".$Taller."</opction>";
			}
			$conn=null;
			$stmt = null;
			return $Option;
		}

		public function cDepartamentos(){
			$Option="";
			$Squery="select Id, Descripcion Departamento from cDepartamentos where Estatus=1";
			$conn=Connection();
			$stmt=$conn->query($Squery);
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
				$Id=$row['Id'];
				$Departamento=$row['Departamento'];
				$Option.="<option value=\"".$Id."\">".$Departamento."</opction>";
			}
			$conn=null;
			$stmt = null;
			return $Option;
		}

		public function cTalleres2(){
			$Option="<option></opction>";
			$Squery="select T.Id, T.Descripcion Taller from cTalleres T where T.Estatus=1 and id!=0";
			$conn=Connection();
			$stmt=$conn->query($Squery);
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
				$Id=$row['Id'];
				$Taller=$row['Taller'];
				$Option.="<option value=\"".$Id."\">".$Taller."</opction>";
			}
			$conn=null;
			$stmt = null;
			return $Option;
		}

		public function cDepartamentos2(){
			$Option="<option></opction>";
			$Squery="select Id, Descripcion Departamento from cDepartamentos where Estatus=1";
			$conn=Connection();
			$stmt=$conn->query($Squery);
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
				$Id=$row['Id'];
				$Departamento=$row['Departamento'];
				$Option.="<option value=\"".$Id."\">".$Departamento."</opction>";
			}
			$conn=null;
			$stmt = null;
			return $Option;
		}
	}

	class CatalogosVentanas{
		public function cArticulos(){
			$Option="<option></opction>";
			$Squery.="select A.Descripcion, T.Descripcion";
			$Squery.="from cArticulos A";
			$Squery.="iNNER JOIN cSubTiposDeFallas ST ON ST.id=A.IdSubGrupo";
			$Squery.="INNER JOIN cTiposDeFallas T ON T.Id=ST.idTipo and T.Id=5";
			$Squery.="where A.Estatus=1 and A.Existencia>0";
			$Squery.="group by A.Descripcion, T.Descripcion";
			$conn=Connection();
			$stmt=$conn->query($Squery);
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
				$Id=$row['Id'];
				$Taller=$row['Taller'];
				$Option.="<option value=\"".$Id."\">".$Taller."</opction>";
			}
			$conn=null;
			$stmt = null;
			return $Option;
		}
	}
?>