@extends('layout.app')
@section('title')
User role
@stop

@section('content')
<div class="card card-primary">
<div class="card-body">
    <a href="{{ url('role/create') }}" class="btn btn-success"><h6> + role</h6></a>
    <div class="table">
        <table class="table table-bordered table-striped table-hover" id="tblroles">
            <thead>
                <tr>
                    <th>ID</th><th>Nom</th><th>Action</th>
                </tr>
            </thead>
            <tbody>
           
            @foreach($roles as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td><a href="{{ url('role', $item->id) }}">{{ $item->name }}</td>
                    <td>
                        <a href="{{ url('role/' . $item->id . '/edit') }}" class="btn btn-success btn-xs">Editer</a> 
                        <a href="{{ url('role/' . $item->id . '/permissions') }}" class="btn btn-warning btn-xs">Perrmissions</a> 
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['role', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-xs deleteconfirm']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    </div>
    </div>
 
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#tblroles').DataTable({
                columnDefs: [{
                    targets: [0],
                    visible: false,
                    searchable: false
                    },
                ],
                order: [[0, "asc"]],
            });
        });
     $(".deleteconfirm").on("click", function(){
            return confirm("Are you sure to delete this Role");
        });
    </script>
@endsection