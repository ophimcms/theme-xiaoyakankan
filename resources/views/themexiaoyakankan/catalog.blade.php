@extends('themes::themexiaoyakankan.layout')
@section('content')
    <section class="bg-gradient-grey pad-top-30">
        <div class="container bor-bottom">
            <div class="sub-container">
                <div class="row">
                    <div class="col-md-8">
                        <h1 class="z-box-title">{{ $section_name ?? 'Danh Sách Phim' }}</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="para-content pad-top-5"></h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="bg-color-1">
        <section>
            <div class="container pad-bottom-10 pad-top-0">
                <div class="sub-container mw-990 pad-top-40 pad-bottom-10">
                    <div class="row">
                        <div class="col-md-12">
                            @if (count($data))
                                @foreach ($data as $movie)
                                        @include('themes::themexiaoyakankan.inc.section.movie_card')
                                @endforeach
                            @else
                                <p class="text-danger">Không có dữ liệu cho mục này</p>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pad-bottom-30">
                            <div class="z-center">
                                {{ $data->appends(request()->all())->links("themes::Themexiaoyakankan.inc.pagination") }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
