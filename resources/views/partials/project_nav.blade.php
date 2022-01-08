<div id="mySidebar" class="sidebar" style="margin-top:8%;">
  <a href="/project/{{$project->id}}" class="sidebar-btn" aria-current="page"><i class="icon-home" style="margin-right:20px"></i>About</a>
  <a href="/project/{{$project->id}}/files" class="sidebar-btn" ><i class="icon-docs" style="margin-right:20px"></i>Files</a>
  <a href="/project/{{$project->id}}/tasks" class="sidebar-btn" ><i class="icon-list" style="margin-right:20px"></i>Tasks</a>
  <a href="#" class="sidebar-btn" ><i class="icon-bubble" style="margin-right:20px"></i>Forum</a>
  <a href="/project/{{$project->id}}/members" class="sidebar-btn" ><i class="icon-user" style="margin-right:20px"></i>Members</a>

  <a href="javascript:void(0)" style="margin-top:50%;"><i id="arrow" class="icon-arrow-left" onclick="changeNav();"></i></a>
</div>



@section('scripts')
<script>

var open = true;
function changeNav() {
    if(open === true) {
        document.getElementById("mySidebar").style.width = "0";
        document.getElementById("arrow").style.marginTop = "50%";
        document.getElementById("arrow").classList.remove("icon-arrow-left");
        document.getElementById("arrow").classList.add("icon-arrow-up");
        open = false;
    }
    else {
        document.getElementById("mySidebar").style.width = "200px";
        document.getElementById("arrow").style.marginTop = "50%";
        document.getElementById("arrow").classList.remove("icon-arrow-up");
        document.getElementById("arrow").classList.add("icon-arrow-left");
        open = true;
    }
}


</script>
@endsection
