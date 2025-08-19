@extends('app')
@section('content')
    <div class="w-full h-full flex items-center justify-center">
        <div class="w-120 h-fit border p-3 mx-auto">
            <h4 class="font-bold mb-3">Create a Post</h4>
            <form action="{{ isset($post) ? route('posts.update', $post->id) : route('posts.store') }}" method="POST"
                enctype="multipart/form-data">
                @isset($post)
                    @method('PATCH')
                @else
                    @method('POST')
                @endisset
                @csrf

                <!-- Title -->
                <input type="text" name="title" id="title"
                    class="w-full p-2 border mb-2 focus:border-blue-600 focus:outline-0" placeholder="Title"
                    value="{{ $post->title ?? '' }}">
                <!-- Content -->
                <textarea name="content" id="content" class="w-full p-2 border mb-2 focus:border-blue-600 focus:outline-0"
                    placeholder="Write your content here">{{ $post->content ?? '' }}</textarea>

                <input type="file" name="image" id="image"
                    class="w-full p-2 border mb-2 focus:border-blue-600 focus:outline-0"
                    accept="image/png,image/jpg,image/jpeg" value="{{ $post->image ?? '' }}">

                @isset($post)
                    <img src="{{ \Storage::temporaryUrl($post->image, now()->addHour()) }}" alt="Post image"
                        class="w-40 h-40 object-cover object-center">
                @endisset

                <div class="flex justify-between mt-2">
                    <a href="{{ route('posts.index') }}"
                        class="p-2 px-3 rounded-lg border border-red-400 text-red-400 cursor-pointer">Cancel</a>
                    <button type="submit" class="bg-blue-600 p-2 px-3 rounded-lg text-white cursor-pointer">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
