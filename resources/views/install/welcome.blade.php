@extends('layouts.installer')

@section('subtitle', 'System Requirements Check')

@section('content')
<div class="space-y-4">
    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
        <ul class="space-y-3">
            @foreach($requirements as $req => $met)
            <li class="flex items-center justify-between text-sm font-medium">
                <span class="text-gray-700">{{ $req }}</span>
                @if($met)
                    <span class="px-2.5 py-0.5 rounded-full bg-green-100 text-green-700 text-xs font-bold">Passed</span>
                @else
                    <span class="px-2.5 py-0.5 rounded-full bg-red-100 text-red-700 text-xs font-bold">Failed</span>
                @endif
            </li>
            @endforeach
        </ul>
    </div>

    <div class="pt-4">
        @if($allMet)
            <a href="{{ route('install.database') }}" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-black hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-colors">
                Continue to Database Setup
            </a>
        @else
            <button disabled class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-gray-300 cursor-not-allowed">
                Please fix requirements
            </button>
        @endif
    </div>
</div>
@endsection
