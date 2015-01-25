Bejelentkezve, mint <?= $_SESSION['f_teljes_nev'] == NULL ? $_SESSION['f_nev'] : $_SESSION['f_teljes_nev'] ?>.
    <input type="submit" value="Új poszt" onclick="location.search='?muvelet=uj_poszt'" id="newposzt">
<form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
	<input type="hidden" name="kijelentkezes" value="">
	<input type="submit" value="Kijelentkezés">
</form>