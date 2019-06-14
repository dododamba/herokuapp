@extends('layout.app')
@section('content')
    <log></log>
@endsection
@section('js')
    <script>
        title = `Historique de connection`;
        cumb = `Historique`;
        $('.pagetitle').append(title);
        $('#breadcumb').append(cumb);
      
    </script>
@endsection
