@if(!$users->isEmpty())
@foreach ($users as $user)

<tr>
<td>{{ ++$i }}</td>
<td><img src="{{ asset('storage/'.$user->image)}}" alt="Image" width="50" height="50" /></td>
<td>{{ $user->name }}</td>
<td>{{ $user->email }}</td>
<td>{{ $user->gender }}</td>
<td>{{ $user->role->role_name }}</td>
<td>{{ date("d-m-Y", strtotime($user->birth_date)) }}</td>
@if(Session::get('user_data')['role_id'] != 6)
<td style="white-space: nowrap;"><a class="btn btn-info btn-sm" href="{{route('students.edit',$user->id)}}">Edit</a> | <a class="btn btn-danger btn-sm" href="javascript:;" onclick="confirmDelete('{{$user->id}}')">Delete</a>
    <form id="delete-user-{{$user->id}}" action="{{ route('students.destroy', $user->id) }}" method="POST" style="display: none;">

    @method('DELETE')
    @csrf
    </form>
    </td>
@else
<td>-</td>
@endif
@endforeach
@else
<tr>
<td colspan="11" class="text-center">No Records Found..</td>
</tr>
@endif
{!! $users->links() !!}
