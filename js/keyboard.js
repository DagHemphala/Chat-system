// JavaScript Document

		
$(function(){
	
	
	$(".keyboard li").hover(function(){
		
			var x=Math.round(0xffffff * Math.random()).toString(16);
			var y=(6-x.length);
			var z="000000";
			var z1 = z.substring(0,y);
			var color= "#" + z1 + x;
			
			$(this).css("border-color", color);
			$(this).css("box-shadow" ,"0 0 12px "+color+"");
			}, function(){
			$(this).css("box-shadow" , "5px 5px 5px rgba(38,38,38,0.6)");
			$(this).css("border-color", "transparent");

	});
	
    var $write = $('#write'),
        shift = false,
        capslock = false;
		
	
	onload = function(){
		document.onkeypress=function(e){
		var evtobj=window.event? event : e
		var code=evtobj.charCode? evtobj.charCode : evtobj.keyCode
		var asciiStr=String.fromCharCode(code);
		var list = document.getElementsByTagName("ul")[0];
		var listan = list.getElementsByTagName("li")
		$write.html($write.html() + asciiStr );
	  
		}
	}
	
    $('.keyboard li').click(function(){
        var $this = $(this),
        character = $this.html(); 
	
	
			   
			// Shift keys
        if ($this.hasClass('left-shift') || $this.hasClass('right-shift')) {
            $('.letter').toggleClass('uppercase');
            $('.symbol span').toggle();
            
            shift = (shift === true) ? false : true;
            capslock = false;
            return false;
        }
         
        // Caps lock
        if ($this.hasClass('capslock')) {
            $('.letter').toggleClass('uppercase');
            capslock = true;
            return false;
        }
		
		// Delete
        if ($this.hasClass('delete')) {
            var html = $write.html();
             
            $write.html(html.substr(0, html.length + 1));
            return false;
        }
		
        // Backspace
        if ($this.hasClass('backspace')) {
            var html = $write.html();
             
            $write.html(html.substr(0, html.length - 1));
            return false;
        }
         
        // Special characters
        if ($this.hasClass('symbol')) character = $('span:visible', $this).html();
        if ($this.hasClass('space')) character = ' ';
        if ($this.hasClass('tab')) character = "\t";
        if ($this.hasClass('return')) character = "\n";
         
        // Uppercase letter
        if ($this.hasClass('uppercase')) character = character.toUpperCase();
         

        if (shift === true) {
            $('.symbol span').toggle();
            if (capslock === false) $('.letter').toggleClass('uppercase');
             
            shift = false;
        }
         
        // Add the character
        $write.html($write.html() + character );
    });
});