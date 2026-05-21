@extends('layouts.installer')

@section('subtitle', 'Create Administrator Account')

@section('content')
<form action="{{ route('install.processAdmin') }}" method="POST" class="space-y-5">
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
        <label class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-1">Full Name</label>
        <input type="text" name="name" value="{{ old('name') }}" required class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-black focus:border-black transition-colors">
    </div>
    
    <div>
        <label class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-1">Email Address</label>
        <input type="email" name="email" value="{{ old('email') }}" required class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-black focus:border-black transition-colors">
    </div>

    <div>
        <label class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-1">Password</label>
        <input type="password" name="password" required class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-black focus:border-black transition-colors">
    </div>

    <div>
        <label class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-1">Confirm Password</label>
        <input type="password" name="password_confirmation" required class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-black focus:border-black transition-colors">
    </div>

    <div class="pt-2">
        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-black hover:bg-gray-800 transition-colors">
            Finish Setup
        </button>
    </div>
</form>
@endsection
