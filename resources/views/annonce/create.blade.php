@extends('layout.app')
@section('content')
    <createannonce></createannonce>
@endsection
@section('js')
    <script>
        title = `creation des annonces`;
        cumb = `Creation annonce`;
        $('.pagetitle').append(title);
        $('#breadcumb').append(cumb);

    </script>
@endsection