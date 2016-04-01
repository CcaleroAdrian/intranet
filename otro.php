<?php
require 'clases/actionsDB.php'; 
$id = $_GET['id'];

$objOperaciones = new ActionsDB();

?>
<div class="panel panel-primary">
   <div class="panel-heading">DATOS GENERALES</div>
   <div class="panel-body">
   		<form>
   			<table>
   			<tr>
   			<td><label>Nombre:</label></td>
   			<td><input type="text" name="nombre" readonly value=""></input></td>
   			</tr>
   			<tr>
   			<td><label>Fecha inicial:</label></td>
   			<td><input type="date" name="fechaInicio" value=""></input></td>
   			<td><label>Fecha final:</label></td>
   			<td><input type="date" name="fechaFinal" value=""></input></td>
   			</tr>
   			<tr>
   			<td><label>D&iacute;as Correspondientes:</label></td>
   			<td><input type="number" name="vacaciones" value></input></td>
   			<td><label>D&iacute;as Solicitados:</label></td>
   			<td><input type="number" name="diasSolicitados" value></input></td>
   			</tr>
   			<tr>
   			<td><label>D&iacute;as Adicionales:</label></td>
   			<td><input type="number" name="diasAdicionales"></input></td>
   			<td><label>D&iacute;as Restantes:</label></td>
   			<td><input type="number" name="diasRestantes"></input></td>
   			</tr>
   			<tr>
   			<td><label>Aprobaci&oacute;n del Gerente:</label></td>
   			<td><select name="AprobacionGerente">
   				<option value="1">PENDIENTE</option>
   				<OPTION value="2">APROVADA</OPTION>
   				<option value="3">RECHAZADA</option>
   			</select></td>
   			<td><label>Aprobaci&oacute;n del Director:</label></td>
   			<td><select name="AprobacionDirector">
   				<option value="1">PENDIENTE</option>
   				<OPTION value="2">APROVADA</OPTION>
   				<option value="3">RECHAZADA</option>
   			</select></td>
   			</tr>
   		</table>
   		<div class="col-sm4"><input type="submit" value="GUARDAR"></input></div>
   		</form>
   		
   </div>
 </div>