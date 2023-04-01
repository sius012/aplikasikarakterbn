@extends('layouts.master')
@section('content')
<style>
.card{
    padding: 5%;
    margin: 2em;
}
.profil{
    border-radius: 50%;
    height:2em;
    width: 2em;
    margin: 0.5em;
}
.fa-comment-o{
    font-size: 30px;
}
.card-text{
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
  max-width: 300px;
}
.nomor-comment{
    margin-top: -38px;
    margin-left: 22px;
    background: red;
    border-radius: 50%;
    width: 80%;
    text-align: center;
}
.tambah{
    position: fixed;
    z-index: 1;
    margin-left: 28.5em;
    margin-top: 13em;
    border-radius: 50%;
    background: #cb0c9f !important;
    outline: none;
    border: none;
    color: white;
    width: 5%;
    font-size: 40px;
    text-align: center;
}



@media (max-width: 1282px) and (max-height: 802px){
   .tambah{
        margin-left: 22.3em;
        width: 5%;
        margin-top: 44%;
   }
}

@media (max-width: 1025px){
   .tambah{
        margin-left: 22.7em;
        width: 7%;
        margin-top: 40%;
   }
}

@media (max-width: 913px){
   .tambah{
        margin-left: 20em;
        width: 7%;
        margin-top: 120%;
   }
}

@media (max-width: 822px){
   .tambah{
        margin-left: 17.7em;
        width: 8%;
        margin-top: 110%;
   }
}

@media (max-width: 770px){
   .tambah{
        margin-left: 16.4em;
        width: 8%;
        margin-top: 110%;
   }
}

@media (max-width: 543px){
   .tambah{
        margin-left: 10.7em;
        width: 12%;
        margin-top: 90%;
   }
}

@media (max-width: 415px){
   .tambah{
        margin-left: 7.6em;
        width: 15%;
        margin-top: 160%;
   }
}

@media (max-width: 395px){
   .tambah{
        margin-left: 7.1em;
        width: 15%;
        margin-top: 160%;
   }
}

@media (max-width: 376px){
   .tambah{
        margin-left: 6.5em;
        width: 17%;
        margin-top: 120%;
   }
}

@media (max-width: 281px){
   .tambah{
        margin-left: 4.2em;
        width: 23%;
        margin-top: 150%;
   }
}




</style>
    
    <a href=""><button type="button" class="tambah">+</button></a>
    
            <div class="card">
                <b><img class="profil" src="https://img.freepik.com/free-photo/view-snowy-mountain-fir-trees-with-blue-sky-background_9083-8044.jpg"> Max (Asrama Putra)</b> 
                <img class="card-img-top"
                    src="https://img.freepik.com/free-photo/view-snowy-mountain-fir-trees-with-blue-sky-background_9083-8044.jpg"
                    alt="Card image cap">
                <div class="card-body">
                    <a href="#modal/id"><i class="fa fa-comment-o"><p class="nomor-comment">1</p></i></a>
                      <details>
                    <summary class="card-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</summary>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                </details>
                </div>
            </div>


             <div class="card">
                <b><img class="profil" src="https://img.freepik.com/free-photo/view-snowy-mountain-fir-trees-with-blue-sky-background_9083-8044.jpg"> Delila (Asrama Putri)</b> 
                <img class="card-img-top"
                    src="https://img.freepik.com/free-photo/view-snowy-mountain-fir-trees-with-blue-sky-background_9083-8044.jpg"
                    alt="Card image cap">
                <div class="card-body">
                    <a href="#modal/id"><i class="fa fa-comment-o"><p class="nomor-comment">1</p></i></a>
                      <details>
                    <summary class="card-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</summary>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                </details>
                </div>
            </div>

@endsection
