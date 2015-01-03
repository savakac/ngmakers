// Pridanie triedy active pre rodicov s odkazom a
$(document).ready(function(){
	$("#uvod a:contains('uvod')").parent().addClass("active");

});

function activClassPage() {
	var active = document.title;
	var text = "";
	var i;

	for (i = 0; i < active.length; i++) {
		if (active[i] == ' ') break;
		else text += active[i];
	}

	if (text == "Úvod") {
		$(document).ready(function(){
			$("#active1").parent().addClass("active");
		});
	} else if (text == "Blog") {
		$(document).ready(function(){
			$("#active2").parent().addClass("active");
		});
	} else if (text == "Kontakt") {
		$(document).ready(function(){
			$("#active3").parent().addClass("active");
		});
	}
	else {
		$(document).ready(function(){
			$("#active1").parent().removeClass("active");
			$("#active2").parent().removeClass("active");
			$("#active3").parent().removeClass("active");
		});
	}
}

function alertMessage() {
	alert("Alert message!");
	document.getElementById("out").innerHTML = "This is out.";
}