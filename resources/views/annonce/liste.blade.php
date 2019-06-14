@extends('layout.app')
@section('content')
  <annonce-list></annonce-list>
@endsection
@section('js')
    <script>
        title = `ListeAnnonce`;
        cumb = `Liste des annonces`;
        $('.pagetitle').append(title);
        $('#breadcumb').append(cumb);

    </script>
@endsection
