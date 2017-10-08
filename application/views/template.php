<!DOCTYPE html>
<html>
  <head>
    <title>Goose Airlines - UnicornUnited</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
  </head>
  <body>
    <header>
      <div class="container">
        <center>
            <h1>Welcome to Goose Airlines</h1>
            <h3>We hope that you have a pleasant flight experience.</h3>
        </center>
      </div>
    </header>

    <div id="nav">
    <nav class="navbar navbar-default navbar-static affix-top" role="navigation">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Goose Airlines</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="#">Homepage</a></li>
          <li><a href="#">Flights</a></li>
          <li><a href="#">Planes</a></li>
          <li><a href="#">About us</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div>
    </nav>
  </div>
        <div id="container">
			{content}
			<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. 
				{ci_version}</p>
        </div>

  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <h4>Goose Airlines</h4>
          <p>Dedicated to getting you safely around BC.</p>
        </div>
        <div class="col-md-3">
          <h4>Our location</h4>
          <div class="row">
            <div class="col-md-1"><span class="glyphicon glyphicon-map-marker"></span></div>
            <div class="col-md-10">Golden, BC.</div>
          </div><br>
          <div class="row">
            <div class="col-md-1"><span class="glyphicon glyphicon-envelope"></span></div>
            <div class="col-md-10">gooseairlines@comp4711.com</div>
          </div><br>
          <div class="row">
            <div class="col-md-1"><span class="glyphicon glyphicon-earphone"></span></div>
            <div class="col-md-10">604-123-4567</div>
          </div>
        </div>
        <div class="col-md-3">
          <h4>Latest blogs</h4>
          <div class="row">
            <div class="col-md-1"><span class="glyphicon glyphicon-pencil"></span></div>
            <div class="col-md-10">Maecenas suscipit in est a placerat. Curabitur semper sed nibh sed egestas. </div>
          </div><br>
          <div class="row">
            <div class="col-md-1"><span class="glyphicon glyphicon-pencil"></span></div>
            <div class="col-md-10">Maecenas suscipit in est a placerat. Curabitur semper sed nibh sed egestas. </div>
          </div>
        </div>
        <div class="col-md-3">
          <h4>Subscribe</h4>
          <input type="text" class="form-control" placeholder="your email address">
        </div>
      </div>
    </div>
  </footer>  

  <footer id="copyright">
    <p>Copright by @andreyyann 2014, All right reserved.</p>
  </footer>

    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script>
      $(function() {
  $('a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });
});

      $(function() {
  //navbar affix
  $('#nav').affix({
    offset: {
      top: $('header').height()
    }
  });
});

      $('#nav .navbar-nav li>a').click(function(){
  var link = $(this).attr('href');
  var posi = $(link).offset().top+20;
  $('body,html').animate({scrollTop:posi},700);
})


      $( document ).ready(function() {
    $("[rel='tooltip']").tooltip();    
 
    $('.thumbnail').hover(
        function(){
            $(this).find('.caption').fadeIn(250);
        },
        function(){
            $(this).find('.caption').fadeOut(205);
        }
    ); 
});
    </script>
  </body>
</html>