<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <div class="py-12">
            
        <div style="width: 1450px; display:flex; justify-content: flex-end; margin-bottom: 15px;" >
             <form {{--action="dashboard/"--}} action="{{ route('dashboard') }}"> 
                <div>
                  <input type="search" name="search" @if(isset($_GET['search'])) value="{{ $_GET['search'] }}" @endif  placeholder="Search Aviaplanes.." />
                    
                        <button type="submit">
                        Search
                        </button>
                </div>
                
              </form>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <p>Select Category:</p>
            <form {{--action="dashboard/"--}} action="{{ route('dashboard') }}"> 
               
                <div style="width: 1450px; display:flex; align-items: center; justify-content: flex-start; margin-bottom: 15px;">
                    
                        <select name="filterCategoryId" class="block  py-3 px-3 mb-5 text-gray-800 appearance-none border-2 border-gray-100 focus:text-gray-500 focus:outline-none focus:border-gray-200 rounded-md" style="margin-bottom: 10px;">
                                    <option value=""></option>
                                @foreach ($categories as $category) 
                                    <option value="{{  $category->id  }}" @if(isset($_GET['category_id'])) @if($_GET['category_id'] == $category->id) selected @endif @endif >{{  $category->title  }}</option>
                                @endforeach
                        </select>
                    <button type="submit" class="bnt btn-primary" style="margin-left: 10px;">Submit</button>   
                </div>
            </form>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                   

                <div class="p-6 bg-white border-b border-gray-200">
                    @can('create', App\Models\Post::class)
            <div class="flex justify-end m-2 p-2">
                <a href="{{ route('posts.create') }}" class="px-4 py-2 bg-indigo-400 hover:bg-indigo-600 rounded">
                    New Posts
                </a>
            </div>
        @endcan
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

                            @foreach ($posts as $post) 
                                <tr class="bg-white border-b dark:bg-grey-800 dark:border-grey-700">
                                    
                                    <th scope="row" class="px-6 py-4 font-medium text-grey-900 dark:text-white whitespace-nowrap">
                                        {{ $post->id }}
                                    </th>
                                    
                                    <th scope="row" class="px-6 py-4 font-medium text-grey-900 dark:text-white whitespace-nowrap">
                                        {{ $post->title }}
                                    </th>

                                    <th scope="row" class="px-6 py-4 font-medium text-grey-900 dark:text-white whitespace-nowrap">
                                        {{ $post->body }}
                                    </th>
                                    
                                    <th scope="row" class="px-6 py-4 font-medium text-grey-900 dark:text-white whitespace-nowrap">
                                        {{ $post->category->title ?? 'no category'}}
                                    </th>

                                    <td class="px-6 py-4 text-right">
                                        <div class="flex space-x-2">
                                        @can('update', $post)
                                        <a href="{{ route('posts.edit', $post->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" style="padding-right: 10px">Edit</a>
                                        @endcan
                                            @can('delete', $post)
                                        <form method="POST" action="{{ route('posts.destroy', $post->id)}}">
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
                            @endforeach
                                
                            </tbody>
                        </thead>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>
