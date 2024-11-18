<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approval Management</title>
</head>
<body>
    <h1>Persetujuan User</h1>
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif
    <ul>
        @foreach ($pendingUsers as $user)
            <li>
                {{ $user->name }} - {{ $user->email }}
                <form action="{{ route('admin.approve-user', $user->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit">Approve</button>
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>
