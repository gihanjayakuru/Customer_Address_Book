@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New Customer</h2>
    <form id="customer-form" action="{{ route('customers.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="company">Company:</label>
            <input type="text" class="form-control" id="company" name="company" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone Number:</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="country">Country:</label>
            <input type="text" class="form-control" id="country" name="country" required>
        </div>

        <h3>Address Details:</h3>
        <div id="address-fields-list">
            <div class="form-group address-field">
                <label>Number:</label>
                <input type="text" class="form-control" name="addresses[0][number]" required>
                <label>Street:</label>
                <input type="text" class="form-control" name="addresses[0][street]" required>
                <label>City:</label>
                <input type="text" class="form-control" name="addresses[0][city]" required>
                <button type="button" class="btn btn-danger remove-address" style="margin-top: 10px;">Remove</button>
            </div>
        </div>
        <button type="button" class="btn btn-primary add-address" style="margin-bottom: 20px;">Add Address</button>

        <button type="submit" class="btn btn-success">Submit</button>
    </form>

    <div id="status-message" class="alert" style="display:none;"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let addressIndex = 1;
        const addAddressButton = document.querySelector('.add-address');
        const addressList = document.getElementById('address-fields-list');

        addAddressButton.addEventListener('click', function () {
            const newField = document.createElement('div');
            newField.classList.add('form-group', 'address-field');
            newField.innerHTML = `
                <label>Number:</label>
                <input type="text" class="form-control" name="addresses[${addressIndex}][number]" required>
                <label>Street:</label>
                <input type="text" class="form-control" name="addresses[${addressIndex}][street]" required>
                <label>City:</label>
                <input type="text" class="form-control" name="addresses[${addressIndex}][city]" required>
                <button type="button" class="btn btn-danger remove-address" style="margin-top: 10px;">Remove</button>
            `;
            addressList.appendChild(newField);
            addressIndex++;
            setupRemoveButtons();
        });

        function setupRemoveButtons() {
            document.querySelectorAll('.remove-address').forEach(button => {
                button.addEventListener('click', function () {
                    this.parentElement.remove();
                });
            });
        }

        setupRemoveButtons();

        // handle ajax form submission
        const customerForm = document.getElementById('customer-form');
        customerForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(customerForm);
            const url = customerForm.getAttribute('action');
            
            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                const statusMessage = document.getElementById('status-message');
                if (data.success) {
                    statusMessage.classList.add('alert-success');
                    statusMessage.textContent = data.message;
                    statusMessage.style.display = 'block';
                   
                    setTimeout(() => window.location.href = '/customers', 1000);
                } else {
                    statusMessage.classList.add('alert-danger');
                    statusMessage.textContent = 'Error: ' + data.message;
                    statusMessage.style.display = 'block';
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
</script>
@endsection