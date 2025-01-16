@extends('layouts.app')
@section('content')
<div class="container">
    <br>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Add Task</h2>
        </div>
        <div class="col-md-6">
            <div class="float-right">
                <a href="{{ route('task.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
        <br>
        <div class="col-md-12">
            @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
            @endif
            @if (session('error'))
            <div class="alert alert-error" role="alert">
                {{ session('error') }}
            </div>
            @endif
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form action="{{ route('task.store') }}" method="POST">
                @csrf
                <div class="form-group m-2">
                    <label for="title">Title:</label>
                    <input type="text" class="form-control" id="title" name="title">

                </div>

                <div class="form-group m-2">
                    <label for="description">Description:</label>
                    <textarea name="description" class="form-control" id="description" rows="5"></textarea>

                </div>
                <div class="form-group m-2">
                    <label for="user_id">Assign to User:</label>
                    <select class="form-control" id="user_id" name="user_id">
                        <option value="">-- Select User --</option>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group m-2">
                    <label for="description">Due Date:</label>
                    <input type="datetime-local" id="due_date" name="due_date">

                </div>
                <div class="form-group m-2">
                    <label for="status">Select Task status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="pending">Pending</option>
                        <option value="In Progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>

                </div>
                <button type="submit" class="m-2 btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection