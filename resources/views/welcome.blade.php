<!doctype html>
<html lang="en">
<head>
    <!-- Author: Gregor Kosmina -->
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.ico') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>window.Laravel = {csrfToken: '{{ csrf_token() }}'}</script>

    <!-- Vue js animate -->
    <link rel="stylesheet" href="https://unpkg.com/vue2-animate/dist/vue2-animate.min.css"/>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Avto Welt d.o.o.</title>
    <!-- Styling files -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/custom-style.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/animate.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/arrow.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/fixed.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/lightbox.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/owl.carousel.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/owl.theme.default.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/waypoints.css') }}" >

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
</head>
<body data-spy="scroll" data-target="#navbarResponsive">

<div id="home">
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="{{ asset('pictures/logo-1.png') }}"></a>
            <button class="navbar-toggler second-button" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                    aria-controls="navbarSupportedContent23" aria-expanded="false" aria-label="Toggle navigation">
                <div class="animated-icon2"><span></span><span></span><span></span><span></span></div>
            </button>


           {{-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
                <span class="custom-toggler-icon"><i class="fas fa-bars"></i></span>
            </button>--}}
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <span class="nav-link lang-m-hide">
                            <div class="dropdown">
                              <button class="btn transparent-button dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="fas fa-globe-americas" aria-hidden="true"></i>
                              </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item custom-color custom-item" href="{{ route('english') }}">ENG</a>
                              </div>
                            </div>
                        </span>
                    </li>
                    <li class="nav-item lang-m-show">
                        <a class="nav-link" href="http://avtowelt.com/en">
                            <i class="fas fa-globe-americas" aria-hidden="true"></i>
                            ENG
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Domov</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">O nas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#cars">Ponudba</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#import-and-calculation">Uvoz</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Kontakt</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="video-background">
        <div class="video-wrap">
            <div id="video">
                <video id="bgvid" playsinline autoplay muted loop>
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
            <a class="btn btn-outline-light btn-lg" href="#about">O nas</a>
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
                <h1 class="mobile-title">Odličen izbor za pravo ceno</h1>
                <p class="lead">Smo mlada ter visoko motivirana ekipa strokovnjakov s področja avtomobilskega trga, katere je vaše zadovoljstvo
                    naša prva in edina prioriteta. Z nami doživite pozitivno izkušnjo od prvega kontakta pa do trenutka, ko se končno
                    vozite v avtu vaših sanj.</p>
                <a class="btn btn-red btn-sm" href="#cars">Ponudba</a>
                <a class="btn btn-gray btn-sm" href="#import-and-calculation">Kalkulacija</a>
            </div>
        </div>
    </div>
    <div class="jumbotron">
        <div class="narrow">
            <div class="os-animation" data-animation="fadeInUp">
                <h3 class="heading">Storitve</h3>
                <div class="heading-underline"></div>
            </div>
            <div class="row">
                <p class="lead spacing-bottom lead-smaller os-animation justify" data-animation="fadeInUp">
                    Poslovno smo povezani z leasing hišami pretežno v Nemčiji, kar pomeni da so naša vozila preverjene
                    kakovosti. Avtomobili so znanega izvora in preverjene celotne servisne zgodovine ter morebitnih popravil.
                    Direkten kontakt z nemškim trgom nam omogoča hiter dobavni rok, saj lahko večino vozil dostavimo v
                    roku dneh tednov. Ponujamo vam vozila po najboljši ceni s precej več opreme od vozil, ki so dostopna na našem trgu.
                    Nudimo tudi nakup novega ali odkup vašega rabljenega vozila.
                </p>
                <div class="col-sm-12 col-md-3">
                    <div class="os-animation" data-animation="fadeInLeft">
                        <div class="feature">
                            <span class="fa-layers fa-3x">
                                <i class="fas fa-truck"></i>
                            </span>
                            <h3>Transport</h3>
                            <p>Transport vozil v sodelovanju z našimi pogodbenimi partnerji.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="os-animation" data-animation="fadeInUp">
                        <div class="feature">
                            <span class="fa-layers fa-3x">
                               <i class="far fa-handshake"></i>
                            </span>
                            <h3>Svetovanje</h3>
                            <p>Svetovanje pri izbiri, nakupu, uvozu/izvozu, vzdrževanju ter garanciji rabljenih vozil.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="os-animation" data-animation="fadeInRight">
                        <div class="feature">
                            <span class="fa-layers fa-3x">
                               <i class="fas fa-euro-sign"></i>
                            </span>
                            <h3>Financiranje</h3>
                            <p>Ugodne možnosti financiranja v sodelovanju z našimi pogodbenimi partnerji.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="os-animation" data-animation="fadeInRight">
                        <div class="feature">
                            <span class="fa-layers fa-3x">
                               <i class="fas fa-tools"></i>
                            </span>
                            <h3>Pregled</h3>
                            <p>Strokoven pregled vozil v pooblaščenih servisih.</p>
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
            <div class="col-12 os-animation" data-animation="fadeInUp">
                <h3 class="heading">Vozila v ponudbi</h3>
                <div class="heading-underline"></div>
                <div class="col-md-12">
                    <div class="os-animation" data-animation="fadeInUp">
                        <div id="cars-in-offer" class="owl-carousel owl-theme">
                           @foreach($cars as $car)
                                <div class="card text-center">
                                    <a href="https://www.avto.net/avtowelt/" target="_blank"><img class="card-img-top" src="../{{ $car->image }}" alt=""></a>
                                    <div class="card-body">
                                        @if( $car->new === 'true')
                                            <div class="ribbon"><span>NOVO</span></div>
                                            @endif
                                        <h4>{{ $car->title }}</h4>
                                        <h5>{{ $car->subtitle }}</h5>
                                        <h5>{{ $car->price }}€</h5>
                                        <p>{{ $car->description }}</p>
                                    </div>
                                </div>
                           @endforeach
                        </div>
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
            <h3 class="heading">Uvoz</h3>
            <div class="heading-underline"></div>
        </div>
        <div class="os-animation" data-animation="fadeInLeft">
            <blockquote class="blockquote">
                <p class="mb-0">Uvoz vozil po naročilu že od 490€ + DDV.</p>
            </blockquote>
            <p class="justify">Željeno vozilo najprej preverimo. Vseskozi vam svetujemo, od prevoza do same registracije.  V skladu z vašimi željami vam pripravimo predračun, ki vključuje vse stroške prevoza, DMV in DDV.
                Cene se razlikujejo glede na stopnjo DMV ter lokacijo vozila. Vozilo nato v celoti plačate po predračunu ali vam pomagamo pri ureditvi financiranja - leasing ali
                kredit.</p>
            <p>
                <span class="text-red">Postopek:</span>
            <li> Izbira vozila na internetu pri enem izmed trgovcev</li>
            <li> Svetovanje ter preverba vozila</li>
            <li> Urejanje potrebne dokumentacije</li>
            <li> DMV in homologacija</li>
            <li> Morebitna ličarska dela in/ali poliranje - doplačilo</li>
            <li> Morebitno notranje globinsko čiščenje vozila - doplačilo</li>
            </p>
            <button class="btn btn-gray-costs" style="cursor: pointer" id="accordion" data-toggle="collapse" data-target="#app" aria-expanded="true" aria-controls="collapseOne">Izračun stroškov</button>
        </div>
        <div id="app" class="collapse hide" aria-labelledby="headingOne" data-parent="#accordion">
            <calculation></calculation>
        </div>
    </div>
