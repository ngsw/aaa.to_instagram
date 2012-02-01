<?php
	include_once ('./lib/instagram.php');
  include_once ('./lib/instagrammysqli.php');

  //Json改行整形
	function replace($str) {
		$str = str_replace("\n" , "\\n" , $str);
		$str = str_replace("'" , "\'" , $str);
		return $str;
	}

  //エンコード
  function html_sp($str,$encoding='UTF-8') {
    return htmlspecialchars($str , ENT_QUOTES ,$encoding);
  }

  //instagram個々の画像のUniqueID(として捉えているんだけど)
  // "http://instagra.am/p/([0-9a-zA-Z].*)"で\1をreturnしますね
  function unique_index($url_str) {
    $__url = 'http://instagr.am/p/';
    $url_index = str_replace($__url , '' ,  $url_str);
    return str_replace('/' , '' , $url_index);
  }

  //配列$_arrayにString->それをパターンとしてるだけ,
  //単純なgrep相当
  function patterns($_array) {
    foreach( $_array  as $_idxX => $_patternX ){
      if (isset($_pattern)){ 
        $_pattern = "$_pattern|$_patternX";
      } else {
        $_pattern = "$_patternX";
      }
    }
    return $_pattern;
  }

  $patterns = array(
    '#cloud',
    '#sky',
    '#sun',
    '雲',
    '空',
    '太陽'
                    );
  $pattern = patterns($patterns);
	$instagram	= 	new Instagram();
	$uri=$instagram->res_uri();
	$_json  = file_get_contents("$uri");
	$decode = json_decode($_json,true);
  $count   = count($decode['data']);
  for($i=0; $i<$count; $i++){
    $url = $decode["data"][$i]["images"]["low_resolution"]["url"];
    $alt = $decode["data"][$i]["caption"]["text"];
    $link = $decode["data"][$i]["link"];
    $linkindex = unique_index($link);
    $unixtime = $decode["data"][$i]["created_time"];
    $created_time = date( "Y/m/d H:i:s" , $unixtime );

    if ( preg_match( "/$pattern/i" , $alt )) {
      $insta = new InstagramMySQLi;
      $res  = $insta->is_uniqueindex($linkindex);
      if ( $res ) {
        $insta->insta_insert( $url , $alt , $link , $linkindex , $created_time );
      }
      echo <<< TEST
  $url<br /> 
  $alt <br /> 
  $link<br /> 
  $linkindex<br /> 
  $created_time<br /> 
TEST;
    }
  }
