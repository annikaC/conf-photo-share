<div class="w-full shadow flex justify-center bg-white">
    <div class="container flex justify-between">
        <a href="{{ route('home') }}" class="p-3 bg-blue-700">
            <span class="font-mono font-bold text-white">Conference 2021</span>
        </a>

        <div class="flex">
            @if(auth()->user())
                <a href="{{ route('auth.logout') }}" class="p-3 hover:font-bold">
                    <span>Logout</span>
                </a>
            @else
                <a href="{{ route('auth.login') }}" class="p-3 hover:font-bold">
                    <span>Login</span>
                </a>

                <a href="{{ route('auth.login') }}" class="p-3 hover:font-bold">
                    <span>Register</span>
                </a>
            @endif
        </div>
    </div>
</div>
