@extends('layouts.app')

@section('topnavbar')
@include('partials.navbar', ['notifications' => $notifications])
@endsection

@section('tasks')

@section('content')

<div class="formbg-outer">
    <div class="formbg">
        <div class="formbg-inner" style="padding: 48px">
            <span style="padding-bottom: 15px">Create a task</span>
            <form method="POST" action='/tasksCreate'>
                {{ csrf_field() }}
                <div class="field" style="padding-bottom: 24px" required autofocus>
                    <label for="name">Name</label>
                    <input type="name" name="name">
                </div>

                <div class="field" style="padding-bottom: 24px" required>
                    <label for="description">Description</label>
                    <input type="description" name="description">
                </div>

                <div class="field" style="padding-bottom: 24px">
                    <label for="tag">Status</label>
                    <select name="tag" class="form-select" aria-label="Disabled select example" required>
                        <option value='TODO'>TODO</option>
                        <option value='DOING'>DOING</option>
                        <option value='REVIEW'>REVIEW</option>
                        <option value='CLOSED'>CLOSED</option>
                    </select>
                </div>

                <div class="field" style="padding-bottom: 24px">
                    <label for="username">Assignee</label>
                    <select name="user_id" class="form-select" aria-label="Disabled select example">
                        <option selected value="-1"> </option>
                        @foreach ($users as $user)
                                <option value="{{ $user['user_id'] }}">{{$user['username']}} </option>
                        @endforeach 
                    </select>
                </div>

                <div class="field" style="padding-bottom: 24px" required>
                    <label for="due_date">Due Date</label>
                    <input class="date form-control" type="date" name="due_date">
                </div>

                <div class="field" style="padding-bottom: 24px" required>
                    <label for="reminder_date">Reminder Date</label>
                    <input name="reminder_date" type="date" class="date form-control">
                </div>

                <div class="field" style="padding-bottom: 24px">
                    <input type="submit" name="submit" value="Create Task">
                    <input name="project_id" type="hidden" value="{{$project -> id}}">
                </div>
            </form>
        </div>
    </div>
@endsection