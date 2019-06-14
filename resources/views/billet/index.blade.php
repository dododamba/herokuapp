@extends('layout.app')
@section('content')
    <billet></billet>
@endsection
@section('js')
    <script>
        title = `Administrateurs`;
        cumb = `Liste des administrateurs`;
        $('.pagetitle').append(title);
        $('#breadcumb').append(cumb);

    </script>
@endsection
