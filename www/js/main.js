// Pridanie triedy active pre rodicov s odkazom a
$(document).ready(function(){
	$("#uvod a:contains('uvod')").parent().addClass("active");

});

$(function(){

});

function activClassPage() {
	var active = document.getElementById("title");

	if (active == "Úvod") {
		$(document).ready(function(){
			$("#active1").addClass("active");
		});
	} else if (active == "Blog") {
		$(document).ready(function(){
			$("#active2").addClass("active");
		});
	} else {
		$(document).ready(function(){
			$("#active2").addClass("active");
		});
	}
}