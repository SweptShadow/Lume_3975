<form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text" name="description" placeholder="Description">
    <input type="file" name="image">
    <button type="submit">Upload</button>
</form>