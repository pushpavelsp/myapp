<?php
  // software security settings starts
  ini_set('session.cookie_httponly', 1);
  ini_set('session.use_only_cookies', 1);
  session_set_cookie_params(['samesite' => 'None']);

  ini_set('session.use_only_cookies', TRUE);
  ini_set('session.use_trans_sid', FALSE);

  header('X-Frame-Options: DENY');
  header('X-Frame-Options: SAMEORIGIN');
  header('X-Content-Type-Options: nosniff');

  header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
  header("Pragma: no-cache"); // HTTP 1.0.
  header("Expires: 0");

  header("Cache-Control: private");
  header("Cache-Control: no-cache");
  header("Cache-Control: no-store");
  header("Cache-Control: must-revalidate");
  header("Pragma: no-cache");

  header("Content-Security-Policy: default-src 'self' 'unsafe-inline'");
  header("strict-transport-security: max-age=2592000");
  header('Referrer-Policy: same-origin');
  session_start(['cookie_lifetime' => 43200,'cookie_secure' => true,'cookie_httponly' => true]);

 // software security settings ends
?>