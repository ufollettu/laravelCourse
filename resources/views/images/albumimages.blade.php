@extends('templates.layout');
@section('content')
    <h1>Images for {{$album->album_name}}</h1>
    @if (session()->has('message'))
        @component('components.alert-info')
            {{session()->get('message')}}
        @endcomponent
    @endif
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Created</th>
            <th>Title</th>
            <th>Album</th>
            <th>Thumbnail</th>
        </tr>
        @forelse ($images as $image)
        <tr>
            <td>{{$image->id}}</td>
            <td>{{$image->created_at}}</td>
            <td>{{$image->name}}</td>
            <td>{{$album->album_name}}</td>
            <td>
                <img width="120px" src="{{asset($image->path)}}" alt="{{$image->name}}">
            </td>
            <td>
                    <a href="{{route('photos.destroy', $image->id)}}" class="btn btn-danger">Delete</a>
                    <a href="{{route('photos.edit', $image->id)}}" class="btn btn-primary">Edit</a>
            </td>
        </tr>
        @empty
        <tr><td colspan="5">No images found</td></tr>
        @endforelse
    </table>
@endsection
@section('footer')
    @parent
    <script>
        $('document').ready(function() {
            $('table').on('click', 'a.btn-danger', function(e) {
                e.preventDefault()
                var url = $(this).attr('href');
                var tr = e.target.parentNode.parentNode;

                $.ajax(url, {
                    method: 'DELETE',
                    data: {
                        '_token' : '{{csrf_token()}}'
                    },
                    complete: function(res) {
                        if (res.responseText == 1) {
                            tr.parentNode.removeChild(tr);
                        } else {
                            alert('problemi');
                        }
                    }
                })
            })
        })
    </script>
@endsection
