<?php
class InstagramMySQLi extends MySQLi
{
    const NUMBER_OF_DISPLAY = 48 ;

    public function __construct()
    {
      require('/home/sites/aaa.to' . '/instagram_dbaccount.php');
          $dbhost  = $CONF['dbhost'];
          $dbuser  = $CONF['dbuser'];
          $dbpass  = $CONF['dbpass'];
          $dbname  = $CONF['dbname'];
          $dbport  = $CONF['dbport'];

      parent::__construct( $dbhost , $dbuser , $dbpass , $dbname , $dbport);
    }
   
    private static function  instagram_stmt( $query )
    {
        return "$query ";
    }
   
    public function prepare( $query  )
    {
        return parent::prepare( $this->instagram_stmt($query) );
    }
 
    public function query( $query )
    {
        return parent::query( $this->instagram_stmt($query) );
    }

    public function is_uniqueindex( $linkindex )
    {
      $sql = "SELECT COUNT( linkindex ) FROM instagram WHERE linkindex=?";
      $stmt = $this->prepare( $sql );
      $stmt->bind_param("s",$linkindex);
      $stmt->execute();
      $stmt->bind_result($count);
      $stmt->fetch();
      if ( $count == 0 ) {
        return TRUE ;
      } else {
        return FALSE ;
      }
    }

    public function insta_insert($url , $alt , $link , $linkindex , $created_time)
    {
      $sql = "INSERT INTO instagram SET
                url             =? ,  
                alt             =? ,
                link            =? ,
                linkindex       =? ,
                created_time    =? ";
      
      $stmt = $this->prepare( $sql );
      $stmt->bind_param('sssss',$_url,$_alt,$_link,$_linkindex,$_created_time);

      $_url           = $url ;
      $_alt           = $alt ;
      $_link          = $link ;
      $_linkindex     = $linkindex ;
      $_created_time  = $created_time ;

      $stmt->execute();
      $stmt->close();
    }

    public function insta_views(){
      $a = 0;
      $i =  self::NUMBER_OF_DISPLAY;
      //DEBUG
      /*      $allsql = "SELECT * FROM instagram"; */
      $sql = "SELECT * FROM instagram instagram ORDER BY RAND() LIMIT 0, $i";
      $stmt = $this->prepare( $sql );
      $stmt->execute();
      $stmt->bind_result( $id , $url , $alt , $link , $linkindex , $created_time );
      while ( $stmt->fetch() ){
        $b=$a++ ;
 echo <<<HTMLEOF

   <p class="picture">
      <a href='$link' target="_blank">
        <img src='$url'
           width="260"
          height="260"
             alt="$alt"
           title="$created_time || $alt" />
      </a>
   </p>

HTMLEOF;
      }
      $stmt->close();
    }
    
     public function insta_count(){
      $i = self::NUMBER_OF_DISPLAY;
      $sql = "SELECT COUNT(*) FROM instagram";
      $stmt = $this->prepare( $sql );
      $stmt->execute();
      $stmt->bind_result( $num_rows );
      while ( $stmt->fetch() ){
      $pages = floor($num_rows / $i ) ;
echo <<<HTMLEOF
<br />
<strong><font size='+10'>This site is not yet completed.</font></strong><br />
<h2><strong><font size='+10'>SELECT COUNT(*) FROM _TABLE #=> (´・ω・`)つ $num_rows</font></strong></h2>
<h2><strong><font size='+10'>MAX $pages pages</font></strong></h2>
HTMLEOF;
      }
      $stmt->close();
    }
   
    public function insta_header(){
      $numdisplay = self::NUMBER_OF_DISPLAY;
echo <<<HTMLHEADER
<!DOCTYPE html><html>
  <head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta content="text/css" http-equiv="Content-Style-Type">
    <meta content="text/javascript" http-equiv="Content-Script-Type">
    <title>CloudCloudCloud</title>
    <link href="/style.css" rel="stylesheet" type="text/css">
    <link href="/cat/favicon.ico" rel="shortcut icon">
  </head>
  <script type="text/javascript" src="jquery.js"></script>
  <script>
  $(function(){
    var num = 0;
    var interval = 4000;
    setInterval(function(){
      $(".picture:eq(" + num++  + ")").fadeOut("3500");
      $(".picture:eq(" + num++  + ")").fadeOut("3500");
      $(".picture:eq(" + num++  + ")").fadeOut("3500");
      $(".picture:eq(" + num++  + ")").fadeOut("3500");
      if( num >=  $numdisplay ){ window.location.reload();} 
    },interval);
  });

  </script>
  <body>
  <div id="header">
  </div>
  <div id="wrapper">
  <div id="boxLeft">
  </div>
  <div id="boxCenter"><!-- boxCenter -->
HTMLHEADER;
    }

    public function insta_footer(){
echo <<<HTMLFOOTER
  </div><!-- boxCenter -->
  <div id="boxRight">
  </div>
  </div><!-- wrapper -->
  <div id="boxFooter">
  <a href="https://twitter.com/#!/ngsw">@ngsw</a>
  <!-- えんじんえっくす まいしーくぇる ぺちぺー and Instagr.am --> 
  </div>
  </body>
</html>
HTMLFOOTER;
    }

     public function __destruct()
    {
    }
}
