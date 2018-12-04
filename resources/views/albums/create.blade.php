@extends('templates.layout');
@section('content')
    <h1>Create Album</h1>
    <form action="{{route('album.save')}}" method="POST">
        <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
        <div class="form-group">
            <label for="">Name</label>
        <input type="text" name="name" id="name" value="" class="form-control" placeholder="Album name">
        </div>
        <div class="form-group">
            <label for="">Description</label>
            <textarea type="text" name="description" id="" class="form-control" placeholder="Album description"></textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
@endsection
