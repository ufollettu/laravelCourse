@extends('templates.layout');
@section('content')
    <h1>Create Album</h1>
    @include('partials.inputerrors')

    <form action="{{route('album.save')}}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
        <div class="form-group">
            <label for="">Name</label>
        <input type="text" name="name" id="name" value="{{old('name')}}" class="form-control" placeholder="Album name">
        </div>
        @include('albums.partials.fileupload')
        <div class="form-group">
            <label for="">Description</label>
            <textarea type="text" name="description" id="" value="{{old('description')}}" class="form-control" placeholder="Album description"></textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
@endsection
