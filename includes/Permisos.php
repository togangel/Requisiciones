<ul id="tabs-lista">
	<?php
		$div='';
		if(!isset($_SESSION['nomina']) && !isset($_SESSION['usuario'])) header('Location: index.php');
		include_once('connection.php');
		$Squery="select M.id from Usuarios U inner join Modulos M on M.id=U.IdModulo where U.IdUsuario=".$_SESSION['usuario']."";
		$conn=ConnectionWeb();
		$conn2=ConnectionWeb();
		$stmt=$conn->query($Squery);
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			switch($row['id']){
				case '2':
					$Squery="select Alta, Autorizacion, Modificacion, Consulta from Usuarios U where U.IdModulo=2 and U.IdUsuario=".$_SESSION['usuario'];
					$stmt2=$conn2->query($Squery);
					if($row2=$stmt2->fetch(PDO::FETCH_ASSOC)){
						 if($row2['Alta']=='1'){
						 	echo '<li><a href="#Rcompras">Alta de Requisiciones</a></li>';
						 }
						 if($row2['Modificacion']=='1'){
						 	echo '<li><a href="#RServicio">Requisiciones</a></li>';
						 }
						 if($row2['Autorizacion']=='1'){
						 	echo '<li><a href="#Autoriza">Autorizar Requisiciones</a></li>';
						 }
						 if($row2['Consulta']=='1'){
						 	echo '<li><a href="#Lista">Lista de Requisiciones</a></li>';
						 }
						 echo "</ul>";
					}
					$stmt2=$conn2->query($Squery);
					if($row2=$stmt2->fetch(PDO::FETCH_ASSOC)){
						 if($row2['Alta']=='1'){
						 	echo '<div id="Rcompras">';
						 	include("html/Rcompras.php");
						 	echo 'Requisiciones</div>';
						 }
						 if($row2['Modificacion']=='1'){
						 	echo '<div id="RServicio">'; include("html/Requisicion.php"); echo '</div>';
						 }
						 if($row2['Autorizacion']=='1'){
						 	echo '<div id="Autoriza">'; include("html/Autoriza.php"); echo '</div>';
						 }
						 if($row2['Consulta']=='1'){
						 	echo '<div id="Lista">'; include("html/ListaR.php"); echo '</div>';
						 }
					}
					break;
				case '1':
					$Squery="select Alta, Autorizacion, Modificacion, Consulta from Usuarios U where U.IdModulo=1 and U.IdUsuario=".$_SESSION['usuario'];
					$stmt2=$conn2->query($Squery);
					if($row2=$stmt2->fetch(PDO::FETCH_ASSOC)){
						 if($row2['Alta']=='1'){
						 }
						 if($row2['Modificacion']=='1'){
						 	echo '<li><a href="#Almacen">Almacen</a></li>';
						 }
						 if($row2['Autorizacion']=='1'){
						 }
						 if($row2['Consulta']=='1'){
						 	echo '<li><a href="#Lista">Lista de Requisiciones</a></li>';
						 }
						 echo "</ul>";
					}
					$stmt2=$conn2->query($Squery);
					if($row2=$stmt2->fetch(PDO::FETCH_ASSOC)){
						 if($row2['Alta']=='1'){
						 }
						 if($row2['echo Modificacion']=='1'){
						 	echo '<div id="Almacen">';include("html/Recibe.php"); echo '</div>';
						 }
						 if($row2['Autorizacion']=='1'){
						 }
						 if($row2['Consulta']=='1'){
						 	echo '<div id="Lista">'; include("html/ListaR.php"); echo '</div>';
						 }
						 echo "</ul>";
					}
					break;
			}
		}
		$conn=null;
		$stmt=null;
	?>
</ul>
<?php echo $div; ?>