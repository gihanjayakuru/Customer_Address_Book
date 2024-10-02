<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer List</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h1>Customer List</h1>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Company</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Country</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                <tr data-toggle="collapse" data-target="#details{{ $customer->id }}" class="accordion-toggle">
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->company }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->country }}</td>
                    <td>{{ $customer->status ? 'Active' : 'Inactive' }}</td>
                </tr>
                <tr>
                    <td colspan="6" class="hiddenRow">
                        <div class="accordian-body collapse" id="details{{ $customer->id }}">
                            <strong>Addresses:</strong>
                            <ul>
                                @foreach ($customer->addresses as $address)
                                <li>{{ $address->street }}, {{ $address->city }}, {{ $address->state }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>