<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="{{asset('js/app.js')}}"></script>
    <title>Document</title>
</head>
<body>
    {{bukaLarik('POST', ['action'=>' ','id'=>'lol']) }}
    {{larikTersembunyi('id',5)}}
    {{larikTersembunyi('name',"bambang")}}
    {{tutupLarik()}}
    
    <script src="{{asset('js/myjs.js')}}"></script>
    <script>
        $(document).ready(function(){
            alert('lol')
        })
    </script>
</body>

</html>