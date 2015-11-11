<?php

function isSiteAvailable($url)
{
  $url = filter_var($url, FILTER_SANITIZE_URL);

//check, if a valid url is provided
if(!filter_var($url, FILTER_VALIDATE_URL))
{
$url = "http://" . $url;
if(!filter_var($url, FILTER_VALIDATE_URL))
{
return 'URL provided wasnt valid';
}
}

//make the connection with curl
$cl = curl_init($url);
curl_setopt($cl,CURLOPT_CONNECTTIMEOUT,10);
curl_setopt($cl,CURLOPT_HEADER,true);
curl_setopt($cl,CURLOPT_NOBODY,true);
curl_setopt($cl,CURLOPT_RETURNTRANSFER,true);

//get response
$response = curl_exec($cl);

// Check if any error occurred
if(!curl_errno($cl))
{
$info = curl_getinfo($cl);

$milliseconds = floor($info['total_time'] * 1000);

$mess = 'It took ' . $milliseconds . ' ms to get a ' . $info['http_code'] . ' response code from ' . $url;
}

curl_close($cl);

$remove = 'http://';
$cleanurl = str_replace($remove, '', $url);

if ($response) return '<i class="em em---1 animated tada infinite"></i><p> Good news! <a href='.$url.'>'.$cleanurl.' </a> is up!</p><p class="smallish">'.$mess.'</p> <p class="smallish"><a href="/">Check another?</a> </p>';

return '<i class="em em-cry animated pulse infinite"></i><p> Oh no! <a href='.$url.'>'.$cleanurl.' </a> seems to be down.</p><p class="smallish">'.$mess.'</p> <p class="smallish"><a href="/">Check another?</a> </p>';
}

// check if site exists / is up
if($_GET['url']){

$response = isSiteAvailable($_GET['url']);
$message = '<div class="response">'.$response.'</div>';
}

?>
<?php
  function curPageURL() {
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
      $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
      $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
  }
  ?>

<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>
    <?php if (isset($message)) : ?>
    <?php echo htmlspecialchars($_GET["url"]) . ' - ';?>
    <?php endif; ?>
    Check if a website is up or down - upor.me
  </title>
  <meta name="description" content="Check if a website is up!">

  <meta name="author" content="Flynntes">

  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>

  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

  <link rel="icon" href="/favicon.ico" type="image/x-icon">

  <link rel="stylesheet" href="static/style.css">

  <link rel="stylesheet" href="static/animate.min.css">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

  <link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

  <script type="text/javascript">
  <!--jQuery overlay code-->
  $(document).ready(function () {
  $('.toggle1').click(function () {
      $('#fading1').fadeOut(200);
      $('#overlay').fadeIn(200);
  });
  $('.toggle2').click(function () {
      $('#overlay').fadeOut(200);
      $('#fading1').fadeIn(200);
  });
  });
  </script>

  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>

<body>
  <div class="">
  <div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4";
    fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
  </script>


  <form action="" method="get">
    <div id="container">
      <?php if (isset($message)) : ?>
      <?php echo $message;?>
      <div id="socials">
        <ul class="social">
          <li>
            <a href="https://twitter.com/share" class="twitter-share-button" data-text="<?php if (isset($message)) : ?><?php echo htmlspecialchars($_GET["url"]);?><?php endif; ?> is down right now!" data-via="uporme" data-related="uporme" data-hashtags="websitedown" data-dnt="true">Tweet</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
            </script>
          </li>
          <li>
            <div class="fb-share-button fb" data-href="<?php echo curPageURL();?>" data-layout="button_count"></div>
          </li>
          <li>
            <a href="https://twitter.com/uporme" class="twitter-follow-button" data-show-count="false">Follow @uporme</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
          </li>
        </ul>
      </div>
      <?php else : ?>
        <div id="website">
          <p>is <input name="url" type="text" id="input" onfocus="this.placeholder = 'flynntes.com'" placeholder="flynntes.com" onblur="this.placeholder = 'flynntes.com'" value="<?php echo $_GET['url'];?>" /> up or is it <input type="submit" id="submit" value="just me?" /></p><hr>
          <p class="tiny">&copy; 2015 upor.me | <a type="" class="toggle1">info</a></p>
        </div>
      <?php endif; ?>
      <br>
      <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
      <!-- uporme -->
      <ins class="adsbygoogle"
        style="display:inline-block;width:320px;height:100px"
        data-ad-client="ca-pub-3591098827628231"
        data-ad-slot="9530876101"></ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
  </form>
  <div id="overlay">
    <div id="content">
      <p class="title">upor.me</p>
      <p class="sub">Check if a website is up or down.</p>
      <h1 class="white padtop">About</h1><hr class="overhr">
      <p class="white">upor.me is a simple &amp; free service that enables you to check if a website is up. Just put your url into the url field and hit enter! We'll then tell you if your website is up or down! We'll also tell you the response code from the site and how long it took to load! You can then share your result on twitter and facebook.</p>
      <h1 class="white padtop">Privacy Policy</h1><hr class="overhr">
      <p>upor.me collects some anonymous details about our visitors. This information includes the ip address, time of visit, referrer, broad demographic region, user agent and ISP. These details are provided by the user's software and this information is used to analyse trends, administer the site and track broad aggregated user movement and demographics.</p>
      <p>upor.me uses Adsense to publish ads on the site. You can read more about Adsense <a href="http://adsense.com">here</a>. You can also learn about how to opt-out of targeted ads <a href="https://support.google.com/adsense/answer/142293?hl=en">here</a>.</p>
      <p>upor.me also uses Google Analytics to track user engagement on the site. You can learn more about Google Analytics and opt-out <a href="https://tools.google.com/dlpage/gaoptout?hl=en ">here</a>.</p>
      <p>upor.me uses cookies on the site. You can learn about disabling these <a href="http://www.aboutcookies.org/">here</a>.</p>
      <h1 class="white padtop">Contact</h1><hr class="overhr">
      <p>Want to say hi? You can tweet us!</p>
      <a href="https://twitter.com/intent/tweet?screen_name=uporme&text=Hey!%20Love%20the%20site!" class="twitter-mention-button" data-size="large" data-related="uporme">Tweet to @uporme</a>
      <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
      <div id="spacer"></div>
      <p>Made with <i class="em em-heart animated swing infinite"></i> by <a href="http://twitter.com/flynntes">@flynntes</a>. &copy; 2015 upor.me</p>
      <a type="button" class="toggle toggle2"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
    </div>
  </div>
</div>
</body>
</html>
