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
            <th>Created</th>
            <th>Title</th>
            <th>Album</th>
            <th>Thumbnail</th>
            <th>Actions</th>
        </tr>
        @forelse ($images as $image)
        <tr>
            <td>{{$image->created_at}}</td>
            <td>{{$image->name}}</td>
            <td>{{$album->album_name}}</td>
            <td>
                <img width="100px" src="{{asset($image->img_path)}}" alt="{{$image->name}}">
            </td>
            <td>
                    <a href="{{route('photos.destroy', $image->id)}}" class="btn btn-sm btn-danger">Delete</a>&nbsp
                    <a href="{{route('photos.edit', $image->id)}}" class="btn btn-sm btn-primary">Edit</a>
            </td>
        </tr>
        @empty
            <tr><td colspan="6">No images found</td></tr>
        @endforelse
            <tr>
                <td colspan="6">
                    <div class="row">
                        <div class="col-md-8 push-2">
                            {{$images->links()}}
                        </div>
                    </div>
                    {{-- genera la paginazione in automatico --}}
                </td>
            </tr>

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
