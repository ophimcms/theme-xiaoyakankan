@extends('themes::themexiaoyakankan.layout')
@section('content')

    <style>
        .active-server {
            background: #d9a0a0 !important;
            color: #FFF !important;
        }

        .playactive {
            color: #FFF !important;
            background: #c92626 !important;
        }

        #streaming-sv {
            padding: 10px;
            border-radius: 10px;
            cursor: pointer !important;
        }
    </style>
    <div class="gm-main">
        <div class="gm-bread">
            <ol>
                <li><a href="/">Trang chủ</a></li>
                <li class="on"> {{ $currentMovie->name }}</li>
            </ol>
        </div>
        <div id="dom-player" class="dplayer dplayer-no-danmaku dplayer-playing dplayer-hide-controller">
            <div class="dplayer-mask"></div>
            <div class="dplayer-video-wrap">
                <div class="dplayer-video dplayer-video-current" id="player-wrapper">
                </div>
            </div>

        </div>
        <div class="video-info-aux" style="margin-top: 20px;margin-bottom:20px ;text-align: center">
            @foreach ($currentMovie->episodes->where('slug', $episode->slug)->where('server', $episode->server) as $server)
                <a onclick="chooseStreamingServer(this)" data-type="{{ $server->type }}"
                   id="streaming-sv"
                   data-id="{{ $server->id }}"
                   data-link="{{ $server->link }}" class="streaming-server tag-link"
                   style="background: #232328;color: #FFF">
                    Nguồn #{{ $loop->index + 1 }}
                </a>
            @endforeach
        </div>
        <div id="dom-source">
            @foreach ($currentMovie->episodes->sortBy([['server', 'asc']])->groupBy('server') as $server => $data)
                <div class="source">
                    <div class="title">
                        <span class="name">{{ $server }}</span>
                    </div>
                    <div class="list">
                        @foreach ($data->sortBy('name', SORT_NATURAL)->groupBy('name') as $name => $item)
                            <a class="@if ($item->contains($episode)) on @endif"
                               href="{{ $item->sortByDesc('type')->first()->getUrl() }}">{{ $name }}</a>
                        @endforeach
                    </div>
                </div>
            @endforeach
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
                    Nội dung：　　 {!! strip_tags($currentMovie->content) !!}
                </div>

                <div class="info">
                    @if ($currentMovie->showtimes)
                        <p>Lịch chiếu : {{$currentMovie->showtimes}}</p>
                    @endif
                    @if ($currentMovie->notify )
                        <p>Thông báo : {{$currentMovie->notify}}</p>
                    @endif
                </div>
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

        <script src="/themes/xiaoyakankan/player/js/p2p-media-loader-core.min.js"></script>
        <script src="/themes/xiaoyakankan/player/js/p2p-media-loader-hlsjs.min.js"></script>

        <script src="/js/jwplayer-8.9.3.js"></script>
        <script src="/js/hls.min.js"></script>
        <script src="/js/jwplayer.hlsjs.min.js"></script>

        <script>
            var episode_id = {{ $episode->id }};
            const wrapper = document.getElementById('player-wrapper');
            const vastAds = "{{ Setting::get('jwplayer_advertising_file') }}";

            function chooseStreamingServer(el) {
                const type = el.dataset.type;
                const link = el.dataset.link.replace(/^http:\/\//i, 'https://');
                const id = el.dataset.id;

                const newUrl =
                    location.protocol +
                    "//" +
                    location.host +
                    location.pathname.replace(`-${episode_id}`, `-${id}`);

                history.pushState({
                    path: newUrl
                }, "", newUrl);
                episode_id = id;


                Array.from(document.getElementsByClassName('streaming-server')).forEach(server => {
                    server.classList.remove('active-server');
                })
                el.classList.add('active-server');

                link.replace('http://', 'https://');
                renderPlayer(type, link, id);
            }

            function renderPlayer(type, link, id) {
                if (type == 'embed') {
                    if (vastAds) {
                        wrapper.innerHTML = `<div id="fake_jwplayer"></div>`;
                        const fake_player = jwplayer("fake_jwplayer");
                        const objSetupFake = {
                            key: "{{ Setting::get('jwplayer_license') }}",
                            aspectratio: "16:9",
                            width: "100%",
                            file: "/themes/vung/player/1s_blank.mp4",
                            volume: 100,
                            mute: false,
                            autostart: true,
                            advertising: {
                                tag: "{{ Setting::get('jwplayer_advertising_file') }}",
                                client: "vast",
                                vpaidmode: "insecure",
                                skipoffset: {{ (int) Setting::get('jwplayer_advertising_skipoffset') ?: 5 }}, // Bỏ qua quảng cáo trong vòng 5 giây
                                skipmessage: "Bỏ qua sau xx giây",
                                skiptext: "Bỏ qua"
                            }
                        };
                        fake_player.setup(objSetupFake);
                        fake_player.on('complete', function (event) {
                            $("#fake_jwplayer").remove();
                            wrapper.innerHTML = `<iframe width="100%" height="400px" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                            fake_player.remove();
                        });

                        fake_player.on('adSkipped', function (event) {
                            $("#fake_jwplayer").remove();
                            wrapper.innerHTML = `<iframe width="100%" height="400px" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                            fake_player.remove();
                        });

                        fake_player.on('adComplete', function (event) {
                            $("#fake_jwplayer").remove();
                            wrapper.innerHTML = `<iframe width="100%" height="400px" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                            fake_player.remove();
                        });
                    } else {
                        if (wrapper) {
                            wrapper.innerHTML = `<iframe width="100%" height="400px" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                        }
                    }
                    return;
                }

                if (type == 'm3u8' || type == 'mp4') {
                    wrapper.innerHTML = `<div id="jwplayer"></div>`;
                    const player = jwplayer("jwplayer");
                    const objSetup = {
                        key: "{{ Setting::get('jwplayer_license') }}",
                        aspectratio: "16:9",
                        width: "100%",
                        image: "{{ $currentMovie->getPosterUrl() }}",
                        file: link,
                        playbackRateControls: true,
                        playbackRates: [0.25, 0.75, 1, 1.25],
                        sharing: {
                            sites: [
                                "reddit",
                                "facebook",
                                "twitter",
                                "googleplus",
                                "email",
                                "linkedin",
                            ],
                        },
                        volume: 100,
                        mute: false,
                        autostart: true,
                        logo: {
                            file: "{{ Setting::get('jwplayer_logo_file') }}",
                            link: "{{ Setting::get('jwplayer_logo_link') }}",
                            position: "{{ Setting::get('jwplayer_logo_position') }}",
                        },
                        advertising: {
                            tag: "{{ Setting::get('jwplayer_advertising_file') }}",
                            client: "vast",
                            vpaidmode: "insecure",
                            skipoffset: {{ (int) Setting::get('jwplayer_advertising_skipoffset') ?: 5 }}, // Bỏ qua quảng cáo trong vòng 5 giây
                            skipmessage: "Bỏ qua sau xx giây",
                            skiptext: "Bỏ qua"
                        }
                    };

                    if (type == 'm3u8') {
                        const segments_in_queue = 50;

                        var engine_config = {
                            debug: !1,
                            segments: {
                                forwardSegmentCount: 50,
                            },
                            loader: {
                                cachedSegmentExpiration: 864e5,
                                cachedSegmentsCount: 1e3,
                                requiredSegmentsPriority: segments_in_queue,
                                httpDownloadMaxPriority: 9,
                                httpDownloadProbability: 0.06,
                                httpDownloadProbabilityInterval: 1e3,
                                httpDownloadProbabilitySkipIfNoPeers: !0,
                                p2pDownloadMaxPriority: 50,
                                httpFailedSegmentTimeout: 500,
                                simultaneousP2PDownloads: 20,
                                simultaneousHttpDownloads: 2,
                                // httpDownloadInitialTimeout: 12e4,
                                // httpDownloadInitialTimeoutPerSegment: 17e3,
                                httpDownloadInitialTimeout: 0,
                                httpDownloadInitialTimeoutPerSegment: 17e3,
                                httpUseRanges: !0,
                                maxBufferLength: 300,
                                // useP2P: false,
                            },
                        };
                        if (Hls.isSupported() && p2pml.hlsjs.Engine.isSupported()) {
                            var engine = new p2pml.hlsjs.Engine(engine_config);
                            player.setup(objSetup);
                            jwplayer_hls_provider.attach();
                            p2pml.hlsjs.initJwPlayer(player, {
                                liveSyncDurationCount: segments_in_queue, // To have at least 7 segments in queue
                                maxBufferLength: 300,
                                loader: engine.createLoaderClass(),
                            });
                        } else {
                            player.setup(objSetup);
                        }
                    } else {
                        player.setup(objSetup);
                    }


                    const resumeData = 'OPCMS-PlayerPosition-' + id;
                    player.on('ready', function () {
                        if (typeof (Storage) !== 'undefined') {
                            if (localStorage[resumeData] == '' || localStorage[resumeData] == 'undefined') {
                                console.log("No cookie for position found");
                                var currentPosition = 0;
                            } else {
                                if (localStorage[resumeData] == "null") {
                                    localStorage[resumeData] = 0;
                                } else {
                                    var currentPosition = localStorage[resumeData];
                                }
                                console.log("Position cookie found: " + localStorage[resumeData]);
                            }
                            player.once('play', function () {
                                console.log('Checking position cookie!');
                                console.log(Math.abs(player.getDuration() - currentPosition));
                                if (currentPosition > 180 && Math.abs(player.getDuration() - currentPosition) >
                                    5) {
                                    player.seek(currentPosition);
                                }
                            });
                            window.onunload = function () {
                                localStorage[resumeData] = player.getPosition();
                            }
                        } else {
                            console.log('Your browser is too old!');
                        }
                    });

                    player.on('complete', function () {
                        if (typeof (Storage) !== 'undefined') {
                            localStorage.removeItem(resumeData);
                        } else {
                            console.log('Your browser is too old!');
                        }
                    })

                    function formatSeconds(seconds) {
                        var date = new Date(1970, 0, 1);
                        date.setSeconds(seconds);
                        return date.toTimeString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");
                    }
                }
            }
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const episode = '{{ $episode->id }}';
                let playing = document.querySelector(`[data-id="${episode}"]`);
                if (playing) {
                    playing.click();
                    return;
                }

                const servers = document.getElementsByClassName('streaming-server');
                if (servers[0]) {
                    servers[0].click();
                }
            });
        </script>

        {!! setting('site_scripts_facebook_sdk') !!}
    @endpush
@endsection
