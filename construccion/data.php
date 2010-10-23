	<tr>
		<td><select id="aldea<?=$c?>"></select></td>
		<td>
			<select id="edificio<?=$c?>">
				<option value="1">Leñador</option>
				<option value="2">Barrera</option>
				<option value="3">Mina de Hierro</option>
				<option value="4">Granja</option>
				<option value="5">Serreria</option>
				<option value="6">Ladrillar</option>
				<option value="7">Fundicion de Hierro</option>
				<option value="8">Molino</option>
				<option value="9">Panaderia</option>
				<option value="10">Almacen</option>
				<option value="11">Granero</option>
				<option value="12">Armeria</option>
				<option value="13">Herreria</option>
				<option value="14">Plaza de Torneos</option>
				<option value="15">Edificio Principal </option>
				<option value="16">Plaza de Reuniones</option>
				<option value="17">Mercado</option>
				<option value="18">Embajada</option>
				<option value="19">Cuartel</option>
				<option value="20">Establo</option>
				<option value="21">Taller</option>
				<option value="22">Academia</option>
				<option value="23">Escondite</option>
				<option value="24">Ayuntamiento</option>
				<option value="25">Residencia</option>
				<option value="26">Palacio</option>
				<option value="27">Tesoro</option>
				<option value="28">Oficina de Comercio</option>
				<option value="29">Cuartel Grande</option>
				<option value="30">Establo Grande</option>
				<option value="31">Muralla</option>
				<option value="32">Terraplen</option>
				<option value="33">Empalizada</option>
				<option value="34">Cantero</option>
				<option value="35"></option>
				<option value="36"></option>
				<option value="37">Hogar del Heroe</option>
				<option value="38">Gran Almacen</option>
				<option value="39">Gran Granero</option>
			</select>
		</td>
		<td>	
			<select id="nivel<?=$c?>" onchange="getProxNivel(<?=$c?>)">
<?
			for ( $i = 0; $i < 20; $i++ ){
?>
				<option value="<?=$i?>"><?=$i?></option>
<?
			}
?>
			</select>
		</td>
		<td><span id="prox_nivel<?=$c?>"></span></td>
		<td><input type="checkbox" id="guardar<?=$c?>" <?=($nuevo)?"":"checked"?>/></td>
		<input type="hidden" id="idConstruccion<?=$c?>" value="<?=$id?>"/>
	</tr>