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
    {{bukaLarik('POST', ['action'=>url('submitdatatest'),'id'=>'lol']) }}
    <input type="text" name="test">
    <button type="submit">Kirim</button>
    {{tutupLarik()}}
    
    <script src="{{asset('js/myjs.js')}}"></script>
    <script>
        $(document).ready(function(){
            $("#lol").submit(function(e){
                e.preventDefault()
                $(this).Ajax(function(data){
                    console.log(data);
                },null, {dataType: 'json'});
            })
        })
    </script>
</body>

</html>