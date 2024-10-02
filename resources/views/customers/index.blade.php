@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Customers</h1>
    <a href="{{ route('customers.create') }}" class="btn btn-primary mb-2"><i class="fa fa-plus"></i> Add Customer</a>

    @if ($customers->isEmpty())
    <p>No customers found.</p>
    @else
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
        <tbody id="customer-list">
            @foreach ($customers as $customer)
            <tr id="customer-row-{{ $customer->id }}" onclick="toggleDetails({{ $customer->id }})"
                style="cursor: pointer;">
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->company }}</td>
                <td>{{ $customer->phone }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->country }}</td>
                <td>{{ $customer->status }}</td>
                <td>
                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-info">Edit</a>
                    <button class="btn btn-danger delete-customer" data-id="{{ $customer->id }}">Delete</button>
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
    <div class="d-flex justify-content-center">
        {{ $customers->links() }}
    </div>
    @endif
</div>

<script>
    function toggleDetails(customerId) {
        const details = document.getElementById('details-' + customerId);
        const isVisible = details.style.display === 'table-row';
        details.style.display = isVisible ? 'none' : 'table-row';
    }

    // Handle AJAX deletion
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-customer').forEach(button => {
            button.addEventListener('click', function (event) {
                event.stopPropagation();
                const customerId = this.getAttribute('data-id');
                const url = `/customers/${customerId}`;

                if (confirm('Are you sure you want to delete this customer?')) {
                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById(`customer-row-${customerId}`).remove();
                            document.getElementById(`details-${customerId}`).remove();
                            alert(data.message);
                        } else {
                            alert('Failed to delete customer.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            });
        });
    });
</script>
@endsection