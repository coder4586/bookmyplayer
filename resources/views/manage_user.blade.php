@push('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/terms.min.css') }}" type="text/css">
@endpush
@extends('layouts.app')
@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header">
                    Manage User
                </div>
                <div class="card-body">
                    <form id="delete-user-form" action="{{ route('delete-user') }}" method="post">
                        @csrf
                        <div class="form-outline" data-mdb-input-init>
                            <input type="text" name="entity" class="form-control mt-3 mb-3" style="border: 1px solid black; border-radius: 0;" id="inlineFormInputGroup" placeholder="Enter mobile or email" oninput="checkInput()">
                            <button id="delete-btn" type="submit" class="btn w-100" style="background-color: #f1a64e; border: none; border-radius: 0; color: white; transition: background-color 0.3s ease;" onmouseover="this.style.backgroundColor='#e4923b';" onmouseout="this.style.backgroundColor='#f1a64e';">Delete</button>
                        </div>
                    </form>
                    <div id="message-container" style="margin-top: 10px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


<script>
    document.getElementById('delete-user-form').addEventListener('submit', function(event) {
        event.preventDefault();

        fetch(this.action, {
            method: 'POST',
            body: new FormData(this),
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            const messageContainer = document.getElementById('message-container');
            if (data.status === 1) {
                messageContainer.innerHTML = `<div class="alert alert-success" role="alert">${data.message}</div>`;
            } else {
                messageContainer.innerHTML = `<div class="alert alert-danger" role="alert">${data.message}</div>`;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            const messageContainer = document.getElementById('message-container');
            messageContainer.innerHTML = `<div class="alert alert-danger" role="alert">Something went wrong. Please try again later.</div>`;
        });
    });
</script>
