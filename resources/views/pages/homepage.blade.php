@extends('layouts.app')

@section('title', 'Homepage')

@section('topnavbar')
    <?php if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->is_admin) {?>
    @include('partials.adminnavbar')
    <?php } else { ?>
    @include('partials.navbar', ['notifications' => $notifications])
    <?php } ?>
@endsection

@section('content')
<div class="homepage row justify-content-between align-items-center" style="min-height: calc(100vh - 100px);">
    <div class="col-md-1"></div>
    <div class="col-md-5 homepage-main-title text-center" >
        <div class="text-start d-inline-block">
            Project wiser<br> with<br>
            <span class="green-planwiser">PlanWiser</span><br>
            <span class="ready-to-be">Are u ready to be productive?</span><br>
            <a class="get-started-btn" href="{{ url('/register') }}">Get Started</a>
        </div>
    </div>
    <div class="col-md-5">
        <div class="container text-center my-3">
            <h2>Public Projects</h2>
        </div>
        <div class="container">
            <div class="card" style="min-width: 400px">
                <div class="card-header d-flex justify-content-between align-items-center">
                    Public Projects
                    <div class="input-group rounded w-50">
                        <input type="search" name="search" id="publicSearch" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                        <button type="submit" class="input-group-text border-0" id="search-addon" disabled>
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
    <div class="col-md-1"></div>
</div>

<hr/>

<div id="aboutUs" class='row pt-5'>
    <div class="col-md-1"></div>
    <div class='d-flex col-lg-5' style="flex-direction:column; justify-content:center;">
        <div class="homepage-title">
        ABOUT
        </div>
        <div style="margin-left:13%">
            <h3 class="mt-3" style="color: grey">About PlanWiser</h3>
            <div style="font-size:large; padding-top: 10px; padding-right: 15px">
            PlanWiser aims to be a place where users all over the world can easily manage and organize their projects, whether they are students, amateurs, or professional developers.

            This platform allows members to create projects for everyone to see and to help each other with their public projects.

            </div>
        </div>
    </div>
    <div class="col-lg-5 m-0 d-flex flex-column justify-content-center align-items-center">
        <h3 class="mt-3 text-center" style="color: grey">Team</h3>
        <div class="d-flex gap-5 pb-5">
            <div>
                <img src="{{ asset('/images/team/team-1.png') }}" class="rounded-circle" style="object-fit: cover; height: 200px; width: 200px">
                <div class='text-center' style='font-size:large'>
                    Miguel Amorim
                    <p>up201907756</p>
                </div>
            </div>
            <div>
                <img src="{{ asset('/images/team/team-2.png') }}" class="rounded-circle" style="object-fit: cover; height: 200px; width: 200px">
                <div class='text-center' style='font-size:large'>
                    Fernando Rego
                    <p>up201905951</p>
                </div>
            </div>
        </div>
        <div class="d-flex gap-5">
            <div>
                <img src="{{ asset('/images/team/team-3.png') }}" class="rounded-circle" style="object-fit: cover; height: 200px; width: 200px">
                <div class='text-center' style='font-size:large'>
                    Margarida Raposo
                    <p>up201906784</p>
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
    <div class="col-md-1"></div>
</div>
<hr/>
<div id="support" class='support-spacing row'>
    <div class="col-md-1"></div>
    <div class='col-md-5' style="flex-direction:column; justify-content:center;">
        <div class="homepage-title">
            SUPPORT
        </div>
        <h3 class="mt-3 text-center" style="color: grey">Get in touch</h3>
        <div class="formbg">
            <div class="formbg-inner" style="padding: 48px">
                <form id="stripe-login" method="POST" action="api/sendEmail">
                    {{ csrf_field() }}
                    <div class="field" style="padding-bottom: 24px" value="{{ old('name') }}"  autofocus>
                        <label for="name">Name</label>
                        <input type="name" name="name" required>
                    </div>
                    @if ($errors->has('name'))
                        <div class="field">
                            <span class="error">
                                {{ $errors->first('name') }}
                            </span>
                        </div>
                    @endif
                    <div class="field" style="padding-bottom: 24px" value="{{ old('email') }}"  autofocus>
                        <label for="email">Email</label>
                        <input type="email" name="email" required>
                    </div>
                    @if ($errors->has('email'))
                        <div class="field">
                            <span class="error">
                                {{ $errors->first('email') }}
                            </span>
                        </div>
                    @endif
                    <div class="field" style="padding-bottom: 24px" value="{{ old('message') }}"  autofocus>
                        <label for="message">Message</label>
                        <textarea class="form-control" rows="3" class="input" type="message" name="message" required> </textarea>
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
    <div class="col-md-5 mt-5 d-flex flex-column justify-content-center align-items-center" style="">
        <h3 class="mt-3 make-a-report" style="color: grey">Contact Us</h3>
        <div class="make-a-report" style="font-size:large">
            <p style="padding-bottom: 24px">Miguel Amorim - up201907756@fe.up.pt</p>
            <p style="padding-bottom: 24px">Fernando Rego - up201905951@fe.up.pt</p>
            <p style="padding-bottom: 24px">Margarida Raposo - up201906784@fe.up.pt</p>
            <p style="padding-bottom: 24px">Luísa Marques - up201907565@fe.up.pt</p>
        </div>
    </div>
    <div class="col-md-1"></div>
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
            console.log(projects);
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
            let count = 0;
            for(let project of projects) {
                if (count === 6) break;
                count++;
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
    </script>
@endsection
