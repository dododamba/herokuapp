@extends('layout.app')
@section('content')
    <partenairelist></partenairelist>
@endsection
@section('js')
    <script>
        title = `Partenaire`;
        cumb = `Liste des partenaire`;
        $('.pagetitle').append(title);
        $('#breadcumb').append(cumb);
      
    </script>
@endsection
