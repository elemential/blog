<article class="poszt">
	<header>
		<h1><a href="index.php?muvelet=poszt&poszt_id=%id%">%cim%</a></h1>
		<span class="szerzo">%szerzo%</span>
		<span class="datum">%datum%</span>
	</header>
	%tartalom%
	<div class="hozzaszolasok">%hozzaszolasok%</div>
	<div class="cimkek">
		%cimkek%
		<article class="comment">
			<form action="index.php?muvelet=szerkeszt&komment_id=0&poszt_id=%id%" method="post">
				<textarea placeholder="Mit szólsz hozzá?" name="tartalom"></textarea>
				<input type=submit value=Hozzászólok!>
			</form>
		</article>
	</div>
</article>