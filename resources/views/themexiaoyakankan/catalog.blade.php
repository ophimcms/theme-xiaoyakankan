@extends('themes::themexiaoyakankan.layout')
@section('content')
    <div class="gm-main">
        <div class="gm-bread">
            <ol>
                <li><a href="/"> Trang chủ</a></li>
                <li class="on">{{ $section_name ?? 'Danh Sách Phim' }}</li>
            </ol>
        </div>
        <div class="gm-list">
            @if (count($data))
                @foreach ($data as $movie)
                    @include('themes::themexiaoyakankan.inc.section.movie_card')
                @endforeach
            @else
                <p class="text-danger">Không có dữ liệu cho mục này</p>
            @endif
        </div>
    </div>
    <div class="gm-page">
        {{ $data->appends(request()->all())->links("themes::Themexiaoyakankan.inc.pagination") }}
    </div>

@endsection
