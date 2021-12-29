<div class="container d-flex flex-column flex-md-row" style="margin-left:5%;margin-top:60%">
    <nav class="navbar navbar-expand-md navbar-light d-flex flex-md-column">
        <a href="#"></a>

        <div class="collapse navbar-collapse w-100">
            <ul class="navbar-nav flex-md-column">
                <li>
                    <a href="/project/{{$project->id}}" class="sidebar-btn" aria-current="page">About</a>
                </li>
                <li>
                    <a href="#" class="sidebar-btn">Files</a>
                </li>
                <li>
                    <a href="/project/{{$project->id}}/tasks" class="sidebar-btn" >Tasks</a>
                </li>
                <li>
                    <a href="#" class="sidebar-btn" >Forum</a>
                </li>
                <li>
                    <a href="/project/{{$project->id}}/members" class="sidebar-btn" >Members</a>
                </li>
            </ul>
        </div>
    </nav>
</div>
