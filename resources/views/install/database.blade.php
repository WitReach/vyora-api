@extends('layouts.installer')

@section('subtitle', 'Database Configuration')

@section('content')
<form action="{{ route('install.processDatabase') }}" method="POST" class="space-y-5">
    @csrf
    
    @if($errors->any())
        <div class="p-4 rounded-xl bg-red-50 border border-red-100">
            <ul class="text-sm text-red-600 font-medium">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div>
        <label class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-1">Host</label>
        <input type="text" name="db_host" value="{{ old('db_host', '127.0.0.1') }}" required class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-black focus:border-black transition-colors">
    </div>
    
    <div>
        <label class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-1">Port</label>
        <input type="text" name="db_port" value="{{ old('db_port', '3306') }}" required class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-black focus:border-black transition-colors">
    </div>

    <div>
        <label class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-1">Database Name</label>
        <input type="text" name="db_database" value="{{ old('db_database', 'vyora') }}" required class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-black focus:border-black transition-colors">
    </div>

    <div>
        <label class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-1">Username</label>
        <input type="text" name="db_username" value="{{ old('db_username', 'root') }}" required class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-black focus:border-black transition-colors">
    </div>

    <div>
        <label class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-1">Password</label>
        <input type="password" name="db_password" class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-black focus:border-black transition-colors">
    </div>

    <div class="pt-2">
        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-black hover:bg-gray-800 transition-colors">
            Connect & Run Migrations
        </button>
    </div>
</form>
@endsection
