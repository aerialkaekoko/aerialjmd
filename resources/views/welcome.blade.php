@extends('layouts.app')
@section('content')
<section class="banner text-center p-6"
    style="background-image: url(./storage/{{AppSettings::get('banner')}});background-size: cover;">
    <div class="p-5">
        <h1 class="home-banner-w3">Helping You With Any of Your Business Needs!</h1>
        <p class="bnr-txt">Lorem ipsum dolor sit amet,Stet clita kasd gubergren, Lorem ipsum dolor sitamet,Stet clita
            kasd gubergren,
        </p>
    </div>
</section>
{{-- news section --}}

<section id="news" class="container animation_element animated">
    <div class="index_list_header clearfix">
        <h3 class="news_font">Latest News</h3>
        <a class="index_archive_link d-sm-none d-md-block" href="/news">View all News</a>
    </div>

    <ol class="news_list clearfix">
        {{-- @foreach($news as $news)
        <li class="clearfix active">
            <p class="date">{{ $news->created_at->format('d - M - Y') }}</p>
            <div class="category"><a style="background:#00A3D9;" href="{{ url('news/view/' . $news->id) }}">News</a>
            </div>
            <a class="news_title" href="{{ url('news/view/' . $news->id) }}">{{ $news->title }}</a>
        </li>
        @endforeach --}}
    </ol>
    <div class="mobile_archive_link">
        <a class="index_archive_link" href="{{ url('news') }}">View all News</a>
    </div>
</section>

{{-- Emergency --}}
<section id="calltoaction" class="ca" style="background:url(./storage/{{AppSettings::get('background')}});background-size:cover;">
    <div class="container">
        <<div class="p-5">
            <h1 class="home-banner-w3">EMERGENCY CALL</h1>
            <p class="bnr-txt">Lorem ipsum dolor sit amet,Stet clita kasd gubergren, Lorem ipsum dolor sit
                amet,Stet clita kasd gubergren,</p>
    </div>
    <a href="tel:2349721491" class="btn btn-primary btn-lg"><i class="fa fa-phone-volume"></i> {{AppSettings::get('phone')}}</a></div>
    </div>
</section>
{{-- user voice --}}
<section id="uservoice">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h2>What Our Customers Are Saying</h2>
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <!-- Carousel indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                    </ol>
                    <!-- Wrapper for carousel items -->
                    <div class="carousel-inner">
                        <div class="item carousel-item active">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="media">
                                        <div class="media-left d-flex mr-3">
                                            <a href="#">
                                                <img src="/storage/{{AppSettings::get('logo')}}" alt="">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <div class="testimonial">
                                                <p>Vestibulum quis quam ut magna consequat faucibus. Pellentesque eget
                                                    mi suscipit tincidunt. Utmtc tempus dictum. Pellentesque virra.</p>
                                                <p class="overview"><b>Antonio Moreno</b>, Web Developer</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item carousel-item">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="media">
                                        <div class="media-left d-flex mr-3">
                                            <a href="#">
                                                <img src="/storage/{{AppSettings::get('logo')}}" alt="">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <div class="testimonial">
                                                <p>Lorem ipsum dolor sit amet, consec adipiscing elit. Nam eusem
                                                    scelerisque tempor, varius quam luctus dui. Mauris magna metus nec.
                                                </p>
                                                <p class="overview"><b>Michael Holz</b>, Seo Analyst</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="item carousel-item">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="media">
                                        <div class="media-left d-flex mr-3">
                                            <a href="#">
                                                <img src="/storage/{{AppSettings::get('logo')}}" alt="">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <div class="testimonial">
                                                <p>Lorem ipsum dolor sit amet, consec adipiscing elit. Nam eusem
                                                    scelerisque tempor, varius quam luctus dui. Mauris magna metus nec.
                                                </p>
                                                <p class="overview"><b>Martin Sommer</b>, UX Analyst</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

{{-- Hospital list --}}

