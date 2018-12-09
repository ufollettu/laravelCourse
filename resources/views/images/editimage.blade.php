@extends('templates.layout');
@section('content')
    <h1>Edit Photo</h1>
    <form action="{{route('photos.update', $photo->id)}}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
        <input type="hidden" name="_method" value="PATCH">
        <div class="form-group">
            <label for="">Name</label>
            <input
                type="text"
                name="name"
                id="name"
                value="{{$photo->name}}"
                class="form-control"
                placeholder="Photo name">
        </div>
    <input
        type="hidden"
        name="album_id"
        value="{{$photo->album_id}}">
        @include('images.partials.fileupload')
        <div class="form-group">
            <label for="">Description</label>
            <textarea
                type="text"
                name="description"
                id="description"
                class="form-control"
                placeholder="Photo description">{{$photo->description}}</textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
@endsection
