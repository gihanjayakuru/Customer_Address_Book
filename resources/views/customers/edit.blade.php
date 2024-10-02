@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Customer</h2>
    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $customer->name }}" required>
        </div>
        <div class="form-group">
            <label for="company">Company:</label>
            <input type="text" class="form-control" id="company" name="company" value="{{ $customer->company }}"
                required>
        </div>
        <div class="form-group">
            <label for="phone">Phone Number:</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ $customer->phone }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $customer->email }}" required>
        </div>
        <div class="form-group">
            <label for="country">Country:</label>
            <input type="text" class="form-control" id="country" name="country" value="{{ $customer->country }}"
                required>
        </div>

        <h3>Address Details:</h3>
        <div id="address-fields-list">
            @foreach ($customer->addresses as $index => $address)
            <div class="form-group address-field" id="address-field-{{ $index }}">
                <label>Number:</label>
                <input type="text" class="form-control" name="addresses[{{ $index }}][number]"
                    value="{{ $address->number }}" required>
                <label>Street:</label>
                <input type="text" class="form-control" name="addresses[{{ $index }}][street]"
                    value="{{ $address->street }}" required>
                <label>City:</label>
                <input type="text" class="form-control" name="addresses[{{ $index }}][city]"
                    value="{{ $address->city }}" required>
                <button type="button" class="btn btn-danger remove-address" onclick="removeAddressField({{ $index }})"
                    style="margin-top: 10px;">Remove</button>
            </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-primary add-address" style="margin-bottom: 20px;">Add Address</button>

        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let addressIndex = {{ $customer->addresses->count() }};
        const addAddressButton = document.querySelector('.add-address');
        const addressList = document.getElementById('address-fields-list');

        addAddressButton.addEventListener('click', function () {
            const newField = document.createElement('div');
            newField.classList.add('form-group', 'address-field');
            newField.id = 'address-field-' + addressIndex;
            newField.innerHTML = `
                <label>Number:</label>
                <input type="text" class="form-control" name="addresses[${addressIndex}][number]" required>
                <label>Street:</label>
                <input type="text" class="form-control" name="addresses[${addressIndex}][street]" required>
                <label>City:</label>
                <input type="text" class="form-control" name="addresses[${addressIndex}][city]" required>
                <button type="button" class="btn btn-danger remove-address" onclick="removeAddressField(${addressIndex})" style="margin-top: 10px;">Remove</button>
            `;
            addressList.appendChild(newField);
            addressIndex++;
        });
    });

    function removeAddressField(index) {
        const field = document.getElementById('address-field-' + index);
        field.remove();
    }
</script>
@endsection