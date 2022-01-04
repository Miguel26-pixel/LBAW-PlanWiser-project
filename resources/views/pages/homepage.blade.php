@extends('layouts.app')

@section('title', 'Homepage')

@section('topnavbar')
@include('partials.navbar', ['notifications' => $notifications])
@endsection

@section('content')
<div class="homepage" style="margin-bottom: 10%">
    <div class="col-md-4 homepage-title">Project wiser</br> with</br><h class="green-planwiser">PlanWiser</h></div>

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

<hr/>

<div id="aboutUs" class='d-flex pt-5' style='height: 100vh'>
    <div class='col-md-5' style="margin-left: 15%;">
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
        </div>
    </div>
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
                        if (projects.data.length > 6)
                            pag.style.display = 'flex';
                    }
                }
            }

            body.innerHTML = "";
            let count = 0;
            for(let project of projects.data) {
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
