@extends ('layouts.default_body')
@section('content')

<script type="text/javascript" src="{{ asset('js/.js') }}"></script>


<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<!-- Optional: Bootstrap DataTables Styling -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<!-- Optional: Bootstrap DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        $('#userTable').DataTable({
            "order": [[0, "asc"]], 
            "paging": true,       
            "searching": true,    
            "info": true, 
            "lengthChange": false,        
        });
    });
</script>


<div class="default_container_margin">
<div class="container">
<div class= "row no_margin primary_background_color default_padding default_margin default_radius under_shadow default_large_margin_bottom">

    <div class="col default_padding">

        <div class="table-responsive">
            <table id="userTable" class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Level</th>
                        <th>Email Verified</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_users as $user)
                        <tr>
                            <td>{{ $user['id'] }}</td>
                            <td>{{ $user['name'] }}</td>
                            <td>{{ $user['email'] }}</td>
                            <td>
                                @switch($user['level'])
                                    @case(-1)
                                        Blocked
                                        @break
                                    @case(1)
                                        User
                                        @break
                                    @case(2)
                                        Admin
                                        @break
                                    @case(3)
                                        Owner
                                        @break
                                    @default
                                        Unknown
                                @endswitch
                            </td>
                            <td>{{ $user['email_verified_at'] ?? 'Not Verified' }}</td>
                            <td>{{ $user['created_at'] }}</td>
                            <td>{{ $user['updated_at'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    
</div>
</div>
</div>


@endsection