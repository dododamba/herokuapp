@extends('layout.app')
@section('content')
    <index-partenaire></index-partenaire>
@endsection
@section('js')
    <script>
        title = `Partenaires`;
        cumb = `Liste des Partenaire`;
        $('.pagetitle').append(title);
        $('#breadcumb').append(cumb);

    </script>
@endsection
