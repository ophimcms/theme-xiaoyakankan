<div class="item">
    <a class="link" href="{{$movie->getUrl()}}">
        <img class="img" src="{{$movie->getThumbUrl()}}" data-src="{{$movie->getThumbUrl()}}" alt="{{$movie->name}}"> <div class="tag1"> {{ $movie->quality }}</div>
        <div class="tag2">{{$movie->getStatus()}} / {{ $movie->publish_year }}</div>
        <div class="play"></div>
    </a>
    <div class="info">
        <a class="title" href="{{$movie->getUrl()}}">{{$movie->name}}</a>
        <div class="desc">{{ $movie->origin_name }}</div>
    </div>
</div>
