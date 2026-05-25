import React, { useState } from 'react';
import { router } from '@inertiajs/react';
import { Search } from 'lucide-react';

export function SearchInput({ initialValue = '' }: { initialValue?: string }) {
    const [query, setQuery] = useState(initialValue);

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        if (query.trim()) {
            router.get('/search', { q: query.trim() });
        }
    };

    return (
        <form onSubmit={handleSubmit} className="relative w-full">
            <div className="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <Search className="h-5 w-5 text-gray-400" />
            </div>
            <input
                type="text"
                value={query}
                onChange={(e) => setQuery(e.target.value)}
                className="block w-full pl-11 pr-4 py-4 border-2 border-gray-200 rounded-2xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-0 focus:border-gray-900 transition-colors bg-gray-50 text-lg font-medium"
                placeholder="Search for shirts, shoes, pants..."
            />
            <button
                type="submit"
                className="absolute inset-y-2 right-2 px-6 bg-gray-900 hover:bg-gray-800 text-white font-bold rounded-xl transition-colors"
            >
                Search
            </button>
        </form>
    );
}
