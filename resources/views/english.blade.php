@extends('main.master')
@section('content')
    <div id="home">
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><img src="{{ asset('pictures/logo-1.png') }}" alt="logo"></a>
                <button class="navbar-toggler second-button" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                        aria-controls="navbarSupportedContent23" aria-expanded="false" aria-label="Toggle navigation">
                    <div class="animated-icon2"><span></span><span></span><span></span><span></span></div>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a href="{{ route($langRoute) }}" class="lang-link nav-link">
                                <i class="fas fa-globe-americas" aria-hidden="true"></i>
                                {{ $lang }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#about">About us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#cars">Cars</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#import-and-calculation">Import</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#enc">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="video-background">
            <div class="video-wrap">
                <div id="video">
                    <video id="bgvid" playsinline autoplay muted>
                        <source src="{{ asset('videos/video.mp4') }}" type="video/mp4">
                    </video>
                </div>
            </div>
        </div>
        <div class="landing">
            <div class="home-wrap">
                <div class="home-inner">
                </div>
            </div>
        </div>
        <div class="caption text-center">
            <div class="os-animation" data-animation="bounceInUp" data-delay=".1">
                <h1 class="main-title"> Avto Welt</h1>
            </div>
            <div class="os-animation" data-animation="bounceInUp" data-delay=".8">
                <h3 class="sub-title">Premium selection & fair price</h3>
            </div>
            <div class="os-animation" data-animation="bounceInUp" data-delay="1s">
                <a class="btn btn-outline-light btn-lg" href="#about">About us</a>
            </div>
        </div>
        <a class="down-arrow" href="#about">
            <div class="arrow bounce d-none d-md-block">
                <i class="fas fa-angle-down fa-3x" aria-hidden="true"></i>
            </div>
        </a>
    </div>
    <div id="about" class="offset">
        <div class="os-animation" data-animation="fadeInUp">
            <div class="narrow text-center">
                <div class="col-12">
                    <h1 class="mobile-title">Premium selection & fair price</h1>
                    <p class="lead">We are a young and highly motivated team of experts in the automotive market and your total satisfaction is our first and utmost priority. We strive for your positive experience from the moment you first contact us, to the moment you are finally driving the car of your dreams.</p>
                    <a class="btn btn-red btn-sm" href="#cars">Cars</a>
                    <a class="btn btn-gray btn-sm" href="#import-and-calculation">Costs calculation</a>
                </div>
            </div>
        </div>
        <div class="jumbotron">
            <div class="narrow">
                <div class="os-animation" data-animation="fadeInUp">
                    <h3 class="heading">Our Service</h3>
                    <div class="heading-underline"></div>
                </div>
                <div class="row">
                    <p class="lead spacing-bottom lead-smaller os-animation justify" data-animation="fadeInUp">
                        We have excellent business relations and connections with leasing companies and car dealers mainly in Germany but also Belgium, Netherlands and Sweden. This means that all our vehicles are of proven quality, of known origin and known entire service history or history of any repairs. Our direct contacts in these markets also enables us to guarantee a fast delivery time, most vehicles can be delivered within 2 weeks and of course always at the best prices. Generally these vehicles also have more equipment than comparable options available in other markets.
                    </p>
                    <div class="col-sm-12 col-md-3">
                        <div class="os-animation" data-animation="fadeInLeft">
                            <div class="feature">
                            <span class="fa-layers fa-3x">
                                <i class="fas fa-truck"></i>
                            </span>
                                <h3>Transportation</h3>
                                <p>Transport of vehicles in cooperation with our partners.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div class="os-animation" data-animation="fadeInUp">
                            <div class="feature">
                            <span class="fa-layers fa-3x">
                               <i class="far fa-handshake"></i>
                            </span>
                                <h3>Consulting</h3>
                                <p>Consulting about the selection, purchase, import or export, maintenance and warranty of your new or used vehicles.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div class="os-animation" data-animation="fadeInRight">
                            <div class="feature">
                            <span class="fa-layers fa-3x">
                               <i class="fas fa-euro-sign"></i>
                            </span>
                                <h3>Financing</h3>
                                <p>Very favorable financing options in cooperation with our partners.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div class="os-animation" data-animation="fadeInRight">
                            <div class="feature">
                            <span class="fa-layers fa-3x">
                               <i class="fas fa-tools"></i>
                            </span>
                                <h3>Inspection</h3>
                                <p>Expert inspection of vehicles before purchase.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="cars" class="offset">
        <div class="fixed-background">
            <div class="row light">
                <div class="os-animation" data-animation="fadeInUp">
                    <h3 class="heading">Cars</h3>
                    <div class="heading-underline"></div>
                    <div class="os-animation" data-animation="fadeInUp">
                        <div id="cars-in-offer" class="owl-carousel owl-theme">
                            @foreach($cars as $car)
                                <div class="card text-center">
                                    <a href="{{ $car->link }}" target="_blank">
                                        <img class="card-img-top" src="../{{ $car->image }}" alt="">
                                    </a>
                                    <div class="card-body">
                                        @if((boolean)$car->new === true)
                                            <div class="ribbon"><span>NEW</span></div>
                                        @endif
                                        <h5 class="text-red">{{ $car->title }}</h5>
                                        <h5>{{ $car->subtitle }}</h5>
                                        <h5>
                                            @if($car->price === trans('messages.CFP'))
                                                <span class="text-red">{{ trans('messages.cfp-blade') }}</span>
                                            @else
                                                {{ number_format($car->price,2,',','.') }}€
                                            @endif
                                        </h5>
                                        <p>{{ $car->description }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="fixed-wrap">
                <div id="fixed-2">
                </div>
            </div>
        </div>
    </div>
    <div id="import-and-calculation" class="offset">
        <div class="narrow">
            <div class="col-12 os-animation" data-animation="fadeInUp">
                <h3 class="heading">Import</h3>
                <div class="heading-underline"></div>
            </div>
            <div class="os-animation" data-animation="fadeInLeft">
                <blockquote class="blockquote">
                    <p class="mb-0">Our service of import of pre-chosen vehicles from our clients starts already at 490€ + VAT.</p>
                </blockquote>
                <p class="justify">We advise you about possible vehicle choices, check your vehicle in advance and arrange everything you need from transportation to registration. Depending on your demand and wishes, we prepare a commercial offer that includes all costs, motor vehicle tax or "DMV" and VAT. Prices may vary depending on the "DMV" rate and vehicle pickup place. According to the commercial offer of the vehicle you pay the full amount or we can assist you with financing arrangements - leasing or Bank loan.</p>
                <p>
                    <span class="text-red">Typical import procedure:</span>
                <li> You choose a vehicle on the Internet from one of the dealers, or we help you choose from our dealers database</li>
                <li> We advise you and can arrange the verification of the vehicle on demand</li>
                <li> We prepare all necessary documentation, arrange the transport of the vehicle at your desired location</li>
                <li> We take care of the motor vehicle tax "DMV" and the certification/technical inspection of the vehicle</li>
                <li> Paintwork and/or repair is offered at an additional cost</li>
                <li> Internal deep cleaning or ozone cleaning (smoke smell) of vehicle is also subject to an additional charge</li>
                <button class="btn btn-gray-costs" style="cursor: pointer" id="accordion" data-toggle="collapse" data-target="#appeng" aria-expanded="true" aria-controls="collapseOne">Costs calculation</button>
            </div>
            <div id="appeng" class="collapse hide" aria-labelledby="headingOne" data-parent="#accordion">
                <ecalc></ecalc>
            </div>
        </div>
    </div>
    <div id="enc" class="offset">
        <footer>
            <div class="row">
                <div class="col-md-5">
                    <img src="{{ asset('pictures/logo-1.png') }}" alt="logo">
                    <p>AVTO WELT d.o.o.<br>Premium selection &amp; Fair price</p>
                    <strong>Address</strong>
                    <p>Vanganelska cesta 5,<br>6000 Koper</p>
                    <strong>Contact</strong>
                    <p>Tadej Perhavec</p>
                    <p>
                        +386 41 743 217<br>
                        tadej@avtowelt.com<br>
                        matjaz@avtowelt.com<br>
                    </p>
                    <a href="http://bit.ly/avtowelt" target="_blank"><i class="fas fa-map-marked-alt fa-2x"></i></a>
                </div>
                <div class="col-md-7">
                    <encontact></encontact>
                </div>
                <a href="#home"><i class="far fa-arrow-alt-circle-up fa-2x scroller"></i></a>
                <hr class="socket">
                &copy; AVTO WELT d.o.o.
            </div>
        </footer>
    </div>
@endsection
