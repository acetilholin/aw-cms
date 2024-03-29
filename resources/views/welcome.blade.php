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
                    <a class="btn btn-gray btn-sm" href="#import-and-calculation">Uvoz</a>
                    <!-- kalkulacija -->
                    <a class="btn btn-red btn-sm" href="#contact">Povpraševanje</a>
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
                <div class="os-animation" data-animation="fadeInUp">
                    <h3 class="heading">Vozila v ponudbi</h3>
                    <div class="heading-underline"></div>
                    <div class="os-animation" data-animation="fadeInUp">
                        <div id="cars-in-offer" class="owl-carousel owl-theme">
                            @foreach($cars as $car)
                                <div class="card text-center">
                                    <a href="{{ $car->link }}" target="_blank">
                                        <img class="card-img-top" src="../{{ $car->image }}" alt="">
                                    </a>
                                    <div class="card-body">
                                        @if((boolean)$car->new)
                                            <div class="ribbon"><span>NOVO</span></div>
                                        @endif
                                        <h5 class="text-red">{{ $car->title }}</h5>
                                        <h5>{{ $car->subtitle }}</h5>
                                        <h5>
                                            @if((boolean)$car->call_for_price)
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
                <br><br>
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
                <div class="col-md-4">
                    <img src="{{ asset('pictures/logo-1.png') }}" alt="logo">
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
                    <div class="mt-5">
                        <a href="#home"><i class="far fa-arrow-alt-circle-up fa-2x scroller"></i></a>
                    </div>
                </div>
                <div class="col-md-5" id="contactForm">
                    <contact></contact>
                </div>
                <div class="col-md-3 mt-2" id="inquiryForm">
                    <inquiry></inquiry>
                </div>
                <hr class="socket">
                &copy; AVTO WELT d.o.o.
            </div>
        </footer>
        @include('cookies')
    </div>
    <!-- Tesla Modal -->
    {{--<div class="modal fade" id="tesla-add" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <img class="img-fluid" src="{{ asset('pictures/tesla-modal.jpg') }}" height="370" width="100%">
                <div class="text-center space-top-bottom">
                    <h3 class="mobile-size">Testna vožnja z <span class="text-red">novim</span> modelom Tesla 3 ?</h3>
                    <a href="#contact" class="btn btn-red" data-dismiss="modal">Prijavite se</a>
                </div>
            </div>
        </div>
    </div>--}}

@endsection
