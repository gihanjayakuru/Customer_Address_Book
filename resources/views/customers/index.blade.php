@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Customers</h1>
    <a href="{{ route('customers.create') }}" class="btn btn-primary mb-2"><i class="fa fa-plus"></i> Add Customer</a>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Company</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Country</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
            <tr onclick="toggleDetails({{ $customer->id }})" style="cursor: pointer;">
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->company }}</td>
                <td>{{ $customer->phone }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->country }}</td>
                <td>{{ $customer->status }}</td>
                <td>
                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-info">Edit</a>
                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST"
                        style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            <tr id="details-{{ $customer->id }}" style="display: none;">
                <td colspan="7">
                    <ul>
                        @foreach ($customer->addresses as $address)
                        <li>{{ $address->number }}, {{ $address->street }}, {{ $address->city }}</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    function toggleDetails(customerId) {
    const details = document.getElementById('details-' + customerId);
    const isVisible = details.style.display === 'table-row';
    details.style.display = isVisible ? 'none' : 'table-row';
}
</script>
@endsection