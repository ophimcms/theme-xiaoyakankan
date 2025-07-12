@php
    $logo = setting('site_logo', '');
    $brand = setting('site_brand', '');
    $title = isset($title) ? $title : setting('site_homepage_title', '');
@endphp
<div class="gm-head">
    <div class="wrap">
        <a class="logo tw" href="/" title="">
            @if ($logo)
                {!! $logo !!}
            @else
                {!! $brand !!}
            @endif
        </a>
        <div class="nav">
            <ul>
                @foreach ($menu as $item)
                    @if (count($item['children']))
                        <li data-meta="gm-meta-{{$item['id']}}" class="has-meta"><a href="{{ $item['link'] }}"><i
                                    class="t10"></i><span>{{ $item['name'] }}</span></a></li>
                    @else
                        <li><a href="{{ $item['link'] }}"><i class="t11"></i><span>{{ $item['name'] }}</span></a></li>
                    @endif
                @endforeach
            </ul>
        </div>
        <div class="search">
            <form action="/">
                <input name="search" type="text" id="navbar-search" placeholder="Tìm kiếm"
                    value="{{ request('search') }}" autocomplete="off">
                <button type="submit"></button>
            </form>
        </div>
        <div id="btn-nav" class="btn-nav"></div>
        <div id="btn-search" class="btn-search"></div>
    </div>
</div>

<div id="pop-nav" class="mi-pop-nav">
    <ul>
        @foreach ($menu as $item)
            @if (count($item['children']))
                <li data-meta="gm-meta-{{$item['id']}}" class="has-meta"><a href="{{ $item['link'] }}"><i
                            class="t10"></i><span>{{ $item['name'] }}</span></a></li>
            @else
                <li><a href="{{ $item['link'] }}"><i class="t11"></i><span>{{ $item['name'] }}</span></a></li>
            @endif
        @endforeach
    </ul>
</div>

<div id="pop-search" class="mi-pop-search">
    <div class="wrap">
      <form action="/" target="_blank">
        <input name="search" type="text" placeholder="Tìm kiếm" value="{{ request('search') }}">
        <button type="submit"></button>
      </form>
    </div>
  </div>

<div class="gm-main">
    @foreach ($menu as $item)
        @if (count($item['children']))
            <div class="gm-meta gm-meta-item none" id="gm-meta-{{$item['id']}}">
                <a href="{{$item['link']}}" class="on">{{$item['name']}}</a>
                @foreach ($item['children'] as $child)
                    <a href="{{$child['link']}}">{{$child['name']}}</a>
                @endforeach
            </div>
        @endif
    @endforeach
</div>


@push('scripts')
    <script>
        document.querySelectorAll('.has-meta').forEach((li) => {
            li.addEventListener('click', function (event) {
                event.preventDefault();
                const meta = this.dataset.meta;
                var metaElm = document.getElementById(meta);
                var isShow = metaElm.classList.contains('none');
                document.querySelectorAll('.gm-meta-item').forEach(function(item) {
                    item.classList.add('none');
                });
                if (isShow) {
                    metaElm.classList.remove('none');
                } else {
                    metaElm.classList.add('none');
                }
            });
        });
    </script>
    <script type="text/javascript">
        $('#navbar-search').on('keyup', function() {
            $("#result").html('');
            $value = $(this).val();
            if (!$value) {
                $("#result").html('');
                return;
            }
            $.ajax({
                type: 'get',
                url: '{{ URL::to('search') }}',
                data: {
                    'search': $value
                },
                success: function(data) {
                    $("#result").html('')
                    $.each(data, function(key, value) {
                        $('#result').append('<a href="' + value.slug +
                            '"><div class="rowsearch"> <div class="column lefts"> <img src="' +
                            value.image +
                            '" width="50" /> </div> <div class="column rights"><p> ' + value
                            .title + ' ' + '</p><p> ' + value.original_title + '| ' + value
                            .year + ' </p></div> </div></a>')
                    });
                }
            });
        })
        document.body.addEventListener("click", function(event) {
            $("#result").html('');
        });
        $.ajaxSetup({
            headers: {
                'csrftoken': '{{ csrf_token() }}'
            }
        });
    </script>
@endpush
