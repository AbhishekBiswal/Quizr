$(document).ready(function(){

	$(".skip-btn").click(function(a){
		a.preventDefault();
		var oldVal = $("#play-quiz-form input[type=submit]").val();
		$("#play-quiz-form input[type=submit]").val("Please Wait.");
		var action = $("form").attr("/play/skip.php");
		var postData = $(this).serialize();
		$("input").prop('disabled', true);
		$.ajax({
			url: action,
			type: "POST",
			data: postData,
			cache: false,
			success: function(msg){
					$("form input[type=submit]").val(oldVal);

					$("#query").html(msg).fadeIn();

					$("p.submitinfo").html(msg).fadeIn();
					$("input").prop('disabled', false);
			}
		})
	});

	$(".clear-notifs").click(function(a){
		a.preventDefault();
		$.post("/ajax/clearn.php", "all=1", function(data)
			{
				$("#query").html(data);
			}
		);
	})

	$(".del-question").click(function(a){
		a.preventDefault();
		var questionID = $(this).attr("id");
		var qID = $(this).attr("data-qid");
		var dataToSend = "id="+questionID+"&qid="+qID;
		$.post("/ajax/del-question.php", dataToSend, function(data)
		{
			$(".footer").html(data);
		});
	})

	$('form.ajax') 
    .livequery('submit', function(e) { 
        e.preventDefault();
		var oldVal = $("form input[type=submit]").val();
		$("form input[type=submit]").val("Please Wait.");
		var action = $(this).attr("action");
		var postData = $(this).serialize();
		$("input").prop('disabled', true);
		$.ajax({
			url: action,
			type: "POST",
			data: postData,
			cache: false,
			success: function(msg){
					$("form input[type=submit]").val(oldVal);

					$("#query").html(msg).fadeIn();

					$("p.submitinfo").html(msg).fadeIn();
					$("input").prop('disabled', false);
			}
		})
    });

    $(".promote-open").click(function(a){
    	a.preventDefault();
    	$(".promote-box").slideToggle();
    });

	/*ajax*/
	/*$("form.ajax").submit(function(e){
		e.preventDefault();
		var oldVal = $("form input[type=submit]").val();
		$("form input[type=submit]").val("Please Wait.");
		var action = $(this).attr("action");
		var postData = $(this).serialize();
		$.ajax({
			url: action,
			type: "POST",
			data: postData,
			cache: false,
			success: function(msg){
					$("form input[type=submit]").val(oldVal);

					$("#query").html(msg).fadeIn();

					$("p.submitinfo").html(msg).fadeIn();
			}
		})
	});*/

	$(".add-answer").click(function(e){
		e.preventDefault();
		var divID = $(this).attr("id");
		$("div#"+divID).slideDown();
		//$(this).html("Remove").addClass("rem-answer");
		$(this).hide();
	})

	$(".quiz-option").click(function(e){
		e.preventDefault();
		var id = $(this).attr("id");
		var id = $(".q").val();
		var quizData = "option="+id+"&id="+id;
		$.ajax({
			url: "sub.php",
			type: "post",
			data: quizData,
			cache: false,
			success: function(got)
			{
				$("#quiz-area").html(got);
			}
		})
	});

	// add-hint:
	$("a.add-image").click(function(){
		if($("a.add-image").hasClass("add-image"))
		{
			$(this).removeClass("add-image");
			$(this).addClass("remove-image");
			$(this).html("Remove Image");
			$("div.add-image").slideDown();
		}
		else
		{
			$("q-image").val("");
			$(this).removeClass("remove-image");
			$(this).addClass("add-image");
			$(this).html("Add Image");
			$("div.add-image").slideUp();
		}
	}); // button add-hint click

	$("a.add-hint").click(function(){
		if($("a.add-hint").hasClass("add-hint"))
		{
			$(this).removeClass("add-hint");
			$(this).addClass("remove-hint");
			$(this).html("Remove Hint");
			$("div.add-hint").slideDown();
		}
		else
		{
			$("q-hint").val("");
			$(this).removeClass("remove-hint");
			$(this).addClass("add-hint");
			$(this).html("Add Hint");
			$("div.add-hint").slideUp();
		}
	}); // button add-hint click

	// dropdown
	$("a.dropit").click(function(e){
		e.preventDefault();
		if($("li.dropit").hasClass("open"))
		{
			$("li.dropit").removeClass("open");
			$("li.dropit ul").fadeOut('fast');
		}
		else
		{
			$("li.dropit").addClass("open");
			$("li.dropit ul").fadeIn('fast');
		}
	});

	$(".view-hint-button").click(function(e){
		e.preventDefault();
		var id = $(this).attr("id");
		var hintData = "id="+id;
		$.ajax({
			url: '/ajax/hint.php',
			data : hintData,
			type : 'post',
			success : function(result)
			{
				$(".area-hint").html(result);
			}
		})
	})

	$(".like-btn").click(function(e){
		e.preventDefault();
		var quizid = $(this).attr("id");
		var data = "quizid="+quizid;
		$.ajax({
			url: '/ajax/like.php',
			data : data,
			type : 'post',
			success : function(result)
			{
				$("#query").html(result);
			}
		})
	})

	$("form.search").submit(function(a)
	{
		a.preventDefault();
		var searchTerm = $("input[name=search-term]").val();
		$("input").attr("disabled","disabled");
		$.post("/ajax/search.php", "search-term="+searchTerm, function(data)
			{
				$(".search-result").html(data);
			}
		);
		$("input").removeAttr("disabled");
	})

	/*$("#fav-btn").click(function(e){
		e.preventDefault();
		var id = $(this).attr("data-id");
		var hintData = "id="+id;
		$.ajax({
			url: '/ajax/fav.php',
			data : hintData,
			type : 'post',
			success : function(result)
			{
				$(".fav-btn-area").html(result);
			}
		})
	})*/

	$(".leaderb tr:even").addClass("tr-even");
	$(".quiz-lb tr:even").addClass("quiz-lb-even");
	$(".browse-quizzes li:even").addClass("br-even");
	$(".det-head").after('<div class="notif"></div>');


}); // ready

function notify(text)
{
	$(".notif").slideUp();
	$(".notif").html(text);
	$(".notif").slideDown();
}

$(document).ready(function(){
      function slideout(){
	  setTimeout(function(){
	  $("#response").slideUp('slow', function () {
	      });
	 
	}, 2000);}
	 
	    $("#response").hide();
	    $(function() {
	    $("#list ul").sortable({ opacity: 0.8, cursor: 'move', update: function() {
	 
	            var order = $(this).sortable('serialize') + '&update=update';
	            $.post('/ajax/updseq.php', order, function(theResponse){
	                $("#response").html(theResponse);
	                $("#response").slideDown('slow');
	                slideout();
	            });
	        	}
	        	});
	    });
 
});