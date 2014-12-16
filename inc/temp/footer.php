</div> <!-- main container #wrap -->


<!-- modals -->
<div id="modal-box"></div>
<div id="bg"></div>
<div id="query"></div>

<div class="footer"><a href="/">&copy; Quizr 2013</a> | <a href="/about">The Quizr Team</a></div>

<?php
	if($_SERVER['SERVER'] == "live")
	{
?>
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-37061794-1']);
	  _gaq.push(['_trackPageview']);

	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>
<?php
	}
?>

</body>
</html>