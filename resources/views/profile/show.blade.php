<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->name }}'s Profile</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header text-center">
                <h2>{{ $user->name }}'s Profile</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 d-flex justify-content-center">
                        <img 
                            src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/default-avatar.jpg') }}" 
                            alt="{{ $user->name }}" 
                            class="img-fluid rounded-circle" 
                            style="width: 200px; height: 200px; object-fit: cover;">
                    </div>
                    <div class="col-md-8">
                        <h3>{{ $user->name }}</h3>
                        <p>Email: <a href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>
                        <p>Joined: {{ $user->created_at->format('M d, Y') }}</p>

                        @if (Auth::check() && (Auth::id() === $user->id || Auth::user()->is_admin))
                            <a href="{{ route('profile.edit', $user) }}" class="btn btn-primary">Edit Profile</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
