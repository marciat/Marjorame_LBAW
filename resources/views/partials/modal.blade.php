<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="staticBackdropLabel"> {{ $title }} </h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <form method="POST" class="needs-validation" action="{{ route($url) }}" >
      @csrf
      <fieldset>
        <div class="modal-body">
          <p>{{ $description }}</p>
          <label for="modalPassword" class="sr-only">password</label>
          <input type="password" id="modalPassword" name="password" class="form-control" placeholder="Password" required>
          @if (session()->has('password-error'))
            <span class="error">
              {{ session()->get('password-error') }}
            </span>
          @endif
        </div>
        <div class="modal-footer">
          <button type="submit" value="submit" class="submit_action_btn danger_button">Confirm</button>
          <button type="button" class="cancel_button" data-dismiss="modal">Cancel</button>
        </div>
      </fieldset>
    </form>
  </div>
</div>