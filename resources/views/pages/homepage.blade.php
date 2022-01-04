@extends('layouts.app')

@section('title', 'Homepage')

@section('topnavbar')
@include('partials.navbar', ['notifications' => $notifications])
@endsection

@section('content')
<div class="homepage">
    <div class='d-flex' style='height: 100vh'>
        <div class='col-md-4' style="margin-left: 15%; margin-top: 6%">
            <div class="homepage-title">Work wiser</br> with</br>
                <h class="green-planwiser">PlanWiser</h>
            </div>
            <!-- <h5 class="mt-3" style="color: grey">Ready to be more productive?</h5>
            <form method="GET" action="/register">
                <div class="field input-group rounded w-50"  required autofocus>
                    <input type="email" name="email" id="email" class="form-control rounded pt-2 pb-2" placeholder="Enter your email address" />
                </div>
                <button type="submit" class="input-group-text border-0 shadow mt-2 rose-btn" style="background-color: #ff9391; color: white; font-weight: bold; font-size: 120%" id="get-started">
                    Get Started
                </button>
            </form> -->
        </div>
        <div class="col-md-5 pt-5">
            <div class="container text-center my-3">
                <h2>Public Projects</h2>
            </div>
            <div class="container">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        Public Projects
                        <div class="input-group rounded w-50">
                            <input type="search" name="search" id="publicSearch" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                            <button type="submit" class="input-group-text border-0" id="search-addon">
                                <i class="icon-magnifier"></i>
                            </button>
                        </div>
                    </div>
                    <div id="publicCardBody" class="card-body">
                        <table class="table table-bordered">
                            <thead class="table-success">
                                <tr>
                                    <th scope="col" class="text-center" style="width: 5%"><i class="icon-arrow-right-circle"></i></th>
                                    <th scope="col">Project</th>
                                    <th scope="col" style="width: 55%">Description</th>
                                </tr>
                            </thead>
                            <tbody id="table-projects-body">
                                <?php
                                $count = 1;
                                foreach ($public_projects as $project) {
                                    echo '<tr>';
                                    echo '<th scope="row" class="text-center"><a class="text-info my-rocket" href="/project/' . $project['id'] . '"><i class="icon-rocket"></i></a></th>';
                                    echo '<td>' . $project['title'] . '</td>';
                                    echo '<td>' . $project['description'] . '</td>';
                                    echo '</tr>';
                                    $count++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{ $public_projects->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr />
    <div id="aboutUs" class='d-flex pt-5' style='height: 100vh'>
        <div class='col-md-5' style="margin-left: 15%; margin-top: 6%">
            <div class="homepage-title">
                ABOUT
            </div>
            <h3 class="mt-3" style="color: grey">About plan wiser</h3>
            <div style="font-size:large; padding-top: 10px; padding-right: 15px">
                LOREM IMPSUM LOREM IMPSUM LOREM
                IPSUM LOREM IPSUMLOREM IMPSUM LOREM IMPSUM LOREM IPSUM LOREM IPSUMLOREM IMPSUM LOREM IMPSUM LOREM IPSUM LOREM IPSUMLOREM IMPSUM LOREM IMPSUM LOREM IPSUM LOREM IPSUMLOREM IMPSUM LOREM IMPSUM LOREM IPSUM LOREM IPSUMLOREM IMPSUM LOREM IMPSUM LOREM IPSUM LOREM IPSUMLOREM IMPSUM LOREM IMPSUM LOREM IPSUM LOREM IPSUMLOREM IMPSUM LOREM IMPSUM LOREM IPSUM LOREM IPSUMLOREM IMPSUM LOREM IMPSUM LOREM IPSUM LOREM IPSUMLOREM IMPSUM LOREM IMPSUM LOREM IPSUM LOREM IPSUMLOREM IMPSUM LOREM IMPSUM LOREM IPSUM LOREM IPSUMLOREM IMPSUM LOREM IMPSUM LOREM IPSUM LOREM IPSUMLOREM IMPSUM LOREM IMPSUM LOREM IPSUM LOREM IPSUMLOREM IMPSUM LOREM IMPSUM LOREM IPSUM LOREM IPSUMLOREM IMPSUM LOREM IMPSUM LOREM IPSUM LOREM IPSUMLOREM IMPSUM LOREM IMPSUM LOREM IPSUM LOREM IPSUMLOREM IMPSUM LOREM IMPSUM LOREM IPSUM LOREM IPSUMLOREM IMPSUM LOREM IMPSUM LOREM IPSUM LOREM IPSUMLOREM IMPSUM LOREM IMPSUM LOREM IPSUM LOREM IPSUMLOREM IMPSUM LOREM IMPSUM LOREM IPSUM LOREM IPSUMLOREM IMPSUM LOREM IMPSUM LOREM IPSUM LOREM IPSUM
            </div>
        </div>
        <div class="col-md-5 m-0 d-flex flex-column justify-content-center align-items-center">
            <h3 class="mt-3 text-center" style="color: grey">Team</h3>
            <div class="d-flex gap-5 pb-5">
                <div>
                    <img src="{{ asset('/images/team/team-1.png') }}" class="rounded-circle" style="object-fit: cover; height: 200px; width: 200px">
                    <div class='text-center' style='font-size:large'>
                        Miguel Amorim
                        <p>up201907565</p>
                    </div>
                </div>
                <div>
                    <img src="{{ asset('/images/team/team-2.png') }}" class="rounded-circle" style="object-fit: cover; height: 200px; width: 200px">
                    <div class='text-center' style='font-size:large'>
                        Fernando Rego
                        <p>up201907565</p>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-5">
                <div>
                    <img src="{{ asset('/images/team/team-3.png') }}" class="rounded-circle" style="object-fit: cover; height: 200px; width: 200px">
                    <div class='text-center' style='font-size:large'>
                        Margarida Raposo
                        <p>up201907565</p>
                    </div>
                </div>
                <div>
                    <img src="{{ asset('/images/team/team-4.png') }}" class="rounded-circle" style="object-fit: cover; height: 200px; width: 200px">
                    <div class='text-center' style='font-size:large'>
                        Luísa Marques
                        <p>up201907565</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr />
    <div id="support" class='pt-5' style='height: 100vh'>
        <div class='col-md-5' style="margin-left: 15%; margin-top: 6%">
            <div class="homepage-title">
                SUPPORT
            </div>
        </div>
        <div class='d-flex'>
            <div class='col-md-5' style="margin-left: 15%; margin-top: 3%">
                <h3 class="mt-3 text-center" style="color: grey">Get in touch</h3>
                <div class="formbg">
                    <div class="formbg-inner" style="padding: 48px">
                        <form id="stripe-login" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}
                            <div class="field" style="padding-bottom: 24px" value="{{ old('name') }}" required autofocus>
                                <label for="name">Name</label>
                                <input type="name" name="name">
                            </div>
                            @if ($errors->has('name'))
                            <div class="field">
                                <span class="error">
                                    {{ $errors->first('name') }}
                                </span>
                            </div>
                            @endif
                            <div class="field" style="padding-bottom: 24px" value="{{ old('email') }}" required autofocus>
                                <label for="email">Email</label>
                                <input type="email" name="email">
                            </div>
                            @if ($errors->has('email'))
                            <div class="field">
                                <span class="error">
                                    {{ $errors->first('email') }}
                                </span>
                            </div>
                            @endif
                            <div class="field" style="padding-bottom: 24px" value="{{ old('contact') }}" required autofocus>
                                <label for="contact">Contact</label>
                                <input type="contact" name="contact">
                            </div>
                            @if ($errors->has('contact'))
                            <div class="field">
                                <span class="error">
                                    {{ $errors->first('contact') }}
                                </span>
                            </div>
                            @endif
                            <div class="field" style="padding-bottom: 24px" value="{{ old('message') }}" required autofocus>
                                <label for="message">Message</label>
                                <textarea class="form-control" rows="3" class="input" type="message" name="message"> </textarea>
                            </div>
                            @if ($errors->has('message'))
                            <div class="field">
                                <span class="error">
                                    {{ $errors->first('message') }}
                                </span>
                            </div>
                            @endif
                            <div class="field" style="padding-bottom: 24px">
                                <input type="submit" name="submit" value="Send">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-5 m-0 d-flex flex-column justify-content-center align-items-center" style="margin-left: 15%; margin-top: 6%">
                <h3 class="mt-3 make-a-report" style="color: grey">Contact Us</h3>
                <div class="make-a-report" style="font-size:large">
                    <p style="padding-bottom: 24px">Miguel Amorim - up201907565@fe.up.pt</p>
                    <p style="padding-bottom: 24px">Fernando Rego - up201907565@fe.up.pt</p>
                    <p style="padding-bottom: 24px">Margarida Raposo - up201907565@fe.up.pt</p>
                    <p style="padding-bottom: 24px">Luísa Marques - up201907565@fe.up.pt</p>
                </div>
                <!-- <div onclick="toggleDiv('make-a-report')" class='d-flex gap-3 mt-3'>
                    <div>
                        <h3 style="color: grey">Make a report</h3>
                    </div>
                    <h3><i class="icon-arrow-down-circle"></i></h3>
                </div>
                <div class="formbg make-a-report" style="display: none">
                    <div class="formbg-inner" style="padding: 48px">
                        <span style="padding-bottom: 15px">Log In to your account</span>
                        <form id="stripe-login" method="POST" action='/reportsCreate'>
                            {{ csrf_field() }}
                            <div class="field" style="padding-bottom: 24px" required autofocus>
                                <label for="text">Report's description</label>
                                <input type="text" name="text">
                            </div>
                            @if ($errors->has('text'))
                            <div class="field">
                                <span class="error">
                                    {{ $errors->first('text') }}
                                </span>
                            </div>
                            @endif
                            <div style="padding-bottom: 24px">
                                <label for="report_type">Report Type</label>
                                <div class="d-flex flex-direction-row align-items-center gap-5">
                                    <div class="d-flex gap-2">
                                        <input type="radio" id="user" name="bug" value="user">
                                        <label class="pt-2 for=" user>User</label><br>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <input type="radio" id="bug" name="bug" value="bug">
                                        <label class="pt-2" for="bug">Bug</label><br>
                                    </div>
                                </div>
                            </div>
                            {{ csrf_field() }}
                            <label for="text">User name</label>

                            <div class="field d-flex" style="padding-bottom: 24px" autofocus>
                                <form method="POST" action="/projectsSearch" enctype="multipart/form-data" class="input-group rounded d-flex gap-3">
                                    {{@csrf_field()}}
                                    <input type="search" name="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                                    <button type="submit" class="input-group-text border-0" id="search-addon">
                                        <i class="icon-magnifier"></i>
                                    </button>
                                </form>
                            </div>
                            @if ($errors->has('report_type'))
                            <span class="error">
                                {{ $errors->first('report_type') }}
                            </span>
                            @endif
                            <div class="field" style="padding-bottom: 24px">
                                <input type="submit" name="submit" value="Report">
                            </div>
                        </form>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    <hr />
</div>


@endsection

@section('scripts')
    <script>
        const publicsearch = document.getElementById("publicSearch");
        publicsearch.addEventListener("keyup", searchPublicProject);
        function searchPublicProject() {
            sendAjaxRequest('post', '/api/projectsSearch', {search: publicsearch.value}, publicSearchHandler);
        }
        function publicSearchHandler() {
            //if(this.status != 200) window.location = '/';
            let projects = JSON.parse(this.responseText);
            let body = document.getElementById("table-projects-body");
            let paginations = document.getElementsByClassName('pagination');

            for (let pag of paginations) {
                if (document.getElementById('publicCardBody').contains(pag)) {
                    if (publicsearch.value !== "") {
                        pag.style.display = 'none';
                    } else {
                        if (projects.length > 6)
                            pag.style.display = 'flex';
                    }
                }
            }

            body.innerHTML = "";

            for(project of projects.data) {
                let tr = body.insertRow();
                let link = tr.insertCell();
                link.classList.add('text-center');
                link.innerHTML = '<a class="text-info my-rocket" href="/project/' + project['id'] + '"><i class="icon-rocket"></i></a>';
                let title = tr.insertCell();
                title.innerHTML = project['title'];
                let description = tr.insertCell();
                description.innerHTML = project['description'];
            }
        }

        /*function toggleDiv(classname) {
            var div = document.getElementsByClassName(classname);
            for (i = 0; i < div.length; i++) {
                if (div[i].style.display === "none") {
                    div[i].style.display = "block";
                } else {
                    div[i].style.display = "none";
                }
            }
        }*/
    </script>
    @endsection
