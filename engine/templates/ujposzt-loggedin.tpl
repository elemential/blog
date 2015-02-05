<br>
<form method="post">
	<h1>Új bejegyzés létrehozása</h1>
    <br>
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
				<input type="text" name="poszt_cimkek" class="kiemel"/>
			</td>
		</tr>
		<tr>
			<td><br>Hozzászólások engedélyezése<br><br></td>
			<td><paper-checkbox name="hsz_lehet"></paper-checkbox></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="Bejegyzés létrehozása"><paper-ripple></paper-ripple></td>
		</tr>
	</table>
</form>