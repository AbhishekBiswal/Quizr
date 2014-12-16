<?php

	function browseLoad($fetch)
	{
		while($data = $fetch->fetch())
		{
	?>

		<li>
			<div class="columns ten">
			<h3><a href="/q/?id=<?php echo $data['id']; ?>/"><?php echo $data['title']; ?></a></h3>
			<p class="description"><a href="/browse/<?php echo $data['cat']; ?>/"><?php echo checkCat($data['cat']); ?></a> - <?php echo $data['qdesc']; ?></p>
			<div class="quiz-info">
				<span><a href="/q/?id=<?php echo $data['id']; ?>">Permalink</a></span>
			</div>
			</div>
			<div class="columns three">
				<div class="br-info">
					<span class="number"><?php echo $data['plays']; ?></span>
					<span class="number-text">Plays</span>
				</div>
				<div class="br-info">
					<span class="number"><?php echo $data['likes']; ?></span>
					<span class="number-text">Likes</span>
				</div>
			</div>
		</li>

	<?php
		}
	}

	
	function browseCat($cat, $what, $DBH)
	{
		if($cat == "") $cat=0;
		if($cat != 0)
		{
			if($what == "popular")
			{
				$fetch = $DBH->prepare("SELECT * FROM quizmeta WHERE cat=? AND pub= 1 ORDER BY plays DESC LIMIT 30");
				$fetch->execute(array($cat));
			}
			else
			{
				$fetch = $DBH->prepare("SELECT * FROM quizmeta WHERE cat=? AND pub = 1 ORDER BY likes DESC LIMIT 30");
				$fetch->execute(array($cat));
			}
		}
		else
		{
			if($what == "popular")
			{
				$fetch = $DBH->prepare("SELECT * FROM quizmeta WHERE pub = 1 ORDER BY plays DESC LIMIT 30");
				$fetch->execute();
			}
			else
			{
				$fetch = $DBH->prepare("SELECT * FROM quizmeta WHERE pub = 1 ORDER BY likes DESC LIMIT 30");
				$fetch->execute();
			}
		}
		browseLoad($fetch);

	}

	function checkCat($cat)
	{
		if($cat == 0) return "All";
		elseif($cat == 1) return "General";
		elseif($cat == 2) return "Tech";
		elseif ($cat == 3) return "Gaming";
		elseif ($cat == 4) return "Sports";
		elseif ($cat == 5) return "History";
		elseif ($cat == 6) return "Science";
		elseif ($cat == 7) return "Music";
		elseif ($cat == 8) return "Misc";
		else return false;
	}

?>