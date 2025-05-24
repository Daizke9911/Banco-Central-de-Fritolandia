<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Banco Central de Fritolandia</title>
    <link rel="icon" href="{{asset('files/logo_bcf.png')}}" type="image/x-icon">

    <link rel="stylesheet" href="{{asset('styles/bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Daizke9911/estilosBCF@master/styles/bootstrap.min.css">
  <body  style="background-color: #28283b;">

<div class="container"  style="background-color: #ffffff;">
  <header class="border-bottom lh-1 py-3">
    <div class="row flex-nowrap justify-content-between align-items-center">
      <div class="col-4 pt-1">
        <img src="{{asset('files/logo_bcf.png')}}" alt="logo" width="100px">
      </div>
      <div class="col-4 text-center">
        <h1> Banco Central de Fritolandia</h1>
      </div>
      @if (Route::has('login'))
        <div class="col-4 d-grid justify-content-end align-items-center">
          @auth

            <a class="btn btn-sm btn-outline-primary" href="{{ url('/dashboard') }}">Página Principal</a>
          
          @else

            <a class="btn btn-sm btn-outline-primary my-1" href="{{ route('login') }}">Persona Natural</a>
            
            @if (Route::has('register'))

              <a class="btn btn-sm btn-outline-secondary my-1" href="{{ route('register') }}">Apertura de Cuenta</a>

            @endif
          @endauth
        </div>
      @endif
    </div>
  </header>

<main class="container">
  <div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary">
    <div class="px-0">
      <img src="{{asset('files/IMG_20190325_151927.jpg')}}" alt="protector de la pagina" width="100%">
      <p class="lead my-3">Protector de la página, garantiza la seguridad de sus datos personales. Guardian  desde los cielos.</p>
    </div>
  </div>

  <div class="row g-5">
    <div class="col-md-8">
      <h3 class="pb-4 mb-4 fst-italic border-bottom">
        Himno Nacional
      </h3>

      <article class="blog-post">

        <h6><strong>Estrofa 1:</strong></h6>
        <p>
          Soy un mercenario sin piedad
          Que viaja por el mundo buscando acción
          Un día me contrataron para una misión
          Y me tocó entrenar a un joven indio
        </p>

        <h6><strong>Estribillo:</strong></h6>
        <p>
          Él es el más torpe que he visto jamás
          Todo lo que toca lo hace explotar
          No sabe disparar ni esquivar
          Es la mayor mala suerte del mundo
        </p>

        <h6><strong>Estrofa 2:</strong></h6>
        <p>
          Lo llevé al campo de tiro para enseñarle
          Pero se le escapó un tiro y me hirió el pie
          Luego lo llevé al gimnasio para entrenarle
          Pero se cayó de la cinta y me rompió el diente
        </p>

        <h6><strong>Estribillo:</strong></h6>
        <p>
          Él es el más torpe que he visto jamás
          Todo lo que toca lo hace explotar
          No sabe disparar ni esquivar
          Es la mayor mala suerte del mundo
        </p>

        <h6><strong>Estrofa 3:</strong></h6>
        <p>
          Lo llevé a la selva para practicar
          Pero se perdió entre los árboles y me dejó solo
          Luego lo encontré rodeado de animales
          Y tuve que salvarlo de un oso furioso

        </p>

        <h6><strong>Estribillo:</strong></h6>
        <p>
          Él es el más torpe que he visto jamás
          Todo lo que toca lo hace explotar
          No sabe disparar ni esquivar
          Es la mayor mala suerte del mundo
        </p>

        <h6><strong>Final:</strong></h6>
        <p>
          Al final de la misión lo despedí con alivio
          Y le dije que nunca más lo quería ver
          Pero él me dijo que había aprendido mucho conmigo
          Y que me iba a enviar una postal desde Berlín
        </p>
        
    </article>


    

    </div>

    <div class="col-md-4">
      <div class="position-sticky" style="top: 2rem;">

        <div>
          <h4 class="fst-italic">Encargantes</h4>
          <ul class="list-unstyled">
            <li>
              <a class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top" href="https://articulo.mercadolibre.com.ve/MLV-706462160-bicicleta-rin-20-bmx-tesla-bike-_JM?searchVariation=174579173031#polycard_client=search-nordic&searchVariation=174579173031&position=34&search_layout=stack&type=item&tracking_id=f07f854b-7e6b-4e80-b6dc-3287c8f1f90a">
                <img src="{{asset('files/ovi.jpg')}}" alt="ovi" width="80px">
                <div class="col-lg-8">
                  <h6 class="mb-0">Fundador de la República</h6>
                </div>
              </a>
            </li>
            <li>
              <a class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top" href="https://www.youtube.com/watch?v=cWlugvcnuSA">
                <img src="{{asset('files/daizuke.jpg')}}" alt="presidente" width="80px">
                <div class="col-lg-8">
                  <h6 class="mb-0">Presidente del Banco</h6>
                </div>
              </a>
            </li>
            <li>
              <a class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top" href="https://www.youtube.com/watch?v=EQK39VTHxc4">
                <img src="{{asset('files/chavela.PNG')}}" alt="primer vicepresidente" width="80px">
                <div class="col-lg-8">
                  <h6 class="mb-0">Primer Vicepresidente del Banco</h6>
                </div>
              </a>
            </li>
            <li>
              <a class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top" href="https://www.youtube.com/watch?v=BTtWNfTBDHo">
                <img src="{{asset('files/loser.PNG')}}" alt="segundo vicepresidente" width="80px">
                <div class="col-lg-8">
                  <h6 class="mb-0">Segundo Vicepresidente del Banco</h6>
                </div>
              </a>
            </li>
            <li>
              <a class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top" href="https://www.youtube.com/watch?v=gsnC-MgAmc4">
                <img src="{{asset('files/7678.PNG')}}" alt="gerencia tecnica" width="80px">
                <div class="col-lg-8">
                  <h6 class="mb-0">Gerencia Técnica</h6>
                </div>
              </a>
            </li>
            <li>
              <a class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top" href="https://www.tiktok.com/@ia.ma047/video/7487713717426113798?is_from_webapp=1&sender_device=pc&web_id=7494640262867961349">
                <img src="{{asset('files/blankgabo.PNG')}}" alt="padre" width="80px">
                <div class="col-lg-8">
                  <h6 class="mb-0">Padre Motopiruetero de la República</h6>
                </div>
              </a>
            </li>
        
          </ul>
        </div>

      </div>
    </div>
  </div>

</main>

<footer class="py-5 text-center text-body-secondary bg-body-tertiary">
  <p>Banco Central de Fritolandia - 2025</p>
</footer>

    </body>
</html>