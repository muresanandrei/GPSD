<!DOCTYPE>
<html lang="en">
<html>
<head>
  <title>{{ $meta_title }}</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="{{ $meta_description }}">
  <meta name="keywords" content="{{ $meta_keywords }}">
  <meta name="author" content="Gpsd">
  <meta property="og:image" content="{{ $og_image }}"/>
  <meta property="og:description" content="{{ $meta_description }}"/>

  <link rel="icon" type="image/ico" href="{{ Request::root() }}/favicon.ico"/>


  <!--Custom CSS-->
  <link rel="stylesheet" type="text/css" href="{{ Request::root() }}/assets/theme_css/custom.css">

  <!-- Montserrat font -->
  <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

  <!-- Lato Font -->
<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>

   <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
   <script src="{{ Request::root() }}/assets/theme_js/ie10-viewport-bug-workaround.js"></script>

   <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript">

        /*
         *
         * Global Namespace
         *
         * base_url: for .js files that need the base url
         *
         *
         *
         */
        var gpsd = {

            'base_url'   : '{{ Request::root() }}'

        }//base url

    </script>



</head>
<body>

<!-- HEADER  -->

<nav class="navigation">

  <div class="logoholder">
    <a href="{{ Request::root() }}"><img id="logo" src="{{ Request::root() }}/assets/images/logo.png"></a>
    </div>

      <div class="distance-line-nav"></div>

      <!-- Responsive menu button -->
      <div class="menu-responsive" id="responsive-menu-button">

      <!-- Menu button -->
      <a id="menu-button-link" href="#" onclick="show_navigation_menu(); return false;">MENU</a>

        <!-- Menu navigation -->
        <div class="menu-navigation">
            
          <ul class="responsive-list-unstyled">
   
           <li><a class="active-category" href="{{ Request::root() }}">All</a></li> 

           @foreach($categories as $c) 

              <li><a class="active-category" href="{{ Request::root() }}/category/{{ $c->cat_url }}/{{ $c->id }}">{{ strtoupper($c->name) }}</a></li>

           @endforeach
                     
         </ul>

              <br />
              <br />

           <div class="search-icon-responsive"><img src="{{ Request::root() }}/assets/images/search-icn.png"></div>

          <div class="searchbar-responsive">
            {{ Form::open(array('url' => 'search','method' => 'GET')) }}

               <input type="text" name="search" class="form-control" id="search-responsive" placeholder="Search item">

            </form>   
         </div>

        </div>
        <!-- End menu navigation -->
      </div>
      <!--End Responsive menu button -->

        <div class="search-icon"><img src="{{ Request::root() }}/assets/images/search-icn.png"></div>

          <div class="searchbar">
            {{ Form::open(array('url' => 'search','method' => 'GET')) }}

               <input type="text" name="search" class="form-control" id="search" placeholder="Search item">

            </form>   
         </div>

     <div class="submit-btn pull-right">
         <a href="mailto:hello@gpsd.co?subject=I want to be featured on Gpsd!" class="submit-btn pull-right">Submit yours</a>
     </div>
 
</nav>

<!-- END OF HEADER -->

<div class="clearfix"></div>

<!-- Categories -->
<div class="categories">

<div class="categories_container">
  
    <ul class="list-unstyled">
      <li>Categories</li>

     <li><a class="active-category" href="{{ Request::root() }}">All</a></li> 
     @foreach($categories as $c) 

      <li><a class="active-category" href="{{ Request::root() }}/category/{{ $c->cat_url }}/{{ $c->id }}">{{ strtoupper($c->name) }}</a></li>

     @endforeach
                     
    </ul>

    <div class="donate">

          <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
        <input type="hidden" name="cmd" value="_s-xclick">
        <input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
        ">
        <input type="image" src="http://gpsd.co/assets/images/donate.jpg" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
        <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
        </form>


    </div>

</div>

</div>

<!-- End categories -->

 <div class="distance-line"></div>

@yield('header')


@section('footer_js')

<!-- ////////////////////////////////// -->
<!-- //      Javascript Files        // -->
<!-- ////////////////////////////////// -->
<script src="{{ Request::root() }}/assets/theme_js/jquery-1.11.1.min.js"></script>
<script src="{{ Request::root() }}/assets/theme_js/main.js"></script>


<!-- SOCIAL MEDIA SCRIPTS -->
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>


<!-- GOOGLE ANALYTICS SCRIPT -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-43843606-9', 'auto');
  ga('send', 'pageview');

</script>


@show

</body>
</html>