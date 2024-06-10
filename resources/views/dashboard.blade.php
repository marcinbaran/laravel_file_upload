@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>My Files</h1>
        <form action="{{ route('upload') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file">
            <button type="submit">Upload</button>
        </form>

        @if(session('success'))
            <p>{{ session('success') }}</p>
        @endif


        @if($files && count($files) > 0)
            <ul>
                @foreach($files as $file)
                    <li>
                        {{ $file->file_name }}
                        <a href="{{ route('download', $file->id) }}">Download</a>
                        <form action="{{ route('delete', $file->id) }}" method="post" style="display:inline;">
                            @csrf
                            @method('delete')
                            <button type="submit">Delete</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p>No files found.</p>
        @endif
    </div>
@endsection
