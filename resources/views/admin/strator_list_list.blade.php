<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{url('strator_list_shijuan')}}" method="post">
        @csrf

    <table border="1">
            <tr>
            <td></td>
            <td>#</td>
            <td>试卷添加</td>
            </tr>
            @foreach($data as $k=>$v)
            <tr>
            <td><input type="checkbox"></td>
            <td>{{$v->id}}</td>
            <td>{{$v->title}}</td>
            </tr>
            @endforeach
        <tr>
            <td><input type="submit" value="添加试卷"></td>
        </tr>
    </form>

    </table>
</body>
</html>