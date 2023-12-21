<!-- upload-form.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Upload Excel File</title>
</head>

<body>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <form method="POST" action="{{ route('uploadExcel') }}" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" accept=".xlsx,.xls">
        <button type="submit">Upload</button>
    </form>
</body>

</html>
