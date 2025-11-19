<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Desa Warurejo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-primary-600 to-primary-800 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-lg shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-primary-600 text-white p-6 text-center">
                <h1 class="text-2xl font-bold">Admin Panel</h1>
                <p class="text-primary-100 text-sm mt-1">Desa Warurejo</p>
            </div>

            <!-- Login Form -->
            <div class="p-8">
                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded text-sm">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.login.post') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">
                            Email
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            required
                            autofocus
                        >
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">
                            Password
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            required
                        >
                    </div>

                    <div class="flex items-center mb-6">
                        <input 
                            type="checkbox" 
                            id="remember" 
                            name="remember" 
                            class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500"
                        >
                        <label for="remember" class="ml-2 text-sm text-gray-700">
                            Ingat saya
                        </label>
                    </div>

                    <button 
                        type="submit" 
                        class="w-full bg-primary-600 text-white font-semibold py-3 rounded-lg hover:bg-primary-700 transition duration-200"
                    >
                        Login
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <a href="{{ route('home') }}" class="text-sm text-primary-600 hover:text-primary-800">
                        ← Kembali ke Website
                    </a>
                </div>
            </div>
        </div>

        <div class="text-center mt-4 text-white text-sm">
            <p>&copy; {{ date('Y') }} Desa Warurejo</p>
        </div>
    </div>
</body>
</html>