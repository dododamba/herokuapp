@extends('layout.app')
@section('content')
    <annonce-list></annonce-list >
@endsection
@section('js')
    <script>
        title = `annonce`;
        cumb = `Liste des annonces`;
        $('.pagetitle').append(title);
        $('#breadcumb').append(cumb);

    </script>
@endsection
