<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - Buyer Search</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">
                <i class="fas fa-search text-blue-600 mr-3"></i>
                Search Results
            </h1>
            <p class="text-gray-600 text-lg">Found parts matching your search</p>
        </div>

        <!-- Search Query Info -->
        <div class="max-w-4xl mx-auto mb-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800 mb-2">
                            <i class="fas fa-search text-blue-600 mr-2"></i>
                            Search Query: "{{ $query }}"
                        </h2>
                        <p class="text-gray-600">
                            <i class="fas fa-clock mr-2"></i>
                            Search completed on {{ now()->format('F j, Y \a\t g:i A') }}
                        </p>
                    </div>
                    <a href="{{ route('search.form') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        New Search
                    </a>
                </div>
            </div>
        </div>

        <!-- Results Summary -->
        <div class="max-w-4xl mx-auto mb-6">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-center">
                    <i class="fas fa-info-circle text-blue-600 mr-3 text-xl"></i>
                    <div>
                        <p class="text-blue-800 font-medium">
                            Found <span class="font-bold text-blue-900">{{ $results->count() }}</span> 
                            part{{ $results->count() !== 1 ? 's' : '' }} matching your search
                        </p>
                        @if($results->count() > 0)
                            <p class="text-blue-700 text-sm mt-1">
                                These parts are now saved to your search history and you'll receive email notifications for future matches.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Results -->
        <div class="max-w-4xl mx-auto">
            @if($results->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($results as $result)
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                            <!-- Part Image Placeholder -->
                            <div class="h-48 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                <i class="fas fa-cog text-white text-4xl"></i>
                            </div>
                            
                            <!-- Part Details -->
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="text-xl font-bold text-gray-800">{{ $result->part->name }}</h3>
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                        Available
                                    </span>
                                </div>
                                
                                @if($result->part->description)
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                        {{ $result->part->description }}
                                    </p>
                                @endif
                                
                                <div class="flex items-center justify-between">
                                    <div class="text-2xl font-bold text-green-600">
                                        ${{ number_format($result->part->price, 2) }}
                                    </div>
                                    <div class="flex space-x-2">
                                        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200 text-sm">
                                            <i class="fas fa-eye mr-1"></i>
                                            View Details
                                        </button>
                                        <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200 text-sm">
                                            <i class="fas fa-shopping-cart mr-1"></i>
                                            Add to Cart
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Part Specifications -->
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-500">Part ID:</span>
                                            <span class="font-medium text-gray-800">#{{ $result->part->id }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Category:</span>
                                            <span class="font-medium text-gray-800">Auto Parts</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- No Results -->
                <div class="bg-white rounded-lg shadow-lg p-12 text-center">
                    <div class="mb-6">
                        <i class="fas fa-search text-gray-400 text-6xl mb-4"></i>
                        <h3 class="text-2xl font-semibold text-gray-800 mb-2">No Parts Found</h3>
                        <p class="text-gray-600 mb-6">
                            We couldn't find any parts matching "{{ $query }}". 
                            Try searching with different keywords or browse our popular categories.
                        </p>
                    </div>
                    
                    <!-- Search Suggestions -->
                    <div class="max-w-md mx-auto">
                        <h4 class="text-lg font-medium text-gray-700 mb-4">Try these searches:</h4>
                        <div class="flex flex-wrap gap-2 justify-center">
                            <button onclick="window.location.href='{{ route('search.form') }}?suggest=Battery'" class="px-4 py-2 bg-blue-100 text-blue-700 rounded-full hover:bg-blue-200 transition duration-200 text-sm">
                                Battery
                            </button>
                            <button onclick="window.location.href='{{ route('search.form') }}?suggest=Alternator'" class="px-4 py-2 bg-blue-100 text-blue-700 rounded-full hover:bg-blue-200 transition duration-200 text-sm">
                                Alternator
                            </button>
                            <button onclick="window.location.href='{{ route('search.form') }}?suggest=Brake'" class="px-4 py-2 bg-blue-100 text-blue-700 rounded-full hover:bg-blue-200 transition duration-200 text-sm">
                                Brake Pad
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="max-w-4xl mx-auto mt-12 text-center">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-bell text-yellow-500 mr-2"></i>
                    Get Notified
                </h3>
                <p class="text-gray-600 mb-4">
                    We'll notify you when new parts matching your search become available.
                </p>
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('search.form') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200">
                        <i class="fas fa-search mr-2"></i>
                        New Search
                    </a>
                    <button class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition duration-200">
                        <i class="fas fa-envelope mr-2"></i>
                        Subscribe to Updates
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 