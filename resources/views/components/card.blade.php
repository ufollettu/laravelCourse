<div class="card" style="width: 18rem;">
    <img class="card-img-top" src="{{$img_url}}" alt="{{$img_title}}">
    <div class="card-body">
        <h5 class="card-title">{{$img_title}}</h5>
        {{-- $slot vuol dire metti nel component qualsiasi cosa venga passata dal genitore che non sia una variabile. tipo html,
        etc --}} {{$slot}}
    </div>
</div>
