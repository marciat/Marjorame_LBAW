@if($user->admin || ($user->buyer && $user->buyer->status != 'Deleted'))
<tr>
  <td>{{$user->username}}</td>
  @if($user->admin)
    <td>Admin</td>
  @elseif($user->active())
    <td>Buyer</td>
  @else
    <td>{{$user->buyer->status}}</td>
  @endif

  <td>{{$user->first_name}} {{$user->last_name}}</td>
  <td>
    @if(!$user->admin)
      @if($user->buyer->status == 'Active')
        <button type="button" class="btn-sm btn-danger my-n1 px-4" onclick="setUserForModeration(event,{{$user->buyer->id}})" data-toggle="modal" data-target="#banModal">Ban</button>
      @else
        <button type="button" class="btn-sm btn-danger my-n1 px-3" onclick="setUserForModeration(event,{{$user->buyer->id}})" data-toggle="modal" data-target="#unbanModal">Unban</button>
      @endif
    @endif
  </td>
</tr>
@else
  <td> Deleted </td>
  <td> Deleted</td>
  <td> Deleted</td>
  <td> Deleted</td>
@endif