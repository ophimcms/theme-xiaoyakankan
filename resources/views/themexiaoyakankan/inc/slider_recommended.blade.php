<section class="z-slider-main">
    <div class="container">
        <div class="row">
            <div id="slider-main">
                <div class="regular slider" id="slick-main-top">
                    @foreach ($home_page_slider_poster['data'] as $key=> $movie)
                    <a class="z-slide"
                       href="{{$movie->getUrl()}}">
                        <div class="image lazyload-img loaded">
                            <img class="ateslazi"
                                 src="{{$movie->getPosterUrl()}}"
                                 alt="{{$movie->name}} /    {{$movie->origin_name}}"
                                 title="{{$movie->name}} /    {{$movie->origin_name}}">
                        </div>
                        <div class="title-movie text-shadow">
                            <div class="title1">{{$movie->name}}</div>
                            <p class="title2">   {{$movie->origin_name}}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
