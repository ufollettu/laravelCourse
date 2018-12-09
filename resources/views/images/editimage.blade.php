@extends('templates.layout');
@section('content')
    @if ($photo->id)
    <h1>Edit Photo</h1>
    <form action="{{route('photos.update', $photo->id)}}" method="POST" enctype="multipart/form-data">
        {{method_field('PATCH')}}
    @else
    <h1>New Photo</h1>
    <form action="{{route('photos.store')}}" method="POST" enctype="multipart/form-data">
    @endif
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
        <div class="form_group">
            <select name="album_id" id="album_id">
                <option value="">SELECT</option>
                @foreach ($albums as $item)
                <option {{$item->id==$album->id ? 'selected': ''}}
                    value="{{$item->id}}">{{$item->album_name}}
                </option>
                @endforeach
            </select>
        </div>
        {{csrf_field()}}
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
            <button type="submit" class="btn btn-default">Submit</button>
        </div>
    </form>
@endsection
