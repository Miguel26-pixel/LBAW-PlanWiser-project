<div class="col-md-2 bg-success" style="height: 100vh; position: fixed" >
    <div class="w-100 p-3 text-center">
        <a href="/project/{{$project->id}}/" >{{$project->title}}</a>
    </div>
    <div class="w-100 p-3 text-center">
        <a href="/tasksCreate" class="btn btn-light sidenav-item">About</a>
    </div>
    <div class="w-100 p-3 text-center">
        <a href="/project/{{$project->id}}/files" class="btn btn-light sidenav-item">Files</a>
    </div>
    <div class="w-100 p-3 text-center">
        <a href="/project/{{$project->id}}/tasks" class="btn btn-light sidenav-item">Tasks</a>
    </div>
    <div class="w-100 p-3 text-center">
        <a href="/project/{{$project->id}}/forum" class="btn btn-light sidenav-item">Forúm</a>
    </div>
    <div class="w-100 p-3 text-center">
        <a href="/project/{{$project->id}}/members" class="btn btn-light sidenav-item">Members</a>
    </div>
</div>
