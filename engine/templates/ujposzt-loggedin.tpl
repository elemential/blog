<form method="post">
	<h1>Új bejegyzés</h1>
	<table>
		<tr>
			<td>Cím:</td>
			<td><input type="text" name="poszt_cime"></td>
		</tr>
		<tr>
			<td>Tartalom:</td>
			<td>
				<textarea name="poszt_tartalma"></textarea>
			</td>
		</tr>
		<tr>
			<td>Cimkék:</td>
			<td>
				<input type="text" name="poszt_cimkek" />
			</td>
		</tr>
		<tr>
			<td></td>
			<td><input type="checkbox" name="hsz_lehet"> Hozzászólások engedélyezése</td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="Bejegyzés létrehozása"></td>
		</tr>
	</table>
</form>