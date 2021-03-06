
@extends('templates.layout');
@section('content')
    <h1>Albums</h1>
    @if (session()->has('message'))
        @component('components.alert-info')
            {{session()->get('message')}}
        @endcomponent
    @endif
    <form action="">
    {{-- passiamo il session token per le richieste laravel --}}
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
        <ul class="list-group">

            @foreach ($albums as $album)
            <li class="list-group-item d-flex justify-content-between">{{$album->album_name}} ({{$album->id}})
                <div>
                    @if ($album->album_thumb)
                        <img width="300" src="{{asset($album->path)}}" title="{{$album->album_name}}" alt="{{$album->album_name}}">
                    @endif
                    @if ($album->photos_count)
                        <a id="update-button" href="/albums/{{$album->id}}/images" class="btn btn-primary">View Images ({{$album->photos_count}})</a>
                    @endif
                    {{-- {{$album->photos_count}} restituisce il conteggio delle photo relative al singolo album --}}
                    <a id="update-button" href="/albums/{{$album->id}}/edit" class="btn btn-primary">Update</a>
                    <a id="delete-button" href="/albums/{{$album->id}}" class="btn btn-danger">Delete</a>
                    <a id="new-button" href="{{route('photos.create')}}?album_id={{$album->id}}" class="btn btn-primary">New Image</a>
                </div>
            </li>
            @endforeach
        </ul>
    </form>
@endsection
@section('footer')
    @parent
    <script>
        $('document').ready(function() {
            $('ul').on('click', '#delete-button', function(e) {
                e.preventDefault()
                var url = $(this).attr('href');
                var li = e.target.parentNode.parentNode;
                var token = $('#_token').val();
                $.ajax(url, {
                    method: 'DELETE',
                    data: {
                        '_token' : token
                    },
                    complete: function(res) {
                        if (res.responseText == 1) {
                            $(li).remove();
                        } else {
                            alert('problemi');
                        }
                    }
                })
            })
        })
    </script>
@endsection
