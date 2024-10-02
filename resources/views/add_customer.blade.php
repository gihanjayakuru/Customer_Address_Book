<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add/Edit Customer</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h1>{{ $customer ? 'Edit' : 'Add' }} Customer</h1>
        <form method="post" action="{{ $customer ? route('customers.update', $customer) : route('customers.store') }}">
            @csrf
            @if($customer)
            @method('PUT')
            @endif
            <div class="form-group">
                <label>Customer Name</label>
                <input type="text" name="name" class="form-control" value="{{ $customer->name ?? '' }}" required>
            </div>
            <div class="form-group">
                <label>Company</label>
                <input type="text" name="company" class="form-control" value="{{ $customer->company ?? '' }}" required>
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone" class="form-control" value="{{ $customer->phone ?? '' }}" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ $customer->email ?? '' }}" required>
            </div>
            <div class="form-group">
                <label>Country</label>
                <input type="text" name="country" class="form-control" value="{{ $customer->country ?? '' }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>