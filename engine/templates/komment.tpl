<article class="comment">
	<header>
		<span class="szerzo">%szerzo%</span>
		<span class="datum">%datum%</span>
	</header>
	<?
	if($szerk){
		?>
		<form action="index.php?muvelet=szerkeszt&comment_id=%comment_id%" method="post">
			<textarea placeholder="Mit szólsz hozzá?" name="comment">
		<?
	}
	?>
	%tartalom%
	<?
	if($szerk){
		?>
			</textarea>
			<input type=submit title=Frissítés>
		</form>
		<?
	}
	?>
</article>