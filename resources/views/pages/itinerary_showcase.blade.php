<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Travel Quoting System Showcase</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{asset('images/ico/favicon.ico')}}" rel="icon">
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">

  <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
  <link href="{{ asset('css/bootstrap-extended.css') }}" rel="stylesheet">
  <link href="{{ asset('fonts/icofont/icofont.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/pages/show_case.css') }}" rel="stylesheet">
</head>

<body>

  <header id="header" class="d-flex align-items-center">
    <div class="container d-flex flex-column align-items-center">

      <h1>Travel Quoting</h1>
      <h2>We will be always here for you!</h2>
      <div class="countdown d-flex justify-content-center" data-count="2021/12/3">
        <div>
          <h3>%D</h3>
          <h4>Days</h4>
        </div>
        <div>
          <h3>%H</h3>
          <h4>Hours</h4>
        </div>
        <div>
          <h3>%M</h3>
          <h4>Minutes</h4>
        </div>
        <div>
          <h3>%S</h3>
          <h4>Seconds</h4>
        </div>
      </div>
    </div>
  </header><!-- End #header -->

  <main id="main">
    <section id="about" class="about">
      <div class="container">

        <div class="section-title">
          <h2>About Us</h2>
          <p>Discover and book in-destination services at the best prices. With a few taps or clicks, you can be ready to hop aboard the Hong Kong Airport Express, set your inner child free at Tokyo Disneyland, or marvel at the breathtaking world under the waves in Bali.</p>
        </div>

        <div class="row mt-2">
          <div class="col-lg-4 col-md-6 icon-box">
            <div class="icon"><i class="icofont-computer"></i></div>
            <h4 class="title"><a href="">Handpicked experiences</a></h4>
            <p class="description">Our System experts all over the world uncover and curate the best experiences every day. But don’t just take our word for it, with over millions of user reviews, you can always get an authentic look at our experiences.</p>
          </div>
          <div class="col-lg-4 col-md-6 icon-box">
            <div class="icon"><i class="icofont-chart-bar-graph"></i></div>
            <h4 class="title"><a href="">Best price guaranteed</a></h4>
            <p class="description">As the official partner of top attractions and operators worldwide, we ensure all our offerings deliver quality experiences at the best price. Find any better deals and we’ll refund the difference! </p>
          </div>
          <div class="col-lg-4 col-md-6 icon-box">
            <div class="icon"><i class="icofont-earth"></i></div>
            <h4 class="title"><a href="">Seamless booking</a></h4>
            <p class="description">Our platform's intuitive design and strict security measure ensures that every customer has a seamless and secure booking experience.</p>
          </div>
        </div>

      </div>
    </section><!-- End About Us Section -->

    <!-- ======= Contact Us Section ======= -->
    <section id="contact" class="contact">
      <div class="container">

        <div class="section-title">
          <h2>Contact Us</h2>
        </div>

        <div class="row">

          <div class="col-lg-5 d-flex align-items-stretch">
            <div class="info">
              <div class="address">
                <i class="icofont-google-map"></i>
                <h4>Location:</h4>
                <p>{{ $account_info['country']}} {{ $account_info['city']}} ({{ $account_info['region'] }}) {{ $account_info['postal_code']}}</p>
              </div>

              <div class="email">
                <i class="icofont-envelope"></i>
                <h4>Email:</h4>
                <p>{{ $account_info['email'] }}</p>
              </div>

              <div class="phone">
                <i class="icofont-phone"></i>
                <h4>Call:</h4>
                <p>{{ $account_info['phone'] }}</p>
              </div>

              <div class="price">
                <i class="icofont-dollar"></i>
                <h4>Price:</h4>
                <p>{{ $itinerary_info['itinerary_budget'] }}({{ $itinerary_info['itinerary_currency'] }})</p>
                <div>
                  <p>
                    Any meals and services unless mentioned in the itinerary are not included.
                    The hotels and services as mentioned are subject to availability at the time of booking.
                    In case of unavailiability in mentioned hotels, alternate accommodation will be arranged in a similar category hotel.
                    Rates may changes in case of change in hotel rates, transport rates or entrance fees & airport taxes.
                  </p>
                </div>
              </div>
            </div>

          </div>

          <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch">
            <form action="forms/contact.php" method="post" role="form" class="php-email-form">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="name">Your Name</label>
                  <input type="text" name="name" class="form-control" id="name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
                  <div class="validate"></div>
                </div>
                <div class="form-group col-md-6">
                  <label for="name">Your Email</label>
                  <input type="email" class="form-control" name="email" id="email" data-rule="email" data-msg="Please enter a valid email" />
                  <div class="validate"></div>
                </div>
              </div>
              <div class="form-group">
                <label for="name">Subject</label>
                <input type="text" class="form-control" name="subject" id="subject" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
                <div class="validate"></div>
              </div>
              <div class="form-group">
                <label for="name">Message</label>
                <textarea class="form-control" name="message" rows="10" data-rule="required" data-msg="Please write something for us"></textarea>
                <div class="validate"></div>
              </div>
              <div class="mb-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-center"><button type="submit">Send Message</button></div>
            </form>
          </div>

        </div>

      </div>
    </section><!-- End Contact Us Section -->

    <section id="contact" class="contact">
      <div class="container">
        <div class="section-title">
          <h2>Travel Schedule</h2>
        </div>

        <div class="row mt-1 info">
          <div class="col-md-12">
            @php
              $index = 0;
            @endphp
            @foreach($itinerary_schedule_info as $key=>$value)
            <div class="schedule">
              <i class="icofont-calendar"></i>
              <h4> {{ $loop->index + 1 }}th Day </h4>
              <p>{{ $key }}</p>

              @for ($i=0; $i<count($value); $i++)

              <div>
                <div><p>{{ $value[$i]->start_time}} ~ {{ $value[$i]->end_time }}</p></div>
                <div class="d-flex align-item-center">
                  <div><p>{{ $value[$i]->product_title }}({{ $value[$i]->category_title }})</p></div>
                  <div><p>Destination: {{ $value[$i]->country_title }} {{ $value[$i]->city_title }}</p></div>
                  <div><p>adults : {{ $value[$i]->adults_num }} childrens: {{ $value[$i]->children_num }}</p></div>
                </div>
              </div>
              <div id="myCarousel_{{ $index }}" class="carousel slide" data-ride="carousel" style="text-align:center;">
                <!-- Indicators -->
                @php
                  $carousel_data = $value[$i]->product_gallery;
                @endphp

                <ul class="carousel-indicators">
                  @for($j = 0; $j<count($carousel_data); $j++)
                    @if($j == 0)
                      <li data-target="#myCarousel_{{ $index }}" data-slide-to="{{ $j }}" class="active"></li>
                    @else
                      <li data-target="#myCarousel_{{ $index }}" data-slide-to="{{ $j }}"></li>
                    @endif
                  @endfor
                </ul>
                
                <!-- The slideshow -->
                <div class="carousel-inner">
                  @for($j = 0; $j<count($carousel_data); $j++)
                    @if($j == 0)
                      <div class="carousel-item active">
                        <img src="{{ asset($carousel_data[$j]->path) }}" alt="Los Angeles" width="500" height="300">
                      </div>
                    @else
                      <div class="carousel-item">
                        <img src="{{ asset($carousel_data[$j]->path) }}" alt="Los Angeles" width="500" height="300">
                      </div>
                    @endif
                  @endfor
                </div>
                
                <!-- Left and right controls -->
                <a class="carousel-control-prev" href="#myCarousel_{{ $index }}" data-slide="prev">
                  <span class="carousel-control-prev-icon"></span>
                </a>
                <a class="carousel-control-next" href="#myCarousel_{{ $index }}" data-slide="next">
                  <span class="carousel-control-next-icon"></span>
                </a>
              </div>
              @php
                $index ++;
              @endphp
              @endfor
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </section><!-- End Contact Us Section -->

  </main><!-- End #main -->

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('js/core/libraries/jquery.min.js') }}"></script>
  <script src="{{ asset('js/core/libraries/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/core/libraries/jquery.easing.min.js') }}"></script>
  <script src="{{ asset('js/core/libraries/jquery.countdown.min.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('js/scripts/pages/itinerary_showcase.js') }}"></script>
</body>

</html>