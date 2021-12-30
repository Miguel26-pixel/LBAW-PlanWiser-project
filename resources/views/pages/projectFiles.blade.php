@extends('layouts.app')

@section('title', 'Projects')

@section('topnavbar')
    @include('partials.navbar')
@endsection

@section('content')
    <div class="row m-0">
        <div class="col-md-2"> @include('partials.project_nav', ['project' => $project])</div>
        <div class="row col-md-10 mt-3">
            <div class="col-md-8">
                <div class="container">
                    <h3 class="text-center">Files</h3>
                    <table class="table table-bordered">
                        <thead class="table-success" >
                        <tr>
                            <th scope="col" style="width: 5%">Type</th>
                            <th scope="col">File Name</th>
                            <th scope="col" class="text-center" style="width: 15%">Upload Date</th>
                            <th scope="col" class="text-center" style="width: 10%">Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $count=0;
                        foreach ($files as $file) {
                            echo '<tr>';
                            echo '<td class="text-center text-primary"><i class="icon-doc"></i></td>';
                            echo '<td><a href="/project/'.$project['id'].'/files/'.$file->id.'/download" class="text-primary" style="text-decoration: none;">'.$file['name'].'</a></td>';
                            echo '<td class="text-center">'.$file['updated_at'].'</td>';
                            echo '<td class="text-center"><a class="btn btn-outline-danger" href="/project/'.$project['id'].'/files/'.$file->id.'/delete"><i class="icon-trash"></i></td>';
                            echo '</tr>';
                            $count++;
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4">
                <div class="container">
                    <h3 class="text-center">Options</h3>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="text-center">Upload File(s)</h4>
                            <form action="/project/{{$project->id}}/files/upload-files" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="input-group my-3">
                                    <input name="input_files[]" class="form-control" type="file" id="formFile" multiple required>
                                    <button class="btn btn-outline-success" type="submit" id="formFile">Upload</button>
                                </div>
                            </form>
                            <br>
                            <!--h4 class="text-center">Upload Folder</h4>
                            <form action="/project/{{$project->id}}/files/upload-folder" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="input-group my-3">
                                    <input name="input_folder[]" class="form-control" type="file" id="formFolder" webkitdirectory>
                                    <input name="dir_name" type="text" id="dir_name" class="d-none">
                                    <button class="btn btn-outline-success" type="submit" id="formFolder">Upload</button>
                                </div>
                            </form>
                            <br-->
                            <h4 class="text-center">Download ZIP</h4>
                            <div class="text-center my-3">
                                <a href="/project/{{$project->id}}/files/downloadZIP" class="btn btn-outline-success"><i class="icon-folder-alt"></i></a>
                            </div>
                        </div>
                        <div class="card-footer">
                            <span class="text-center text-danger"><i class="icon-shield"></i> Warning:</span>
                            Uploading files with a filename that already exists will replace the existing file
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!--script>
        document.getElementById("formFolder").addEventListener("change", function(event) {
            console.log(document.getElementById("formFolder").value);
            let files = event.target.files;
            for (let i=0; i<files.length; i++) {
                console.log(files[i].webkitRelativePath);
            }
            document.getElementById("dir_name").value = files;
        }, false);
    </script-->

@endsection
