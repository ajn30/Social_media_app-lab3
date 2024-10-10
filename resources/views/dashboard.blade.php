<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success and Error Messages -->
            @if (session('success'))
                <x-alert type="success" :message="session('success')" />
            @endif

            <!-- User Profile Section -->
            <section class="bg-gray-100 rounded-lg mb-6">
    <div class="relative">
        <img 
            src="{{ Auth::user()->background_picture ? Storage::url(Auth::user()->background_picture) : asset('images/default-background.jpg') }}" 
            alt="Background" 
            class="w-full h-32 object-cover rounded-t-lg"> <!-- Adjusted height -->
        <div class="absolute left-1/2 transform -translate-x-1/2 -bottom-13"> <!-- Raised profile picture -->
            <img 
                src="{{ Auth::user()->profile_picture ? Storage::url(Auth::user()->profile_picture) : asset('images/default-avatar.png') }}" 
                alt="{{ Auth::user()->name }}'s profile picture" 
                class="w-32 h-32 rounded-full border-4 border-white shadow-lg"> <!-- Profile picture size -->
        </div>
    </div>
    <div class="p-6 text-center"> <!-- Center text -->
        <h2 class="text-2xl font-semibold">{{ Auth::user()->name }}</h2>
        <p class="text-gray-600">{{ Auth::user()->email }}</p>
    </div>
</section>


            <!-- Post Creation Section -->
            <section class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-6 rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-4 text-teal-600">Create a Post</h3>
                <form action="{{ route('posts.store') }}" method="POST">
                    @csrf
                    <textarea name="content" rows="4" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-teal-500" placeholder="What's on your mind?"></textarea>
                    <button type="submit" class="mt-3 bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500">Post</button>
                </form>
            </section>

            <!-- Recent Posts Section -->
            <section class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-6 rounded-lg">
                <h3 class="text-lg font-semibold mb-4 text-teal-600">Recent Posts</h3>
                <div class="space-y-4">
                    @foreach($posts as $post)
                        <div class="bg-gray-50 border border-gray-200 p-4 rounded-lg shadow-md">
                            <div class="flex items-center mb-3">
                                <img src="{{ $post->user->profile_picture ? Storage::url($post->user->profile_picture) : asset('images/default-avatar.png') }}" alt="{{ $post->user->name }}'s profile picture" class="w-10 h-10 rounded-full border-2 border-gray-300 mr-3">
                                <h4 class="font-semibold text-gray-800">{{ $post->user->name }}</h4>
                                <p class="text-sm text-gray-600 ml-auto">{{ $post->created_at->diffForHumans() }}</p>
                            </div>
                            <p class="text-gray-800">{{ $post->content }}</p>
                            <div class="mt-3 flex items-center space-x-4">
                                <form action="{{ route('posts.like', $post->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-teal-600 hover:text-teal-700 focus:outline-none">
                                        @if($post->likes->contains(Auth::id()))
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"></path></svg>
                                        @else
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        @endif
                                    </button>
                                </form>
                                <form action="{{ route('comments.store', $post->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <input type="text" name="comment" placeholder="Add a comment..." class="w-full border border-gray-300 rounded-lg p-2" required>
                                    <button type="submit" class="bg-teal-600 text-white px-3 py-1 rounded-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500">Comment</button>
                                </form>
                            </div>
                            <!-- Comments Section -->
                            <div class="mt-4 space-y-2">
                                @foreach($post->comments as $comment)
                                    <div class="border-t border-gray-200 pt-2">
                                        <div class="flex items-center">
                                            <img src="{{ $comment->user->profile_picture ? Storage::url($comment->user->profile_picture) : asset('images/default-avatar.png') }}" alt="{{ $comment->user->name }}'s profile picture" class="w-8 h-8 rounded-full border-2 border-gray-300 mr-2">
                                            <p class="font-semibold text-gray-800">{{ $comment->user->name }}:</p>
                                            <p class="text-gray-600 ml-2">{{ $comment->content }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
