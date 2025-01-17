




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
            "paging": false,       
            "searching": true,    
            "info": false, 
            "lengthChange": false,        
        });
    });
</script>

<div class="table-responsive">
  
    <table id="userTable" class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>{{translate("ID")}}</th>
                <th>{{translate("Name")}}</th>
                <th>{{translate("Email")}}</th>
                <th>{{translate("Level")}}</th>
                <th>{{translate("Change Role")}}</th>
                <th>{{translate("Created At")}}</th>
                <th>{{translate("Updated At")}}</th>
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
                            {{translate("Blocked")}}
                                @break
                            @case(1)
                            {{translate("User")}}
                                @break
                            @case(2)
                            {{translate("Admin")}}
                                @break
                            @case(3)
                            {{translate("Owner")}}
                                @break
                            @default
                            {{translate("Unknown")}}
                        @endswitch
                    </td>
                    <td>
                        @if (Auth::user()->id != $user['id']  && $user['level'] < Auth::user()->level)
                        <div class="dropdown">
                          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            Select Role
                          </button>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            
                            @if (Auth::user()->level >= 3 )
                            <li><a class="dropdown-item" data-user-id="{{ $user['id']  }}" href="#" data-role="Transfer Owner">{{translate("Transfer Owner")}}</a></li>
                            
                            <li><a class="dropdown-item" data-user-id="{{ $user['id']  }}" href="#" data-role="Administrator">{{translate("Administrator")}}</a></li>
                            @endif
                            @if (Auth::user()->level >= 2 )
                            <li><a class="dropdown-item" data-user-id="{{ $user['id']  }}" href="#" data-role="User">{{translate("Regular User")}}</a></li>
                            <li><a class="dropdown-item" data-user-id="{{ $user['id']  }}" href="#" data-role="Blocked">{{translate("Blocked User")}}</a></li>
                            @endif
                          </ul>
                        </div>
                        @endif
                    </td>
                    <td>{{ $user['created_at'] }}</td>
                    <td>{{ $user['updated_at'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <br>
</div>


<div class="modal fade" id="confirmationModal" z-indes="9999" tabindex="1111" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmationModalLabel">{{translate("Confirm Action")}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          {{translate("Are you sure you want to change the role to")}} <span id="roleName"></span>?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{translate("Cancel")}}</button>
          <button type="button" class="btn btn-primary" id="confirmBtn">{{translate("Confirm")}}</button>
        </div>
      </div>
    </div>
  </div>

  <script>

    function handleTransferOwner(userId) {
      //console.log(`Transfer Owner function triggered for user ID: ${userId}`);
      var url = `/User_Change_To_Owner/${userId}`;

        $.ajax({
            url: url,
            type: 'get',
            data: {},
            success: function(response) {
                //console.log(response);
                displayMessage(response.message, 1);
                reload_UserList();
            },
            error: function(xhr) {
                //console.log(xhr.responseText);
                displayMessage("Error", 2);
            }
        });
    }
  
    function handleAdministrator(userId) {
      //console.log(`Administrator function triggered for user ID: ${userId}`);
      var url = `/User_Change_To_Administrator/${userId}`;

        $.ajax({
            url: url,
            type: 'get',
            data: {},
            success: function(response) {
                //console.log(response);
                displayMessage(response.message, 1);
                reload_UserList();
            },
            error: function(xhr) {
                //console.log(xhr.responseText);
                displayMessage("Error", 2);
            }
        });
    }
  
    function handleUser(userId) {
      //console.log(`User function triggered for user ID: ${userId}`);

      var url = `/User_Change_To_Regular/${userId}`;

        $.ajax({
            url: url,
            type: 'get',
            data: {},
            success: function(response) {
                //console.log(response);
                displayMessage(response.message, 1);
                reload_UserList();
            },
            error: function(xhr) {
                //console.log(xhr.responseText);
                displayMessage("Error", 2);
            }
        });
    }
  
    function handleBlocked(userId) {
      //console.log(`Blocked function triggered for user ID: ${userId}`);
      var url = `/User_Change_To_Blocked/${userId}`;

      $.ajax({
            url: url,
            type: 'get',
            data: {},
            success: function(response) {
                //console.log(response);
                displayMessage(response.message, 1);
                reload_UserList();
            },
            error: function(xhr) {
                //console.log(xhr.responseText);
                displayMessage("Error", 2);
            }
        });
    }

    document.querySelectorAll('.dropdown-item').forEach(function (item) {
      item.addEventListener('click', function (event) {
        event.preventDefault();
        var role = item.getAttribute('data-role'); 
        var userId = item.getAttribute('data-user-id'); 
        document.getElementById('roleName').textContent = role; 
        document.getElementById('confirmationModal').setAttribute('data-user-id', userId);
        var modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
        modal.show(); 
      });
    });
  

    document.getElementById('confirmBtn').addEventListener('click', function () {
      var role = document.getElementById('roleName').textContent;
      var userId = document.getElementById('confirmationModal').getAttribute('data-user-id');
  
      switch (role) {
        case "Transfer Owner":
          handleTransferOwner(userId);
          break;
        case "Administrator":
          handleAdministrator(userId);
          break;
        case "User":
          handleUser(userId);
          break;
        case "Blocked":
          handleBlocked(userId);
          break;
        default:
          //console.log(`Unknown role: ${role} for user ID: ${userId}`);
      }
      //console.log(`Role confirmed: ${role} for user ID: ${userId}`);

      var modal = bootstrap.Modal.getInstance(document.getElementById('confirmationModal'));
      modal.hide();
    });


    function reload_UserList() {
    setTimeout(function() {
        $.ajax({
            url: '/Live_User_List', 
            type: 'GET',
            success: function(response) {
                //alert('reload cart');
                $('#user-list-container').html(response.view); 
            },
            error: function(xhr) {
                displayMessage("Error", 2);
                console.error('Error Reloading List:', xhr.responseText); 
            }
        });
    }, 50);

}

  </script>