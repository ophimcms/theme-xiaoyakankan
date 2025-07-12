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
    <style>
        .xemphim {
            float: left;
            padding: 0 10px;
            border-radius: 17px;
            background-color: #f8f8f8;
            font-size: 13px;
            line-height: 32px;
            height: 32px;
            text-decoration: none;
            background: linear-gradient(90deg, #ffb821 0, #d9534f 45%, #ff1459);
            background-color: #ff183e;
            color: #fff;
            margin-left: 10px;
        }
    </style>
    <div class="gm-main">
        <div class="gm-bread">
            <ol>
                <li><a href="/">Trang chủ</a></li>
                <li class="on"> {{ $currentMovie->name }}</li>
            </ol>
        </div>

        <div class="gm-vod">
            <img class="img" src="{{ $currentMovie->getThumbUrl() }}" alt="{{ $currentMovie->name }}">
            <div class="more">
                <h1 class="title"> {{ $currentMovie->name }}</h1>
                <div class="info">Quốc gia：{!! $currentMovie->regions->map(function ($region) {
                        return '<a href="' . $region->getUrl() . '" title="' . $region->name . '">' . $region->name . '</a>';
                    })->implode(', ') !!}</div>
                <div class="info">Năm：{{ $currentMovie->publish_year }}</div>
                <div class="info">Đạo diễn：{!! $currentMovie->directors->map(function ($director) {
                        return '<a href="' . $director->getUrl() . '" title="' . $director->name . '">' . $director->name . '</a>';
                    })->implode(', ') !!}</p></div>
                <div class="info">Diễn viên：{!! $currentMovie->actors->map(function ($director) {
                         return '<a href="' . $director->getUrl() . '" title="' . $director->name . '">' . $director->name . '</a>';
                     })->implode(', ') !!}</div>
                <div class="info">
                    Nội dung：　　  {!! strip_tags($currentMovie->content) !!}
                </div>

                <div class="info">
                    @if ($currentMovie->showtimes)
                        <p>Lịch chiếu : {{$currentMovie->showtimes}}</p>
                    @endif
                    @if ($currentMovie->notify )
                        <p>Thông báo :  {{$currentMovie->notify}}</p>
                    @endif
                </div>
                <div class="detail-star">
                    <h3>Đánh giá<small class="pull-right">
                            <div>
                                ({{$currentMovie->getRatingStar()}}
                                sao
                                /
                                {{$currentMovie->getRatingCount()}} đánh giá)
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

                @if($watch_url)
                    <a class="xemphim" href="{{ $watch_url }}" style="margin-left: 0;">Xem phim</a>
                @endif
                @if ($currentMovie->trailer_url && strpos($currentMovie->trailer_url, 'youtube'))
                    @php
                        parse_str( parse_url( $currentMovie->trailer_url, PHP_URL_QUERY ), $my_array_of_vars );
                        $video_id = $my_array_of_vars['v'] ?? null;
                    @endphp
                    <a class="xemphim fancybox fancybox.iframe" href="https://www.youtube.com/embed/{{$video_id}}">Trailer</a>
                @endif
            </div>
        </div>

        <div class="gm-meta"><h4>Bình luận</h4></div>
        <div class="gm-list">
            <div style="width: 100%; background-color: #fff">
                <div class="fb-comments w-full" data-href="{{ $currentMovie->getUrl() }}" data-width="100%"
                     data-numposts="5" data-colorscheme="light" data-lazy="true">
                </div>
            </div>
        </div>
        <div class="gm-meta"><h4>Có thể bạn thích</h4></div>
        <div class="gm-list">
            @foreach ($movie_related as $movie)
                @include('themes::themexiaoyakankan.inc.section.movie_card')
            @endforeach
        </div>
    </div>

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