<section id="hospitallsit">
    <div class="container">
        <div class="row hospital">
            <div class="col-md-12">
                <div class="section-title text-center">
                    <h2>Hospital Lists</h2>
                </div>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <input id="myInput" type="text" name="search" class="form-control"
                                placeholder="Search Hospital..">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-bordered ">
            <thead class="thead-dark table-bordered">
                <tr>
                    <th>Hospital Name</th>
                    <th>Country</th>
                    <th>Contact No</th>
                </tr>
            </thead>
            {{-- @foreach($hospitals as $hospital)
            <tbody id="myTable">
                <tr>
                    <td>
                        <a href="{{ url('hospital/view/' . $hospital->id) }}">
                            {{ $hospital->name }}
                        </a>
                    </td>
                    <td>
                        {{ $hospital->country }}
                    </td>
                    <td>09 70802543</td>
                </tr>
            </tbody>
            @endforeach --}}
        </table>
    </div>
</section>
{{-- end Hospital list --}}


{{-- contact us --}}
<section id="contact" style="background:url(./storage/{{AppSettings::get('background')}});background-size:cover;">
    <div class="section-content">
        <h2 class="section-header text-white">Contact Us</h2>
        <p class="text-white">Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
    </div>
    <div class="contact-section">
        <div class="container">

            <form>
                <div class="row">
                    <div class="col-md-6 form-line">
                        <div class="form-group">
                            <label for="exampleInputUsername">Your name</label>
                            <input type="text" class="form-control" id="" placeholder=" Enter Name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail">Email Address</label>
                            <input type="email" class="form-control" id="exampleInputEmail"
                                placeholder=" Enter Email id">
                        </div>
                        <div class="form-group">
                            <label for="telephone">Mobile No.</label>
                            <input type="tel" class="form-control" id="telephone"
                                placeholder=" Enter 10-digit mobile no.">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="description"> Message</label>
                            <textarea class="form-control" id="description" placeholder="Enter Your Message"></textarea>
                        </div>
                        <div>

                            <button type="button" class="btn btn-default submit border border-secondary"><i
                                    class="fa fa-paper-plane" aria-hidden="true"></i> Send Message</button>
                        </div>

                    </div>
                </div>
            </form>

        </div>
</section>
{{-- end contact us  --}}

{{-- User Guide --}}
<section id="userguide">
    <div class="section-content">
        <h2 class="section-header">User Guides</h2>

    </div>
    <div class="container">
        <div class="row border border-secondary">
            <div class="col-3 border border-secondary p-2">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab"
                        aria-controls="v-pills-home" aria-selected="true">STEP1</a>
                    <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab"
                        aria-controls="v-pills-profile" aria-selected="false">STEP2</a>
                    <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab"
                        aria-controls="v-pills-messages" aria-selected="false">STEP3</a>
                    <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab"
                        aria-controls="v-pills-settings" aria-selected="false">STEP4</a>
                </div>
            </div>
            <div class="col-9 border border-secondary p-2">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                        aria-labelledby="v-pills-home-tab">
                        <h3>step1</h3>
                        <p>Eu1 dolore ea ullamco dolore Lorem id cupidatat excepteur reprehenderit</p>
                    </div>
                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                        aria-labelledby="v-pills-profile-tab">
                        <h3>step2</h3>
                        <p>Eu1 dolore ea ullamco dolore Lorem id cupidatat excepteur reprehenderit</p>
                    </div>
                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                        aria-labelledby="v-pills-messages-tab">
                        <h3>step3</h3>
                        <p>Eu1 dolore ea ullamco dolore Lorem id cupidatat excepteur reprehenderit</p>
                    </div>
                    <div class="tab-pane fade" id="v-pills-settings" role="tabpanel"
                        aria-labelledby="v-pills-settings-tab">
                        Eu4 dolore ea ullamco dolore Lorem id cupidatat excepteur reprehenderit consectetur elit id
                        dolor proident in cupidatat officia. Voluptate excepteur commodo labore nisi cillum duis aliqua
                        do. Aliqua amet qui mollit consectetur nulla mollit velit aliqua veniam nisi id do Lorem
                        deserunt amet. Culpa ullamco sit adipisicing labore officia magna elit nisi in aute tempor
                        commodo eiusmod.</div>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- End User Guide --}}
@endsection
@section('scripts')
@parent

@endsection