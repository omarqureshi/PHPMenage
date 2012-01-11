<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $presenter["application_name"]; ?></title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le styles -->
    <link href="/assets/stylesheets/bootstrap.min.css" rel="stylesheet">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.js" type="text/javascript"></script>
    <script src="/assets/javascripts/menage.js" type="text/javascript"></script>


    <style type="text/css">
      /* Override some defaults */
      html, body {
        background-color: #eee;
      }
      body {
        padding-top: 40px; /* 40px to make the container go all the way to the bottom of the topbar */
      }
      .container > footer p {
        text-align: center; /* center align it with the container */
      }

      /* The white background content wrapper */
      .content {
        background-color: #fff;
        padding: 20px;
        margin: 0 -20px; /* negative indent the amount of the padding to maintain the grid system */
        -webkit-border-radius: 0 0 6px 6px;
           -moz-border-radius: 0 0 6px 6px;
                border-radius: 0 0 6px 6px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.15);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.15);
                box-shadow: 0 1px 2px rgba(0,0,0,.15);
      }

      /* Page header tweaks */
      .page-header {
        background-color: #f5f5f5;
        padding: 20px 20px 10px;
        margin: -20px -20px 20px;
      }

      /* Give a quick and non-cross-browser friendly divider */
      .content .span4 {
        margin-left: 0;
        padding-left: 19px;
        border-left: 1px solid #eee;
      }

      .topbar .btn {
        border: 0;
      }

      span.topbar-connector {
        color: #808080;
        line-height: 18px;
        display: block;
        float: left;
        padding: 10px 0px 10px 10px;
      }

    </style>
    <link href="/assets/stylesheets/menage.css" rel="stylesheet">

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="/assets/images/favicon.ico">
    <link rel="apple-touch-icon" href="/assets/images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/assets/images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/assets/images/apple-touch-icon-114x114.png">
  </head>

  <body>

    <div class="topbar">
      <div class="fill">
        <div class="container">
          <a class="brand" href="/"><?php echo $presenter["application_name"] ?></a>
          <ul class="nav">
            <li class="active"><a href="/">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
          <div class="pull-right">
            <?php if (isset($current_user)) { ?>
              <ul class="secondary-nav">
                <li><a href="/users/<?php echo $current_user->_id;
                ?>/edit"><?php echo $current_user->name; ?></a></li>
                  <li>
                      <form action="/logout?return_to=<?php echo
                      $_SERVER["REQUEST_URI"]; ?>" method="post">
                          <input type="hidden" name="_method"
                                 value="DELETE" />
                          <button class="btn"
                                  type="submit">Logout</button>
                      </form>
                  </li>
              </ul>
            <?php } else { ?>
              <form action="/login?return_to=<?php echo $_SERVER["REQUEST_URI"]; ?>" method="post">
                <input class="input-small" type="text" placeholder="Email" name="email">
                <input class="input-small" type="password" placeholder="Password" name="password">
                <button class="btn" type="submit">Sign in</button>
              </form>
              <span class="topbar-connector"> or </span>
              <ul class="secondary-nav">
                  <li><a href="/users/new">Register</a></li>
              </ul>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

    <div class="container">

      <div class="content">
        <div class="page-header">
          <h1><?php echo $presenter["page_name"] ?> <small>Consumable content on the cloud</small></h1>
          <?php foreach (Flash::$messages as $type => $messages) { ?>
            <?php if (count($messages) > 0) { ?>
              <div class="alert-message block-message <?php echo $type ?>">
                <a class="close" href="">x</a>
                <?php foreach ($messages as $message) { ?>
                  <p><?php echo $message ?></p>
                <?php } ?>
              </div>
            <?php } ?>
          <?php } ?>
        </div>

        <div class="row">
          <?php if ($presenter["full_width"]) { ?>
            <div class="span16">
              <?php include($template); ?>
            </div>
          <?php } else { ?>
            <div class="span10">
              <?php include($template); ?>
            </div>
            <?php if (isset($right_rail)) { ?>
              <div class="span6">
                <?php include($right_rail); ?>
              </div>
            <?php } ?>
          <?php } ?>
        </div>
      </div>

      <footer>
        <p>omarqureshi.net</p>
      </footer>

    </div> <!-- /container -->

  </body>
</html>
