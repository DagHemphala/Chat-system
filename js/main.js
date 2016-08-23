// JavaScript Document

$(function(){
 //change langues on site
 $('#langsv').click(function(){
	 
	 window.location.href = "?lang=sv";
	 
 });
 // changeg langues on site
  $('#langen').click(function(){
	  
	  window.location.href = "?lang=en"; 
	 
 });
 $('#exit').click(function(){
 	$('#popup').css( "display", "none");
	
	//window.location.href = "?logout=1";
 
 });
 
 $('#login').click(function(){
 	$('#popup').css( "display", "block");
 });
 $('#navprofile').click(function(){
 	$('#popup').css( "display", "block");
	$('#registrera').css( "display", "none");
	$('#loggain').css( "display", "none");
 });
 
 $('.profile-img').click(function(){
	$('input[type=file]').click();
	return false; 
 });
 
 $('#user').hide();

});

//preview image
function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#uploadimgsrc').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
$( document ).ready(function() {
$("#upload").change(function(){
    readURL(this);
});
});
