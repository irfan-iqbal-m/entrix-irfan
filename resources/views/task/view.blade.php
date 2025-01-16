@extends('layouts.app')
@section('content')
<div class="container">
    <br>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Task Details</h2>
        </div>
        <div class="col-md-6">
            <div class="float-right">
                <a href="{{ route('task.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
        <br>
        <div class="col-md-12">
            <br><br>
            <div class="task-title">
                <strong>Title: </strong> {{ $task->title }}
            </div>
            <br>
            <div class="task-description">
                <strong>Description: </strong> {{ $task->description }}
            </div>
            <br>
            <div class="task-description">
                <strong>Status: </strong> {{ $task->status }}
            </div>
            <br>


            <div class="task-description">
                <strong>Due Date: </strong> {{ $task->due_date ? $task->due_date->format('Y-m-d\TH:i') : '' }}
            </div>
            <br>
            <div class="task-description">
                <strong>Assined to : </strong> {{$user->name}}
            </div>
        </div>
    </div>
</div>
@endsection