

$(document).ready(function(){
	$("#login").hide();
	$("#dia").hide();
	$(".signUp").css("text-decoration","underline");

	$(".signUp").click(function(){
		$("#sign").show();
		$("#login").hide();		
		$(".signUp").css("text-decoration","underline");
		$(".logIns").css("text-decoration","none");
	});
	$(".logIns").click(function(){
		$("#sign").hide();
		$("#login").show();
		$(".logIns").css("text-decoration","underline");
		$(".signUp").css("text-decoration","none");
	});

	
});