@extends('templates.layout');
@section('content')

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
            <img width="120px" src="{{asset($image->img_path)}}" alt="{{$image->name}}">
        </td>
    </tr>
    @empty
    <tr><td colspan="5">No images found</td></tr>
    @endforelse
</table>
@endsection
