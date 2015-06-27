<!doctype html lang="de">
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="de"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <link rel="dns-prefetch" href="http://fonts.googleapis.com" />
    <link rel="dns-prefetch" href="http://themes.googleusercontent.com" />
    <link rel="dns-prefetch" href="http://ajax.googleapis.com" />
    <link rel="dns-prefetch" href="http://cdnjs.cloudflare.com" />
    <link rel="dns-prefetch" href="http://agorbatchev.typepad.com" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Dashboard - Bike Arena Benneker Ticket System</title>
    <meta name="description" content="Workflow System | Bikearena Benneker OHG">
    <meta name="author" content="Smootharrangement | Philipp Dallmann">
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;"> 
    <meta name="format-detection" content="telephone=no">
    <link rel="shortcut icon" href="favicon.ico" />
    
<!-- CSS -->

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/grid.css">
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/icons.css">
    <link rel="stylesheet" href="css/fonts/font-awesome.css">
    <!--[if IE 8]><link rel="stylesheet" href="css/fonts/font-awesome-ie7.css"><![endif]-->
    <link rel="stylesheet" href="css/external/jquery-ui-1.9.1.custom.css">
    <link rel="stylesheet" href="css/external/jquery.chosen.css">
    <link rel="stylesheet" href="css/external/jquery.cleditor.css">
    <link rel="stylesheet" href="css/external/jquery.colorpicker.css">
    <link rel="stylesheet" href="css/external/jquery.elfinder.css">
    <link rel="stylesheet" href="css/external/jquery.fancybox.css">
    <link rel="stylesheet" href="css/external/jquery.jgrowl.css">
    <link rel="stylesheet" href="css/external/jquery.plupload.queue.css">
    <link rel="stylesheet" href="css/external/syntaxhighlighter/shCore.css" />
    <link rel="stylesheet" href="css/external/syntaxhighlighter/shThemeDefault.css" />
    <link rel="stylesheet" href="css/elements.css">
    <link rel="stylesheet" href="css/forms.css">
    <link rel="stylesheet" href="css/print-invoice.css">
    <link rel="stylesheet" href="css/typographics.css">
    <link rel="stylesheet" href="css/media-queries.css">
    <link rel="stylesheet" href="css/ie-fixes.css">
    
 <!-- JavaScript -->
 
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.js"></script>
    <script>window.jQuery || document.write('<script src="js/libs/jquery-1.8.2.js"><\/script>')</script>
    <script src="js/libs/jquery-ui-1.9.1.js"></script>
    <script>window.jQuery.ui || document.write('<script src="js/libs/jquery-ui-1.9.1.js"><\/script>')</script>
    <!--[if gt IE 8]><!-->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/lodash.js/0.8.2/lodash.js"></script>
    <script>window._ || document.write('<script src="js/libs/lo-dash.js"><\/script>')</script>
    <!--<![endif]-->
    <!--[if lt IE 9]><script src="http://documentcloud.github.com/underscore/underscore.js"></script><![endif]-->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/require.js/2.0.6/require.js"></script>
    <script>window.require || document.write('<script src="js/libs/require-2.0.6.min.js"><\/script>')</script>
    <script type="text/javascript">
        window.WebFontConfig = {
            google: { families: [ 'PT Sans:400,700' ] },
            active: function(){ $(window).trigger('fontsloaded') }
        };
    </script>
    <script defer async src="https://ajax.googleapis.com/ajax/libs/webfont/1.0.28/webfont.js"></script>
    <script src="js/mylibs/polyfills/modernizr-2.6.1.min.js"></script>
    <script src="js/mylibs/polyfills/respond.js"></script>
    <script src="js/mylibs/polyfills/matchmedia.js"></script>
    <!--[if lt IE 9]><script src="js/mylibs/polyfills/selectivizr.js"></script><![endif]-->
    <!--[if lt IE 10]><script src="js/mylibs/polyfills/excanvas.js"></script><![endif]-->
    <!--[if lt IE 10]><script src="js/mylibs/polyfills/classlist.js"></script><![endif]-->
    <script src="js/mylibs/jquery.hashchange.js"></script>
    <script src="js/mylibs/jquery.idle-timer.js"></script>
    <script src="js/mylibs/jquery.plusplus.js"></script>
    <script src="js/mylibs/jquery.scrollTo.js"></script>
    <script src="js/mylibs/jquery.ui.touch-punch.js"></script>
    <script src="js/mylibs/jquery.ui.multiaccordion.js"></script>
    <script src="js/mylibs/number-functions.js"></script>
    <script src="js/mylibs/fullstats/jquery.css-transform.js"></script>
    <script src="js/mylibs/fullstats/jquery.animate-css-rotate-scale.js"></script>
    <script src="js/mylibs/forms/jquery.validate.js"></script>
    <script src="js/mango.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/script.js"></script>
    <script src="js/app.js"></script>
