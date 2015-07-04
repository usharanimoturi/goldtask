// JavaScript Document



$(".product_content").hide();
$("#promotions_content").hide();
$(document).ready(function() {
	$(".menu_content_1").hide();
	$("#doctor").click(function(){
	$("#doctor_content").slideToggle("slow");
	$("#product_content").slideUp("slow");
	$("#promotions_content").slideUp("slow");
	$("#reviews_content").slideUp("slow");
	$("#faqs_content").slideUp("slow");
	$("#events_content").slideUp("slow");
	
	});
	
});

$(document).ready(function() {
	
	$("#product").click(function(){
	$("#product_content").slideToggle("slow");
	$("#doctor_content").slideUp("slow");
	$("#promotions_content").slideUp("slow");
	$("#reviews_content").slideUp("slow");
	$("#faqs_content").slideUp("slow");
	$("#events_content").slideUp("slow");
	
	});
	
});

$(document).ready(function() {
	
	$("#promotions").click(function(){
	$("#promotions_content").slideToggle("slow");
	$("#doctor_content").slideUp("slow");
	$("#product_content").slideUp("slow");
	$("#reviews_content").slideUp("slow");
	$("#faqs_content").slideUp("slow");
	$("#events_content").slideUp("slow");
	
	});
	
});

$(document).ready(function() {
	
	$("#reviews").click(function(){
	$("#reviews_content").slideToggle("slow");
	$("#doctor_content").slideUp("slow");
	$("#product_content").slideUp("slow");
	$("#promotions_content").slideUp("slow");
	$("#faqs_content").slideUp("slow");
	$("#faqs_content").slideUp("slow");
	$("#events_content").slideUp("slow");
	
	});
	
});

$(document).ready(function() {
	
	$("#faqs").click(function(){
	$("#faqs_content").slideToggle("slow");
	$("#doctor_content").slideUp("slow");
	$("#product_content").slideUp("slow");
	$("#reviews_content").slideUp("slow");
	$("#promotions_content").slideUp("slow");
	$("#events_content").slideUp("slow");
	
	});
	
});

$(document).ready(function() {
	
	$("#events").click(function(){
	$("#events_content").slideToggle("slow");
	$("#doctor_content").slideUp("slow");
	$("#product_content").slideUp("slow");
	$("#reviews_content").slideUp("slow");
	$("#promotions_content").slideUp("slow");
	$("#faqs_content").slideUp("slow");
	
	});
	
});


$(".career_content").hide();
$(document).ready(function(){
  $(".career").click(function(){
    $(".career_content").slideToggle("slow");
  });
});


// locations start

$("#carrollton_content").hide();
$(document).ready(function(){
	
	$("#carrollton").click(function(){
	$("#carrollton_content").slideToggle("slow");
	$("#plano_content").slideUp("slow");
	$("#mckinney_content").slideUp("slow");
	$("#preston_content").slideUp("slow");
		
		});
		
	$("#plano").click(function(){
	$("#plano_content").slideToggle("slow");
	$("#carrollton_content").slideUp("slow");
	$("#mckinney_content").slideUp("slow");
	$("#preston_content").slideUp("slow");
		
		});	
		
	$("#mckinney").click(function(){
	$("#mckinney_content").slideToggle("slow");
	$("#carrollton_content").slideUp("slow");
	$("#plano_content").slideUp("slow");
	$("#preston_content").slideUp("slow");
		
		});	
		
	$("#preston").click(function(){
	$("#preston_content").slideToggle("slow");
	$("#carrollton_content").slideUp("slow");
	$("#plano_content").slideUp("slow");
	$("#mckinney_content").slideUp("slow");
		
		});	
	
	
});


