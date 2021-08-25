<div class="w-full shadow flex justify-center bg-white">
    <div class="container flex justify-between">
        <a href="{{ route('home') }}" class="p-6 bg-gray-800">
            <span class="font-mono font-bold text-white">Conference 2021</span>
        </a>

        <div class="flex">
            @if(auth()->user())
                <a href="{{ route('auth.logout') }}" class="p-6 hover:font-bold">
                    <span>Logout</span>
                </a>
            @else
                <a href="{{ route('auth.login') }}" class="p-6 hover:font-bold">
                    <span>Login</span>
                </a>

                <a href="{{ route('auth.login') }}" class="p-6 hover:font-bold">
                    <span>Register</span>
                </a>
            @endif

            <a href="{{ route('photos.create') }}" class="p-6 hover:font-bold">
                <span>Upload</span>
            </a>
        </div>
    </div>
</div>