</head>

<body>

    <!-- ----------------- -->
    <!-- Some dialogs etc. -->

    <!-- The loading box -->
    <div id="loading-overlay"></div>
    <div id="loading">
        <span>Lade...</span>
    </div>
    <!-- End of loading box -->
    
    <!-- The lock screen -->
    <div id="lock-screen" title="Bildschrim gesperrt">
        
        <a href="logout.php" class="header right button grey flat">Logout</a>
        
        <p>Da Du inaktiv warst haben wir den Bildschrim aus Sicherheitsgründen gesperrt.</p>
        <p>Slide zum entsperren und gib Dein Passwort ein.</p>
        
        <div class="actions">
            <div id="slide_to_unlock">
                <img src="img/elements/slide-unlock/lock-slider.png" alt="slide me">
                <span>Entsperren</span>
            </div>
            <form action="#" method="POST">
                <input type="password" name="pwd" id="pwd" placeholder="Passwort ..." autocorrect="off" autocapitalize="off"> <input type="submit" name=send value="OK" disabled> <input type="reset" value="X">
            </form>
        </div><!-- End of .actions -->
        
    </div><!-- End of lock screen -->
    
  
    <!-- The toolbar at the top -->
    <section id="toolbar">
        <div class="container_12">
        
            <!-- Left side -->
            <div class="left">
            </div>
            <!-- End of .left -->
            
            <!-- Right side -->
            <div class="right">
                <ul>
                        
                    <li class="space"></li>
					<li><a href="javascript:void(0);" id="btn-lock"><span>--:--</span>Bildschrim sperren</a></li>
                    <li class="red"><a href="logout.php">Logout</a></li>
                </ul>
            </div><!-- End of .right -->
            
            <!-- Phone only items -->
            <div class="phone">
                

                <!-- Navigation -->
                <li><a class="navigation" href="#"><span class="icon icon-list"></span></a></li>
            
            </div><!-- End of phone items -->
            
        </div><!-- End of .container_12 -->
    </section><!-- End of #toolbar -->
    
    <!-- The header containing the logo -->
    <header class="container_12">
    
        <!-- Your logos -->
        <a href="tickets_alle.php"><img src="img/logo.png" alt="BAB" width="191" height="60"></a>
        <a class="phone-title" href="tickets_alle.php"><img src="img/logo-mobile.png" alt="BAB" height="22" width="70" /></a>
        <?php
          if(isset($_SESSION['sucess']) && $_SESSION['sucess'] != ""  ){
        ?>
          <div class="buttons" style="width: 65%;">
               <div class="alert success no-margin-top">
                    <span class="icon"></span>
                    <strong>Erfolg!</strong> <?=$_SESSION['sucess']?>
               </div>
          </div>
        <?php
               $_SESSION['sucess'] = "";
          }
          if(isset($_SESSION['error']) && $_SESSION['error'] != ""  ){
        ?>
          <div class="buttons" style="width: 65%;">
               <div class="alert error no-margin-top">
      			<span class="icon"></span>
      			<strong>Fehler!</strong> <?=$_SESSION['error']?>
      		</div>
          </div>
        <?php
               $_SESSION['error'] = "";
          }
          /*if($new > 0 && !isset($_SESSION['view'])){
               $_SESSION['view'] = "Yes"; */
        ?>
          <!--<div class="buttons" style="width: 65%;">
               <div class="alert success">
                    <span class="icon"></span>
                    <strong>Success!</strong> DU hast <?=$new?> unbeantwortetes Ticket
               </div>
          </div>-->
        <?php
          /*} */
        ?>
    </header><!-- End of header -->
