<div class="modal fade" id="banModal" tabindex="-1" role="dialog" aria-labelledby="banModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="banModalTitle">Are you sure you want to ban this user?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form>
        <fieldset>
          <div class="modal-body">
            <label class="sr-only" for="passwordCheckBan">Password</label>
            <input type="password" id="passwordCheckBan" name="ban_password" class="form-control" placeholder="Password" required>
          </div>
          <span class="error row px-3" id="banError"></span>
          <div class="modal-footer">
            <button type="button" class="cancel_button" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger" onclick="banUser(event)">Ban User</button>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="unbanModal" tabindex="-1" role="dialog" aria-labelledby="unbanModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="unbanModalTitle">Are you sure you want to unban this user?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form>
        <fieldset>
          <div class="modal-body">
            <label class="sr-only" for="passwordCheckBan">Password</label>
            <input type="password" id="passwordCheckUnban" name="unban_password" class="form-control" placeholder="Password" required>
          </div>
          <span class="error row px-3" id="unbanError"></span>
          <div class="modal-footer">
            <button type="button" class="cancel_button" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger" onclick="unbanUser(event)">Unban User</button>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>



<div class="admin_users_table table-responsive mt-5">
  <table class="table table-md table-striped">
    <thead id="admin_users_head">
      <tr>
        <th>Username</th>
        <th>Status</th>
        <th>Full Name</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @each('partials.user_control', $users, 'user')
    </tbody>
  </table>
</div>
<div class="row justify-content-center">
  <nav>
    {{$users->links()}}
  </nav>
</div>

<script type="text/javascript" src="{{ asset('js/admin.js') }}" defer> </script>