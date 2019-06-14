@extends('layout.app')
@section('content')

    <personnellist></personnellist>
@endsection

@section('js')

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
        window.axios.defaults.headers.common = {
            'X-Requested-With': 'XMLHttpRequest',
        };
    </script>

@endsection