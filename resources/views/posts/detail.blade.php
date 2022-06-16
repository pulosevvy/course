<x-guest-layout>
    
    <div class="mt-12 max-w-6xl mx-auto">

        <div class="flex justify-start m-2 p-2">
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-indigo-400 hover:bg-indigo-600 rounded">
                Back
            </a>
        </div>

        <div class="relative overflow-x-auto shadow-md bg-grey-200 sm:rounded-lg">
            <table class="w-full text-sm text-left text-grey-500 dark:text-grey-400">
                <tr>

                    <th scope="col" class="px-6 py-3">
                        ID
                    </th>

                    <th scope="col" class="px-6 py-3">
                        Title
                    </th>

                    <th scope="col" class="px-6 py-3">
                        Body
                    </th>

                    <th scope="col" class="px-6 py-3">
                        Category
                    </th>

                    <th scope="col" class="px-6 py-3">
                        <span class="sr-only">Edit</span>
                    </th>

                </tr>
                <thead>
                    <tbody>

                            <tr class="bg-white border-b dark:bg-grey-800 dark:border-grey-700">
                                
                                <th scope="row" class="px-6 py-4 font-medium text-grey-900 dark:text-white whitespace-nowrap">
                                    {{ $posts->id }}
                                </th>
                                
                                <th scope="row" class="px-6 py-4 font-medium text-grey-900 dark:text-white whitespace-nowrap">
                                    {{ $posts->title }}
                                </th>

                                <th scope="row" class="px-6 py-4 font-medium text-grey-900 dark:text-white whitespace-nowrap">
                                    {{ $posts->body }}
                                </th>
                                
                                <th scope="row" class="px-6 py-4 font-medium text-grey-900 dark:text-white whitespace-nowrap">
                                    {{ $posts->category->title ?? 'no category'}}
                                </th>

                                <td class="px-6 py-4 text-right">
                                    <div class="flex space-x-2">
                                       @can('update', $posts)
                                       <a href="{{ route('posts.edit', $posts->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" style="padding-right: 10px">Edit</a>
                                       @endcan
                                        @can('delete', $posts)
                                       <form method="POST" action="{{ route('posts.destroy', $posts->id)}}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">
                                                Delete
                                            </button>
                                        </form>    
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                    </tbody>
                </thead>
            </table>
        </div>

        {{-- comments --}}

        <form style="margin-top: 50px;" class="space-y-5" method="POST" action="{{ route('comment.store', $posts->id) }}">
            @csrf
            <h2>Comment</h2>
            <div style="display: flex; align-items: center;">
                
                <input id="comment_body" type="text" name="comment_body" class="block w-1000px py-3 px-3 mt-2 text-gray-800 appearance-none border-3 border-gray-100 ">
                <input type="hidden" name="post_id" value="{{ $posts->id }}" />
                @error('comment_body')
                    <span class="text-sm text-red-400">{{ $message }}</span>
                @enderror
                <button type="submit"  style="height: 50px; margin-left: 20px" class="bg-indigo-400 rounded-md  text-white uppercase focus:outline-none hover:shadow-none">
                    Create
                </button>
            </div>
        </form>


        <div class="relative overflow-x-auto shadow-md bg-grey-200 sm:rounded-lg py-20" style="margin-top: 50px;">
            <table class="w-full text-sm text-left text-grey-500 dark:text-grey-400">
                @foreach($posts->comments as $comment)
                <tr>
                    <th scope="col" class="px-6 py-3">
                        {{ $comment->user->name}}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
                
                <thead>
                    <tbody>
                            <tr class="bg-white border-b dark:bg-grey-800 dark:border-grey-700">
                                <th scope="row" class="px-6 py-4 font-medium text-grey-900 dark:text-white whitespace-nowrap">
                                    {{ $comment->comment_body}}
                                </th>
                                
                                <td class="px-6 py-4 text-right">
                                    @if(Auth::check() && Auth::id() == $comment->user_id || auth()->user()->hasRole('admin'))
                                    <div class="flex space-x-2">
                                       
                                        <a href="{{ route('comment.edit', ['id' => $posts->id, 'comm' => $comment->id])}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" style="padding-right: 10px">Edit</a>
                                       
                                        <form method="POST" action="{{ route('comment.delete', ['id' => $posts->id, 'comm' => $comment->id]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">
                                                Delete
                                            </button>
                                        </form>    
                                        
                                    </div>
                                    @endif

                                </td>
                            </tr>
                            @endforeach
            
                    </tbody>
                </thead>
            </table>
        </div>

    </div>

    
</x-guest-layout>