@extends('layout.app')
@section('content')
    <annonce-type></annonce-type>
@endsection
@section('js')
    <script>
        title = `TypeAnnonce`;
        cumb = `Liste des Typesannonces`;
        $('.pagetitle').append(title);
        $('#breadcumb').append(cumb);

    </script>
@endsection
