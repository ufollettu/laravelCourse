@extends('templates.layout');
@section('content')
    <h1>Edit Album</h1>
<form action="/albums/{{$album->id}}" method="POST">
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
    <input type="hidden" name="_method" value="PATCH">
        <div class="form-group">
            <label for="">Name</label>
        <input type="text" name="name" id="" value="{{$album->album_name}}" class="form-control" placeholder="Album name">
        </div>
        <div class="form-group">
            <label for="">Description</label>
            <textarea type="text" name="description" id="" class="form-control" placeholder="Album description">{{$album->description}}</textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
@endsection
