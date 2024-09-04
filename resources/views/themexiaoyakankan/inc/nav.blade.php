@php
    $logo = setting('site_logo', '');
    $brand = setting('site_brand', '');
    $title = isset($title) ? $title : setting('site_homepage_title', '');
@endphp
<div class="gm-head">
    <div class="wrap">
        <a class="logo tw" href="/" title="">      @if ($logo)
                {!! $logo !!}
            @else
                {!! $brand !!}
            @endif
        </a>
        <div class="nav">
            <ul>
                    @foreach ($menu as $item)
                        @if (count($item['children']))
                        <li><a href="{{$item['link']}}"><i class="t10"></i><span>{{$item['name']}}</span></a></li>
                        @else
                        <li><a href="{{$item['link']}}"><i class="t10"></i><span>{{$item['name']}}</span></a></li>
                        @endif
                    @endforeach
            </ul>
        </div>
        <div class="search">
            <form action="/">
                <input name="search" type="text" id="navbar-search" placeholder="Tìm kiếm" value="{{ request('search') }}" autocomplete="off">
                <button type="submit"></button>
            </form>
        </div>
        <div id="btn-nav" class="btn-nav"></div>
        <div id="btn-search" class="btn-search"></div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        $('#navbar-search').on('keyup', function () {
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
                success: function (data) {
                    $("#result").html('')
                    $.each(data, function (key, value) {
                        $('#result').append('<a href="' + value.slug + '"><div class="rowsearch"> <div class="column lefts"> <img src="' + value.image + '" width="50" /> </div> <div class="column rights"><p> ' + value.title + ' ' + '</p><p> ' + value.original_title + '| ' + value.year + ' </p></div> </div></a>')
                    });
                }
            });
        })
        document.body.addEventListener("click", function (event) {
            $("#result").html('');
        });
        $.ajaxSetup({headers: {'csrftoken': '{{ csrf_token() }}'}});
    </script>
@endpush
