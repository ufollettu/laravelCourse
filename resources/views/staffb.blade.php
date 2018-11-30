@extends('templates.layout')


{{--
    best pratcise warning!!!
    sarebbe meglio fare template semplici,
    con un if e un ciclo for o foreach,
    il resto andrebbe nei controller, non nelle viste
--}}
@section('title', $title)


@section('content')

<h1>
    blade {{$title}}
</h1>

@if ($staff)
    <ul>
        @foreach ($staff as $person)
            <li style="{{$loop->first ? 'color:red': ''}}">{{$loop->remaining}}  {{$loop->last}} {{$person['name']}} {{$person['lastname']}} </li>
        @endforeach
    </ul>
    @else
        <p>no staff</p>
@endif

<ul>

    @forelse ($staff as $person)
        <li> {{$person['name']}} {{$person['lastname']}} </li>
    @empty
        <li>no staff</li>
    @endforelse
</ul>

<h2>ciclo for</h2>
@for ($i = 0; $i < count($staff); $i++)
    {{$staff[$i]['name']}}
@endfor

<h2>while</h2>
@while ($person = array_pop($staff))
    {{$person['name']}}
@endwhile

    @endsection

@section('footer')
{{--
    @parent serve a scrivere il contenuto della sezione
    nel file genitore (layout.blade.php)
    insieme a quello della @section che vai a definire ora.
    funziona con la direttiva @show nel genitore
--}}
    @parent
    <script>console.log('footer')</script>
@stop
