@extends('templates.layout');
@section('title', 'Blog')
@section('content')
    <h1>Blog</h1>
    {{--
        da laravel 5.4 è possibile e preferibile usare
        i componenti con slot invece di include
    --}}

    {{-- passare valori ai componenti, 2 modi --}}

    {{-- modo 1 con @slot() --}}
    @component('components.card')
        @slot('img_url', 'https://vignette.wikia.nocookie.net/battlefordreamisland/images/0/0b/Rock.png/revision/latest/scale-to-width-down/640?cb=20181009081533')
        @slot('img_title', 'second')

        <p>image test slot</p>
    @endcomponent

    {{-- modo 2 --}}
    @component('components.card', [ 'img_title' => 'image blog', 'img_url' => 'https://vignette.wikia.nocookie.net/battlefordreamisland/images/0/0b/Rock.png/revision/latest/scale-to-width-down/640?cb=20181009081533'])

        <p>image test</p>
    @endcomponent
@endsection

@section('footer') @parent
@endsection
