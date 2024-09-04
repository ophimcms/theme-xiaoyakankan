@extends('themes::themexiaoyakankan.layout')
@php
    $watch_url = '';
    if (!$currentMovie->is_copyright && count($currentMovie->episodes) && $currentMovie->episodes[0]['link'] != '') {
        $watch_url = $currentMovie->episodes
            ->sortBy([['server', 'asc']])
            ->groupBy('server')
            ->first()
            ->sortByDesc('name', SORT_NATURAL)
            ->groupBy('name')
            ->last()
            ->sortByDesc('type')
            ->first()
            ->getUrl();
    }
@endphp
@section('content')
    <nav class="bg-page">
        <ul id="breadcrumb" itemscope="itemscope" itemtype="https://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope="itemscope" itemtype="https://schema.org/ListItem"><a href="/"
                                                                                                           itemprop="item"
                                                                                                           title="Xem phim"><span
                        itemprop="name">Xem Phim</span></a></li>
            <li itemprop="itemListElement" itemscope="itemscope" itemtype="https://schema.org/ListItem"
                class="breadcrumb-item"><a itemprop="item"
                                           href="{{ $currentMovie->getUrl() }}"><span
                        itemprop="name"> {{ $currentMovie->name }}</span></a></li>
        </ul>
    </nav>
    <main id="main-body" class="bg-page" itemscope="" itemtype="https://schema.org/Movie">
        <div>
            <section class="info-banner-box">
                <div class="container">
                    <div class="blur-container"
                         style="background: url({{ $currentMovie->getPosterUrl() }}) center center / cover no-repeat rgb(110, 97, 78); opacity: 0.3;"></div>
                    <img id="song-thumbnail-temp" hidden="" class="ateslazi"
                         src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                         data-src="{{ $currentMovie->getThumbUrl() }}" width="240" alt=" {{ $currentMovie->name }}">
                    <div class="sub-container clearfix" itemprop="potentialAction" itemscope=""
                         itemtype="https://schema.org/WatchAction">
                        <a class="medium-card-11" href="{{ $watch_url }}" itemprop="target">
                            <img class="ateslazi" src="{{ $currentMovie->getThumbUrl() }}"
                                 data-src="{{ $currentMovie->getThumbUrl() }}"
                                 alt=" {{ $currentMovie->name }}">
                            <i class="icon ic-svg-play-outline"></i>
                        </a>
                        <div class="info-banner-body clearfix">
                            <div class="left-info">
                                <div class="ranking"></div>
                                <h1 itemprop="name"><span class="text-upper "> {{ $currentMovie->name }}</span></h1>
                                <div class="artist-name">
                                    <h2 itemprop="name">{{$currentMovie->origin_name}}
                                        ({{ $currentMovie->publish_year }})</h2>
                                </div>
                                <div class="subtext release">Trạng thái: <span
                                        style="color:#63c0ac"><b>{{$currentMovie->getStatus()}} {{ $currentMovie->language }}</b></span>
                                </div>
                                <div class="subtext release">Đạo diễn:{!! $currentMovie->directors->map(function ($director) {
                        return '<a href="' . $director->getUrl() . '" title="' . $director->name . '">' . $director->name . '</a>';
                    })->implode(', ') !!}</div>
                                <div class="subtext release">Diễn viên: {!! $currentMovie->actors->map(function ($director) {
                         return '<a href="' . $director->getUrl() . '" title="' . $director->name . '">' . $director->name . '</a>';
                     })->implode(', ') !!}</div>
                                <div class="subtext release">Quốc Gia: {!! $currentMovie->regions->map(function ($region) {
                        return '<a href="' . $region->getUrl() . '" title="' . $region->name . '">' . $region->name . '</a>';
                    })->implode(', ') !!}</div>
                                <div class="subtext release">Năm sản xuất: {{ $currentMovie->publish_year }} | Thời
                                    lượng: {{$currentMovie->episode_time}}
                                </div>
                            </div>
                            <div class="myui-panel_bd">
                                @if ($currentMovie->showtimes)
                                    <p>Lịch chiếu : {{$currentMovie->showtimes}}</p>
                                @endif
                                @if ($currentMovie->notify )
                                    <p>Thông báo :  {{$currentMovie->notify}}</p>
                                @endif
                            </div>
                            <div class="right-info">
                                <div class="log-stats">
                                    <div class="viewed"><i class="icon ic-play"></i> {{$currentMovie->view_total}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="user-interaction-box">
                <div class="container">
                    <div class="sub-container">
                        <div class="user-interaction-wrapper">
                            <ul class="action-list">
                                <li itemprop="potentialAction" itemscope="" itemtype="https://schema.org/WatchAction"><a
                                        class="action watch" href="{{ $watch_url }}" itemprop="target"><i
                                            class="icon ic-play"></i> Xem ngay</a></li>
                                @if ($currentMovie->trailer_url && strpos($currentMovie->trailer_url, 'youtube'))
                                    @php
                                        parse_str( parse_url( $currentMovie->trailer_url, PHP_URL_QUERY ), $my_array_of_vars );
                                        $video_id = $my_array_of_vars['v'] ?? null;
                                    @endphp
                                    <li itemprop="potentialAction" itemscope=""
                                        itemtype="https://schema.org/WatchAction"><a
                                            class="action watch fancybox fancybox.iframe"
                                            href="https://www.youtube.com/embed/{{$video_id}}" itemprop="target"><i
                                                class="icon ic-play"></i> Trailer</a></li>
                                @endif

                                <li><a class="action"><i class="icon ic-imdb"></i> <span
                                            style="color:#ffd500">N/A</span></a></li>
                                <li><a class="action"><i class="icon ic-calendar"></i> Lịch Chiếu: <span>N/A</span></a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            <section class="info-player-details-box">
                <div class="container">
                    <div class="sub-container">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="artist-profile clearfix" style="">
                                    <div class="detail-star">
                                        <h3>Đánh giá<small class="pull-right">
                                                <div>
                                                    <div>
                                                        ({{$currentMovie->getRatingStar()}}
                                                        sao
                                                        /
                                                        {{$currentMovie->getRatingCount()}} đánh giá)
                                                    </div>
                                                </div>
                                            </small>
                                        </h3>
                                        <div class="ewave-star-box center-block">
                                            <div class="rating-content">
                                                <div id="movies-rating-star"></div>
                                                <div id="movies-rating-msg"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="lyrics-wrapper">
                                    <div class="heading">NỘI DUNG PHIM</div>
                                    <div class="lyrics-text" itemprop="description">
                                        <div>
                                            {!! strip_tags($currentMovie->content) !!}
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <div class="heading">TỪ KHÓA</div>
                                    <div class="tags-list-movie">
                                        {!! $currentMovie->tags->map(function ($tag) {
                                                return '<a href="' . $tag->getUrl() . '" title="' . $tag->name . '">' . $tag->name . '</a>';
                                            })->implode(' ') !!}
                                    </div>
                                </div>
                                <div id="comment">
                                    <div class="heading">BÌNH LUẬN</div>
                                    <div class="comment-list-wrapper" style="background-color: #FFF !important;">
                                        <div class="fb-comments w-full" data-href="{{ $currentMovie->getUrl() }}"
                                             data-width="100%"
                                             data-numposts="5" data-colorscheme="light" data-lazy="true">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <aside class="z-video-player-aside">
                                    <div class="z-aside-header clearfix">
                                        <div class="heading pull-left">PHIM LIÊN QUAN</div>
                                    </div>
                                    <ul class="z-video-130-73-list list-info-mw-150">
                                        @foreach ($movie_related as $movie)
                                            <li>
                                                <div class="z-card card-130-73">
                                                    <a class="thumb-130-73"
                                                       href="{{$movie->getUrl()}}">
                                                        <div class=" lazyload-img loaded"><img class="ateslazi"
                                                                                               src="{{$movie->getPosterUrl()}}"
                                                                                               data-src="{{$movie->getPosterUrl()}}"
                                                                                               alt="{{$movie->name}} /{{ $movie->origin_name }}">
                                                        </div>
                                                        <i class="icon ic-svg-play-outline"></i><span
                                                            class="opac"></span>
                                                    </a>
                                                    <div class="card-info">
                                                        <div class="title"><a class=""
                                                                              title="Phim Tình Tựa Ánh Hồng / Rainbow Round My Shoulder"
                                                                              href="{{$movie->getUrl()}}">{{$movie->name}} </a>
                                                        </div>
                                                        <div class="artist"><a class="mr-2" title="Will"
                                                                               href="{{$movie->getUrl()}}">{{ $movie->origin_name }}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </aside>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    @push('scripts')
        <script src="{{ asset('/themes/xiaoyakankan/plugins/jquery-raty/jquery.raty.js') }}"></script>
        <link href="{{ asset('/themes/xiaoyakankan/plugins/jquery-raty/jquery.raty.css') }}" rel="stylesheet"
              type="text/css"/>
        <script>
            var rated = false;
            $('#movies-rating-star').raty({
                score: {{$currentMovie->getRatingStar()}},
                number: 10,
                numberMax: 10,
                hints: ['quá tệ', 'tệ', 'không hay', 'không hay lắm', 'bình thường', 'xem được', 'có vẻ hay', 'hay',
                    'rất hay', 'siêu phẩm'
                ],
                starOff: '{{ asset('/themes/xiaoyakankan/plugins/jquery-raty/images/star-off.png') }}',
                starOn: '{{ asset('/themes/xiaoyakankan/plugins/jquery-raty/images/star-on.png') }}',
                starHalf: '{{ asset('/themes/xiaoyakankan/plugins/jquery-raty/images/star-half.png') }}',
                click: function (score, evt) {
                    if (rated) return
                    fetch("{{ route('movie.rating', ['movie' => $currentMovie->slug]) }}", {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]')
                                .getAttribute(
                                    'content')
                        },
                        body: JSON.stringify({
                            rating: score
                        })
                    });
                    rated = true;
                    $('#movies-rating-star').data('raty').readOnly(true);
                    $('#movies-rating-msg').html(`Bạn đã đánh giá ${score} sao cho phim này!`);
                }
            });
        </script>
        <script src="{{ asset('/themes/xiaoyakankan/source/jquery.fancybox.pack.js?v=2.1.5') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('/themes/xiaoyakankan/source/jquery.fancybox.css?v=2.1.5') }}"
              media="screen"/>
        <script type="text/javascript">
            $(document).ready(function () {
                $(".fancybox").fancybox({
                    maxWidth: 800,
                    maxHeight: 600,
                    fitToView: false,
                    width: '70%',
                    height: '70%',
                    autoSize: false,
                    closeClick: false,
                    openEffect: 'none',
                    closeEffect: 'none'
                });
            });
        </script>

        {!! setting('site_scripts_facebook_sdk') !!}
    @endpush

@endsection

