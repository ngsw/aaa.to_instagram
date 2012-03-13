<?php
	include_once ('../lib/instagram.php');
  include_once ('../lib/instagrammysqli.php');

  $insta = new InstagramMySQLi;
  $insta->insta_header();
  $insta->insta_rand();
  $insta->insta_footer();
