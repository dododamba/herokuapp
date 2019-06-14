@extends('layout.app')
@section('content')
    <clientlist></clientlist>
@endsection
@section('js')
    <script>
        title = `Clients`;
        cumb = `Liste des client`;
        $('.pagetitle').append(title);
        $('#breadcumb').append(cumb);
      
    </script>
@endsection