</div>
<div id="contact" class="offset">
    <footer>
        <div class="row">
            <div class="col-md-5">
                <img src="{{ asset('pictures/logo-1.png') }}">
                <p>AVTO WELT d.o.o.<br>Premium selection &amp; Fair price</p>
                <strong>Naslov</strong>
                <p>Vanganelska cesta 5,<br>6000 Koper</p>
                <strong>Kontakt</strong>
                <p>Tadej Perhavec</p>
                <p>
                    +386 41 743 217<br>
                    tadej@avtowelt.com<br>
                    matjaz@avtowelt.com<br>
                </p>
                <a href="http://bit.ly/avtowelt" target="_blank"><i class="fas fa-map-marked-alt fa-2x"></i></a>
                <a href="#"><i class="fab fa-facebook-square fa-2x"></i></a>
            </div>
            <div class="col-md-7">
                <contact></contact>
            </div>
            <a href="#home"><i class="far fa-arrow-alt-circle-up fa-2x scroller"></i></a>
            <hr class="socket">
            &copy; AVTO WELT d.o.o.
        </div>
    </footer>
</div>
</body>
</html>

<!-- Vue src file -->
<script src="{!! asset('js/app.js') !!}"></script>

<!-- Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<!-- JS -->
<script src="{!! asset('js/custom.js') !!}"></script>
<script src="{!! asset('js/jquery.counterup.js') !!}"></script>
<script src="{!! asset('js/jquery.waypoints.min.js') !!}"></script>
<script src="{!! asset('js/lightbox.js') !!}"></script>
<script src="{!! asset('js/owl.carousel.js') !!}"></script>
<script src="{!! asset('js/waypoints.js') !!}"></script>
