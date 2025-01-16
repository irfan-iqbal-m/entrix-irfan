@extends('layouts.app')
@section('content')
<div class="container">
    <br>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Edit Task</h2>
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
            <form action="{{ route('task.update', ['task' => $task->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group m-2">
                    <label for="title"><strong>Title: {{ $task->title }} </strong></label>
                </div>
                <div class="form-group m-2">
                    <label for="description"> <strong>Description:{{ $task->description }} </strong></label>
                </div>

                <div class="form-group m-2">
                    <label for="description"> <strong>Due Date:{{ $task->due_date ? $task->due_date->format('Y-m-d\TH:i') : '' }} </strong></label>

                </div>
                <div class="form-group m-2">
                    <label for="description"> <strong>Assined to :{{$user->name}} </strong></label>

                </div>
                <div class=" form-group m-2">
                    <label for="status">Select Task status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="pending" @if ($task->status == 'pending') selected @endif>Pending</option>
                        <option value="In Progress" @if ($task->status == 'In Progress') selected @endif>In Progress</option>
                        <option value="completed" @if ($task->status == 'completed') selected @endif>Completed</option>
                    </select>
                </div>
                <button type="submit" class="m-2 btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection