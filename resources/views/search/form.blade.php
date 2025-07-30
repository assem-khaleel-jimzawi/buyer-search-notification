<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Search - Find Parts</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">
                <i class="fas fa-search text-blue-600 mr-3"></i>
                Buyer Search
            </h1>
            <p class="text-gray-600 text-lg">Find the parts you need quickly and easily</p>
        </div>

        <!-- Search Form -->
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-8 mb-8">
            <form method="POST" action="{{ route('search.handle') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="query" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-tools mr-2"></i>Search for Parts
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            name="query" 
                            id="query"
                            placeholder="Enter part name (e.g., Battery, Alternator, Brake Pad)..." 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            value="{{ old('query') }}"
                        >
                        <button type="submit" class="absolute right-2 top-2 bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Status Messages -->
            @if(session('status'))
                <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('status') }}
                </div>
            @endif

            @error('query')
                <div class="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Quick Search Suggestions -->
        <div class="max-w-2xl mx-auto">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">
                <i class="fas fa-lightbulb mr-2 text-yellow-500"></i>
                Popular Searches
            </h3>
            <div class="flex flex-wrap gap-2">
                <button onclick="setSearchValue('Battery')" class="px-4 py-2 bg-blue-100 text-blue-700 rounded-full hover:bg-blue-200 transition duration-200 text-sm">
                    Battery
                </button>
                <button onclick="setSearchValue('Alternator')" class="px-4 py-2 bg-blue-100 text-blue-700 rounded-full hover:bg-blue-200 transition duration-200 text-sm">
                    Alternator
                </button>
                <button onclick="setSearchValue('Brake')" class="px-4 py-2 bg-blue-100 text-blue-700 rounded-full hover:bg-blue-200 transition duration-200 text-sm">
                    Brake Pad
                </button>
                <button onclick="setSearchValue('Car')" class="px-4 py-2 bg-blue-100 text-blue-700 rounded-full hover:bg-blue-200 transition duration-200 text-sm">
                    Car Parts
                </button>
            </div>
        </div>
    </div>

    <script>
        function setSearchValue(value) {
            document.getElementById('query').value = value;
            document.getElementById('query').focus();
        }

        // Handle suggestion parameters from URL
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const suggest = urlParams.get('suggest');
            if (suggest) {
                setSearchValue(suggest);
            }
        });
    </script>
</body>
</html>
