@extends('admin.admin')

@section('title', 'Edit blog')

@section('content')
<div class="flex-1 p-6">

    <!-- skills Table -->
    <div class="bg-white p-5 shadow rounded-lg overflow-hidden" x-data="{ 
        uploadOption: 'link', 
        imagePreview: '' 
     }">
        <form action="{{ route('admin.blog.update',['id'=>$blog->BLOG_ID]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="transition duration-300">
                <label for="IMAGE" class="block text-sm font-semibold text-gray-700 mb-1">Upload Image</label>
                <input type="file" name="IMAGE" id="IMAGE" accept="image/*" 
                       @change="imagePreview = URL.createObjectURL($event.target.files[0])"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="mb-6">
                <label for="TITLE" class="block text-sm font-medium text-gray-700 mb-2">
                    Title
                </label>
                <input
                    type="text"
                    id="TITLE"
                    name="TITLE"
                    placeholder="Enter skills name"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                    value="{{ $blog->TITLE }}"
                    required
                />
            </div>
            <div class="mb-6">
                <label for="CONTENT" class="block text-sm font-medium text-gray-700 mb-2">
                    Content
                </label>
                <textarea name="CONTENT" id="CONTENT" class="w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" cols="30" rows="10" required>{{ $blog->CONTENT }}</textarea>
            </div>

            <!-- Modal Actions -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.blog.show') }}" id="cancelButton" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-md hover:bg-gray-200 transition">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript for Modal -->
<script>
    function artworkModalLogic() {
        return {
            uploadOption: 'link', // Default option
            imagePreview: '', // Default image preview
            onFileChange(event) {
                const file = event.target.files[0];
                if (file) {
                    this.imagePreview = URL.createObjectURL(file);
                }
            },
            onImageURLChange(event) {
                this.imagePreview = event.target.value;
            }
        };
    }
</script>
@endsection
