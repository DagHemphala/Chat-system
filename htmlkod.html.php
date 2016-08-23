<?php
if (!isset($checkphp))
{
	header('Location: index.php');
}

?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Virtuellt tangentbord</title>
<link href="favicon.ico" rel="icon" type="image/x-icon" />

<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="js/keyboard.js"></script>
<script type="text/javascript" src="js/main.js"></script>

 <?php if(isset($_SESSION['lang'])): ?> 
	<?php if($_SESSION['lang']=='sv'): ?> 
    	<script type="text/javascript" src="js/sv.js"></script>
    <?php endif; ?>
    
    <?php if($_SESSION['lang']=='en'): ?> 
        <script type="text/javascript" src="js/en.js"></script>
    <?php endif; ?>
<?php endif; ?>
<?php if(isset($_SESSION['error_msg'])): ?> 
<script>
$(document).ready(function() {
	$('#exit').click(function(){	
		window.location.href = "?logout=1";
	 
	 });
});
</script>

<?php endif; ?>

<link href='https://fonts.googleapis.com/css?family=Averia+Sans+Libre' rel='stylesheet' type='text/css'>

<link href="css/main.css" rel="stylesheet" type="text/css">
<link href="css/login.css" rel="stylesheet" type="text/css">
 
</head>


<body OnKeyPress="key(event)">
<div id="wrapper">
	<div id="topborder">
        <div id="login" class="log"><a href"#">Logga in</a></div>
        
        
        
        <?php if(isset($_SESSION['username'])): ?> 
            <script>
                document.getElementById("login").style.display="none";
            </script>
            <p id="logout" class="log"><a href="?logout=1">Logga ut</a></p>
            <p id="user">You are logged in as <?=$_SESSION['username']?></p>
            <div id="loginmeny">
            <ul>
                <li> <a id="navprofile" href="#">Profil</a></li>
            </ul>
            </div><!-- End loginmeny -->
          <?php endif; ?>
     </div>
	<div id="popup"> 
    	<div id="contain">
        	<div id="exit">X
        </div>
        
        <div id="loggain" style="display: block;">
                <h3>Logga in</h3>
                <form action="" method="post">
                    <p class="u">Användarnamn<p><input type="username" name="username" pattern="^[a-öA-Ö][a-öA-Ö0-9-_\.]{8,20}$" required>
                    <p class="p">Lösenord</p><input type="password" name="password" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Ö])(?=.*[a-ö]).*$" required>
                    <?php if(isset($_SESSION['error_msg'])): ?> 
                    <script>
						$('#popup').css( "display", "block");
					</script>
                    <?php echo '<p style="color: red; font-weight: bold;">'. $_SESSION['error_msg']. '</p>' ?>
                    <?php endif; ?>
                    <button id="log_button" type="submit">Logga in</button>
                    <a href="#" onClick="$(document).ready(function() { $('#registrera').fadeToggle('fast'); $('#loggain').hide(); });">Har inget konto?</a>					
                </form>
        </div>
        <div id="registrera" style="display: none;">
               <h3>Registrera</h3>
               <form method="post" action="">
                    <p id="e">E-mejl</p><input type="email" name="email" id="email" placeholder="E-mail" pattern="[a-ö0-9._%+-]+@[a-ö0-9.-]+\.[a-ö]{2,3}$" required>
                    <p class="u">Användarnamn</p><input type="username" name="username2" pattern="^[a-öA-Ö][a-öA-Ö0-9-_\.]{8,20}$" required>
                    <p class="p">Lösenord</p><input type="password" name="password2" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Ö])(?=.*[a-ö]).*$" required>
                    <input type="hidden" name="register" value="upload"/>
                    
                   	<button id="reg_button" type="submit">Registrera</button>
                   	<a href="#" onClick="$(document).ready(function() { $('#loggain').fadeToggle('fast'); $('#registrera').hide(); });">Har redan ett konto?</a>
				</form>
        </div>
        <?php if(isset($_SESSION['username'])): ?> 
            <div id="profile">
                <h3>Profil</h3>
               		<form action="" method="post" enctype="multipart/form-data">
                     <?php foreach($info as $myinfo): ?>
                        <?php
							if ($myinfo['user'] == $_SESSION['username'])
							{
								echo '<img id="uploadimgsrc" class="profile-img" src="'.$myinfo['src'].'" />';
								echo htmlspecialchars($myinfo['user']. ' ' . $myinfo['email']. ' ' , ENT_QUOTES, 'UTF-8');
								echo '<input style="visibility: hidden;" type="file" id="upload" name="upload"/>';
							}
                            ?>
                    <?php endforeach;?>                     
                        <br>
                        <br>
                        <br>
                        <br>
                    	<input type="hidden" name="change" value="upload"/>
   						
    					<button id="bild_update" type="submit">Updatera</button>
                    </form>
                
            </div>
        <?php endif; ?>
        </div>
    	
	</div>
    
    <div id="container">
    	<!-- Meddelanden -->
        <?php if(isset($message)): ?> 
        <?php foreach($message as $mymessage): ?>   
    	<div class="sent">
		        
                <div class="text"><?php echo nl2br($mymessage['message']) ?></div>
                <div class="bubble">
                <?php foreach($info as $myinfo): ?>
                    <?php if ($myinfo['profileimgid'] == $mymessage['usernameid']):?>
                        <img src="<?php echo $myinfo['src'] ?>" alt="">
                     <?php endif;?>
                 <?php endforeach;?> 
                </div>
                <div class="name">
                <?php foreach($info as $myinfo): ?>
                    <?php if ($myinfo['usernameid'] == $mymessage['usernameid']):?>
                        <?php echo $myinfo['user'] ?>
                     <?php endif;?>
                 <?php endforeach;?> 
                </div>         
        </div>
        <?php endforeach;?>
        <?php endif;?>
        
        	
        <form action="" method="post" enctype="multipart/form-data">
        <textarea name="input" id="write" rows="6" cols="60"></textarea>
        
        <?php if(isset($_SESSION['username'])): ?>
            <br>
            <input type="hidden" name="message" value="upload"/>            
            <button id="send_button" type="submit">Skicka</button>
        <?php endif; ?>
        </form>
        
        <ul id="Sv" class="keyboard">
            <li class="symbol"><span id="" class="off">§</span><span class="on">½</span></li>
            <li class="symbol"><span class="off">1</span><span class="on">!</span></li>
            <li class="symbol"><span class="off">2</span><span class="on">"</span></li>
            <li class="symbol"><span class="off">3</span><span class="on">#</span></li>
            <li class="symbol"><span class="off">4</span><span class="on">¤</span></li>
            <li class="symbol"><span class="off">5</span><span class="on">%</span></li>
            <li class="symbol"><span class="off">6</span><span class="on">&amp;</span></li>
            <li class="symbol"><span class="off">7</span><span class="on">/</span></li>
            <li class="symbol"><span class="off">8</span><span class="on">(</span></li>
            <li class="symbol"><span class="off">9</span><span class="on">)</span></li>
            <li class="symbol"><span class="off">0</span><span class="on">=</span></li>
            <li class="symbol"><span class="off">+</span><span class="on">?</span></li>
            <li class="symbol"><span class="off">´</span><span class="on">`</span></li>
            <li class="delete lastitem">delete</li>
            <li class="tab">tab</li>
            <li class="letter">q</li>
            <li class="letter">w</li>
            <li class="letter">e</li>
            <li class="letter">r</li>
            <li class="letter">t</li>
            <li class="letter">y</li>
            <li class="letter">u</li>
            <li class="letter">i</li>
            <li class="letter">o</li>
            <li class="letter">p</li>
            <li class="letter">å</li>
            <li class="symbol"><span class="off">¨</span><span class="on">^</span></li>
            <li class="backspace lastitem">backspace</li>
            <li class="capslock">caps lock</li>
            <li class="letter">a</li>
            <li id="3" class="letter">s</li>
            <li id="4" class="letter">d</li>
            <li class="letter">f</li>
            <li class="letter">g</li>
            <li class="letter">h</li>
            <li class="letter">j</li>
            <li class="letter">k</li>
            <li class="letter">l</li>
            <li class="letter">ö</li>
            <li class="letter">ä</li>
            <li class="symbol"><span class="off">'</span><span class="on">*</span></li>
            <li class="return lastitem">return</li>
            <li class="left-shift">shift</li>
            <li class="letter">z</li>
            <li class="letter">x</li>
            <li class="letter">c</li>
            <li class="letter">v</li>
            <li class="letter">b</li>
            <li class="letter">n</li>
            <li class="letter">m</li>
            <li class="symbol"><span class="off">,</span><span class="on">&lt;</span></li>
            <li class="symbol"><span class="off">.</span><span class="on">&gt;</span></li>
            <li class="symbol"><span class="off">-</span><span class="on">_</span></li>
            <li class="right-shift lastitem">shift</li>
            <li class="space lastitem">&nbsp;space</li>
            
        </ul><!-- End keyboard -->
            
        <ul id="En" class="keyboard" style="display: none;">
            <li class="symbol"><span class="off">`</span><span class="on">~</span></li>
        <li class="symbol"><span class="off">1</span><span class="on">!</span></li>
        <li class="symbol"><span class="off">2</span><span class="on">@</span></li>
        <li class="symbol"><span class="off">3</span><span class="on">#</span></li>
        <li class="symbol"><span class="off">4</span><span class="on">$</span></li>
        <li class="symbol"><span class="off">5</span><span class="on">%</span></li>
        <li class="symbol"><span class="off">6</span><span class="on">^</span></li>
        <li class="symbol"><span class="off">7</span><span class="on">&amp;</span></li>
        <li class="symbol"><span class="off">8</span><span class="on">*</span></li>
        <li class="symbol"><span class="off">9</span><span class="on">(</span></li>
        <li class="symbol"><span class="off">0</span><span class="on">)</span></li>
        <li class="symbol"><span class="off">-</span><span class="on">_</span></li>
        <li class="symbol"><span class="off">=</span><span class="on">+</span></li>
        <li class="delete lastitem">delete</li>
        <li class="tab">tab</li>
        <li class="letter">q</li>
        <li class="letter">w</li>
        <li class="letter">e</li>
        <li class="letter">r</li>
        <li class="letter">t</li>
        <li class="letter">y</li>
        <li class="letter">u</li>
        <li class="letter">i</li>
        <li class="letter">o</li>
        <li class="letter">p</li>
        <li class="symbol"><span class="off">[</span><span class="on">{</span></li>
        <li class="symbol"><span class="off">]</span><span class="on">}</span></li>
        <li class="symbol lastitem"><span class="off">\</span><span class="on">|</span></li>
        <li class="capslock">caps lock</li>
        <li class="letter">a</li>
        <li class="letter">s</li>
        <li class="letter">d</li>
        <li class="letter">f</li>
        <li class="letter">g</li>
        <li class="letter">h</li>
        <li class="letter">j</li>
        <li class="letter">k</li>
        <li class="letter">l</li>
        <li class="symbol"><span class="off">;</span><span class="on">:</span></li>
        <li class="symbol"><span class="off">'</span><span class="on">&quot;</span></li>
        <li class="return lastitem">return</li>
        <li class="left-shift">shift</li>
        <li class="letter">z</li>
        <li class="letter">x</li>
        <li class="letter">c</li>
        <li class="letter">v</li>
        <li class="letter">b</li>
        <li class="letter">n</li>
        <li class="letter">m</li>
        <li class="symbol"><span class="off">,</span><span class="on">&lt;</span></li>
        <li class="symbol"><span class="off">.</span><span class="on">&gt;</span></li>
        <li class="symbol"><span class="off">/</span><span class="on">?</span></li>
        <li class="right-shift lastitem">shift</li>
        <li class="space lastitem">&nbsp;</li>
        </ul><!-- End keyboard en -->
    </div><!-- End container -->
    <div id="lang"><p>Sv</p>
    	<div id="select"><div id="langsv">Svenska</div><div id="langen">Engelska</div></div>
    </div>
    
    
</div><!-- End wrapper -->

</body>
</html>
