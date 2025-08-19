@extends('app')
@section('content')
    <div class="w-full h-full p-4">
        <div class="flex justify-end mb-2">
            <a href="{{ route('posts.create') }}" class="p-2 bg-blue-600 text-white rounded-md cursor-pointer">Create</a>
        </div>
        <table class="w-full border">
            <thead>
                <tr>
                    <th class="text-center border p-3">NO.</th>
                    <th class="text-center border p-3">Title</th>
                    <th class="text-center border p-3">Image</th>
                    <th class="text-center border p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $post)
                    <tr>
                        <td class="text-center p-3">{{ $loop->index + 1 }}</td>
                        <td class="text-center p-3">{{ $post->title }}</td>
                        <td class="text-center p-3">
                            <img src="{{ \Storage::temporaryUrl($post->image, now()->addHour()) }}" alt="Post image"
                                class="w-40 h-40 object-cover object-center">
                        </td>
                        <td class="w-60 text-center p-3">
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline">
                                @method('DELETE')
                                @csrf
                                <button type="submit"
                                    class="p-1 px-2 bg-red-600 text-white rounded-md cursor-pointer me-2">Delete</button>
                            </form>
                            <a href="{{ route('posts.edit', $post->id) }}"
                                class="p-1 px-2 bg-blue-600 text-white rounded-md cursor-pointer">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center bg-gray-200 p-3">
                            No content yet.
                        </td>
                    </tr>
                @endforelse
                </tr>
            </tbody>
        </table>
    </div>
@endsection
