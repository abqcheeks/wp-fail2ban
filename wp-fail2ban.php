<?php

//
// wp-fail2ban plugin.  Record failed logins via syslog.
// Mostly copied from this post: http://abdussamad.com/archives/616-Stop-Brute-Force-WordPress-Login-Attempts-with-Fail2Ban.html
//
// See README.txt for installation and fail2ban integration notes.
//
// Mark Costlow
// cheeks@swcp.com
// 8/15/2013
//

class wp_fail2ban_special{
	const SYSLOG_FACILITY = LOG_LOCAL1;
 
	function __construct() {
		add_action( 'wp_login_failed', array( $this, 'log_failed_attempt' ) ); 
		add_action( 'wp_login', array( $this, 'log_successful' ) ); 
	}
 
	function log_failed_attempt( $username ) {
		openlog( 'wordpress('.$_SERVER['HTTP_HOST'].')', LOG_NDELAY|LOG_PID, self::SYSLOG_FACILITY );
		syslog( LOG_NOTICE, "Authentication failure for $username from {$_SERVER['REMOTE_ADDR']}" );
	}
	function log_successful( $username ) {
		openlog( 'wordpress('.$_SERVER['HTTP_HOST'].')', LOG_NDELAY|LOG_PID, self::SYSLOG_FACILITY );
		syslog( LOG_NOTICE, "Authentication succeeded for $username from {$_SERVER['REMOTE_ADDR']}" );
	}
}
 
new wp_fail2ban_special();

?>
