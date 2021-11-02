<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Realm Digital Assessment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card mt-5">
                    <div class="card-body table-responsive">
                        <div class="mb-3">
                            <a class="btn btn-primary shadow-sm" href="">Send Wishes</a>
                        </div>
                        @if (sizeof($todayWishList)> 0)
                        <table class="table table-striped">
                            <tr>
                                <th> Name</th>
                                <th> Surname </th>
                                <th> Date of birth</th>
                                <th> Start Date</th>
                            </tr>
                            @foreach ($todayWishList as $employee )
                            <tr>
                                <td> {{ $employee['name'] }} </td>
                                <td> {{ $employee['lastname'] }} </td>
                                <td> {{ $employee['dateOfBirth'] }} </td>
                                <td> {{ $employee['employmentStartDate'] }} </td>
                            </tr>
                            @endforeach
                        </table>
                        @else
                        <h4 class="text-center"> It's nobody's birthday today</h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
