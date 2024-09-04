<div class="gm-meta">
    <h3>{{$item['label']}}</h3>
</div>
<div class="gm-list">
    @foreach ($item['data'] as $movie)
        @include('themes::themexiaoyakankan.inc.section.movie_card')
    @endforeach
</div>
