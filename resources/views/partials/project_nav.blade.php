<!-- <div id="mySidebar" class="sidebar">
    <div id="side-project-title" class="sidebar-title">{{$project->title}}</div>
    <a href="/project/{{$project->id}}" class="sidebar-btn" aria-current="page"><i class="icon-home" style="margin-right:20px"></i>About</a>
    <a href="/project/{{$project->id}}/files" class="sidebar-btn"><i class="icon-docs" style="margin-right:20px"></i>Files</a>
    <a href="/project/{{$project->id}}/tasks" class="sidebar-btn"><i class="icon-list" style="margin-right:20px"></i>Tasks</a>
    <a href="/project/{{$project->id}}/forum" class="sidebar-btn"><i class="icon-bubble" style="margin-right:20px"></i>Forum</a>
    <a href="/project/{{$project->id}}/members" class="sidebar-btn"><i class="icon-user" style="margin-right:20px"></i>Members</a>
    <a style="margin-top: 25em" href="javascript:void(0)">
        <i id="arrow" class="icon-arrow-left" onclick="changeNav();"></i>
    </a>
</div> -->


<div class="sidenavbar" id="nav-bar">
    <nav class="nav">
        <div>
            <div>
                <div class="sidebar-title pt-5">{{$project->title}}</div>
            </div>
            <div class="nav_list">
                <a  href="/project/{{$project->id}}" class="sidenav_link sidebar-btn">
                    <i class='fa fa-home' style="font-size:28px"></i>
                    <span class="nav_name">Home</span>
                </a>
                <a href="/project/{{$project->id}}/files" class="sidenav_link sidebar-btn">
                    <i class='fa fa-file' style="font-size:28px"></i>
                    <span class="nav_name">File</span>
                </a>
                <a href="/project/{{$project->id}}/tasks"  class="sidenav_link sidebar-btn">
                    <i class='fa fa-tasks' style="font-size:28px"></i>
                    <span class="nav_name">Tasks</span>
                </a>
                <a href="/project/{{$project->id}}/forum" class="sidenav_link sidebar-btn">
                    <i class='fa fa-comment' style="font-size:28px"></i>
                    <span class="nav_name">Forum</span>
                </a>
                <a href="/project/{{$project->id}}/members" class="sidenav_link sidebar-btn">
                    <i class='fa fa-users' style="font-size:28px"></i>
                    <span class="nav_name">Members</span>
                </a>
            </div>
        </div>
        <a href="javascript:void(0)" class="sidenav_link mb-5"><i class='icon-arrow-left' id="header-toggle"></i></a>
    </nav>
</div>



@section('scripts_nav')
<script>
    var open = true;

    function changeNav() {
        if (open === true) {
            document.getElementById("mySidebar").style.width = "60px";
            document.getElementById("arrow").classList.remove("icon-arrow-left");
            document.getElementById("arrow").classList.add("icon-arrow-right");
            open = false;
        } else {
            document.getElementById("mySidebar").style.width = "200px";
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
            nav = document.getElementById('nav-bar');
            title.addEventListener('click', () => {
               nav.classList.toggle('show')
            })
        }

    });
</script>

<style>
    .header {
        display: none;
        font-size: 0;
    }

    .header_toggle {
        color: #2f4f4f;
        font-size: 1.5rem;
        cursor: pointer
    }

    .sidenavbar {
        position: fixed;
        left: 0;
        top: 90px;
        width: 200px;
        background-color: #dbdbdb;
        padding: .5rem 1rem 0 0;
        transition: .5s;
        color: #818181;
        height: 91vh;
        z-index: 200;
    }

    .nav {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        overflow: hidden
    }

    .sidenav_logo,
    .sidenav_link {
        display: grid;
        grid-template-columns: max-content max-content;
        align-items: center;
        column-gap: 1rem;
        padding: .5rem 0 .5rem 1.5vh;
    }

    .sidenav_logo {
        margin-bottom: 2rem
    }

    .nav_logo-icon {
        font-size: 1.25rem;
        color: blueviolet;
    }

    .nav_logo-name {
        color: burlywood;
        font-weight: 700
    }

    .sidenav_link {
        position: relative;
        color: #818181;
        margin-bottom: 2vh;
        transition: .3s
    }

    .sidenav_link:hover {
        color: #2f4f4f;
        text-decoration: none;

    }

    .nav_icon {
        font-size: 1.25rem
    }

    .show {
        left: 0;
        width: 58px;
    }

    .active {
        color: #2f4f4f;
        background-color: lightgrey;
    }

    .active::before {
        content: '';
        position: absolute;
        left: 0;
        width: 2px;
        height: 32px;
        background-color: var(--white-color)
    }

    .height-100 {
        height: 100vh
    }



    @media screen and (max-width: 1200px) {

        .sidenavbar {
            left: 0;
            padding: 0;
            width: 57px;
        }

        .show {
            left: 0;
            width: 57px;
        }
    }


    @media screen and (max-width: 576px) {


        .show {
            left: -30%;
            width: 0;
        }

        .overlay{
            left: 0;
            width: 58px;
        }
    }
</style>

@endsection