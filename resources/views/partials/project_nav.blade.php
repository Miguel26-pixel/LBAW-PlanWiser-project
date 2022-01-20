<div class="sidenavbar" id="nav-bar">
    <nav class="nav">
        <div class="nav_list mt-5 pt-5">
            <a  href="/project/{{$project->id}}" class="sidenav_link sidebar-btn">
                <i class='fa fa-home' style="font-size:28px"></i>
                <span class="nav_name">About</span>
            </a>
            <a href="/project/{{$project->id}}/files" class="sidenav_link sidebar-btn">
                <i class='fa fa-file' style="font-size:28px"></i>
                <span class="nav_name">Files</span>
            </a>
            <?php if($user_role !== 'VISITOR' && $user_role !== 'GUEST') {?>
            <a href="/project/{{$project->id}}/tasks"  class="sidenav_link sidebar-btn">
                <i class='fa fa-tasks' style="font-size:28px"></i>
                <span class="nav_name">Tasks</span>
            </a>
            <?php } ?>
            <?php if($user_role !== 'VISITOR' && $user_role !== 'GUEST') {?>
            <a href="/project/{{$project->id}}/forum" class="sidenav_link sidebar-btn">
                <i class='fa fa-comment' style="font-size:28px"></i>
                <span class="nav_name">Forum</span>
            </a>
            <?php } ?>
            <?php if($user_role !== 'VISITOR') {?>
            <a href="/project/{{$project->id}}/members" class="sidenav_link sidebar-btn">
                <i class='fa fa-users' style="font-size:28px"></i>
                <span class="nav_name">Members</span>
            </a>
            <?php } ?>
        </div>
        <a href="javascript:void(0)" class="sidenav_link mb-5"><i class='icon-arrow-left' id="header-toggle"></i></a>
    </nav>
</div>



@section('scripts_nav')
<script>
    var open = true;

    function changeNav() {
        if (open === true) {
            document.getElementById("mySidebar").style.width = "150px";
            document.getElementById("arrow").classList.remove("icon-arrow-left");
            document.getElementById("arrow").classList.add("icon-arrow-right");
            open = false;
        } else {
            document.getElementById("mySidebar").style.width = "400px";
            document.getElementById("arrow").classList.remove("icon-arrow-right");
            document.getElementById("arrow").classList.add("icon-arrow-left");
            document.getElementById("side-project-title").style.color = "#2f4f4f";
            open = true;
        }
    }

    document.addEventListener("DOMContentLoaded", function(event) {

        const showNavbar = (toggleId, navId) => {
            const toggle = document.getElementById(toggleId),
                nav = document.getElementById(navId);
                // Validate that all variables exist
                if (toggle && nav) {
                    toggle.addEventListener('click', () => {
                        // show navbar
                        nav.classList.toggle('show');
                        // change icon
                        toggle.classList.toggle('icon-arrow-right');
                    })
                }
        }

        showNavbar('header-toggle', 'nav-bar')


        if (window.screen.width < 576) {
            const title = document.getElementById("side-collapse-menu");
            title.classList.add('fa-bars');
            let nav = document.getElementById('nav-bar');
            title.addEventListener('click', () => {
               nav.classList.toggle('show')
            })
        }

    });
</script>

@endsection
