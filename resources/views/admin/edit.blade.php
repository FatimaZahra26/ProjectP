@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" value="{{ $user->name }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" value="{{ $user->email }}" class="form-control">
        </div>

                        <!-- Add more fields as needed -->

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    /* Internal CSS for styling the form */
    .container {
        margin: 0 auto;
        width: 50%;
        margin-top:150px; 
        background-color: #6e0a8a;
        padding-right: 100px;
        padding-left:50px;
        width:350px;
        height: 300px;
        align-items: center;
       
        color: azure;
    }

    h1 {
        color: #eddcdc;
        padding-top: 50px;
        margin-left: 25%;
    }

    label {
        font-weight: bold;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        margin-bottom: 10px;
        margin-right: 500px;
    }

    .btn-primary {
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        cursor: pointer;
        margin-left: 100%;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }
</style>
@endsection
