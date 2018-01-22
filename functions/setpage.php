<?php

  function PageHeader($Title)
  {
    $Return = <<<HTML
         <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">$Title</h3>
                </div>

            </div>

HTML;

    return $Return;
  }

  function PageFooter()
  {
    $Return .= <<<HTML
        <!--Footer-->
<div class="footerWrap">
  <div class="container">
    <div class="row">
      <!--About Us-->
      <div class="col-md-3 col-sm-12">
        <div class="ft-logo"><img src="images/logo.png" alt="Your alt text here"></div>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et consequat elit. Proin molestie eros sed urna auctor lobortis. Integer eget scelerisque arcu. Pellentesque scelerisque pellentesque nisl, sit amet aliquam mi pellentesque fringilla. Ut porta augue a libero pretium laoreet. Suspendisse sit amet massa accumsan, pulvinar augue id, tristique tortor.</p>

        <!-- Social Icons -->
        <div class="social"> <a href="#." target="_blank"> <i class="fa fa-facebook-square" aria-hidden="true"></i></a> <a href="#." target="_blank"><i class="fa fa-twitter-square" aria-hidden="true"></i></a> <a href="#." target="_blank"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a> <a href="#." target="_blank"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a> <a href="#." target="_blank"><i class="fa fa-youtube-square" aria-hidden="true"></i></a> </div>
        <!-- Social Icons end -->
      </div>
      <!--About us End-->

      <!--Quick Links-->
      <div class="col-md-2 col-sm-6">
        <h5>Quick Links</h5>
        <!--Quick Links menu Start-->
        <ul class="quicklinks">
          <li><a href="#.">Event / Promotion Services</a></li>
          <li><a href="#.">Profile Help</a></li>
          <li><a href="#.">Company Listings</a></li>
          <li><a href="#.">Success Stories</a></li>
          <li><a href="#.">Contact Us</a></li>
          <li><a href="#.">Create Account</a></li>
          <li><a href="#.">Post a Gig</a></li>
          <li><a href="#.">Contact Sales</a></li>
        </ul>
      </div>
      <!--Quick Links menu end-->

      <!--Gigs By Industry-->
      <div class="col-md-3 col-sm-6">
        <h5>Gigs By Category</h5>
        <!--Industry menu Start-->
        <ul class="quicklinks">
          <li><a href="#.">Models</a></li>
          <li><a href="#.">Brand Ambassadors</a></li>
          <li><a href="#.">Promoters</a></li>
          <li><a href="#.">Waiters</a></li>
          <li><a href="#.">Bartender</a></li>
          <li><a href="#.">Host / Hostess</a></li>
          <li><a href="#.">Ushers</a></li>
          <li><a href="#.">Speakers</a></li>
          <li><a href="#.">Celebrities</a></li>
        </ul>
        <!--Industry menu End-->
        <div class="clear"></div>
      </div>

      <!--Latest Articles-->
      <div class="col-md-4 col-sm-12">
        <h5>Latest Articles</h5>
        <ul class="posts-list">
          <!--Article 1-->
          <li>
            <article class="post post-list">
              <div class="entry-content media">
                <div class="media-left"> <a href="#." title="" class="entry-image"> <img width="80" height="80" src="images/news-1.jpg" alt="Your alt text here"> </a> </div>
                <div class="media-body">
                  <h4 class="entry-title"> <a href="#.">Sed fermentum at lectus nec porta.</a> </h4>
                  <div class="entry-content-inner">
                    <div class="entry-meta"> <span class="entry-date">May 28, 2017</span> </div>
                  </div>
                </div>
              </div>
            </article>
          </li>
          <!--Article end 1-->

          <!--Article 2-->
          <li>
            <article class="post post-list">
              <div class="entry-content media">
                <div class="media-left"> <a href="#." title="" class="entry-image"> <img width="80" height="80" src="images/news-2.jpg" alt="Your alt text here"> </a> </div>
                <div class="media-body">
                  <h4 class="entry-title"> <a href="#.">Sed fermentum at lectus nec porta.</a> </h4>
                  <div class="entry-content-inner">
                    <div class="entry-meta"> <span class="entry-date">June 21, 2017</span> </div>
                  </div>
                </div>
              </div>
            </article>
          </li>
          <!--Article end 2-->

          <!--Article 3-->
          <li>
            <article class="post post-list">
              <div class="entry-content media">
                <div class="media-left"> <a href="#." title="" class="entry-image"> <img width="80" height="80" src="images/news-3.jpg" alt="Your alt text here"> </a> </div>
                <div class="media-body">
                  <h4 class="entry-title"> <a href="#.">Sed fermentum at lectus nec porta.</a> </h4>
                  <div class="entry-content-inner">
                    <div class="entry-meta"> <span class="entry-date">July 28, 2017</span> </div>
                  </div>
                </div>
              </div>
            </article>
          </li>
          <!--Article end 3-->
        </ul>
      </div>
    </div>
  </div>
</div>
<!--Footer end-->

HTML;

return $Return;
  }
?>
