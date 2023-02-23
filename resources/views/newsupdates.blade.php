<x-app>
  @include('partials._welcomenav')
  <!-- Jumbotron -->
  <div
    class="mt-16 px-10 py-20 text-center overflow-hidden bg-no-repeat bg-cover rounded-lg"
    style="
      background-image: url(/images/hero.jpg);
      background-attachment: fixed;
      height: 600px;
      background-size: cover;
      background-position: center
    "
  >
    <div
      class="container mx-auto w-full h-full overflow-hidden  flex justify-evenly align-middle"
      style="background: rgba( 255, 255, 255, 0.25 );
      box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
      backdrop-filter: blur( 4.5px );
      -webkit-backdrop-filter: blur( 4.5px );
      border-radius: 30px;
      border: 1px solid rgba( 255, 255, 255, 0.18 );">
      <div class="md:align-middle py-5 hidden md:flex h-full">
        <img src="{{asset('/images/flag.png')}}" alt="SP404 Logo" >
      </div>
      <div class="flex justify-center items-center h-full w-auto sm:px-3 lg:px-5"
      >
        <div class="block text-center">
          <img class="md:hidden h-40 mx-auto" src="{{asset('/images/flag.png')}}" alt="">
          <h2 class="font-semibold lg:text-6xl text-5xl mb-4 font-cinzel text-slate-700">Barangay SP404</h2>
          <h4 class="font-semibold lg:text-3xl md:text-2xl text-xl mb-6 text-slate-600 align-top px-5 md:px-0"><i class="fa-solid fa-quote-left"></i> Connecting, Empowering, and Innovating Together <i class="fa-solid fa-quote-right"></i></h4>
          <a
            class="inline-block px-6 py-2 mb-1 border-2 border-blue-900 text-blue-800 font-medium text-sm leading-snug uppercase hover:bg-yellow-500 hover:text-white hover:bg-opacity-6 focus:outline-none focus:ring-0 transition duration-150 ease-in-out rounded-md"
            href="#!"
            role="button"
            data-mdb-ripple="true"
            data-mdb-ripple-color="light"
            >Learn more</a
          >
        </div>
      </div>
    </div>
  </div>
  {{-- <div class="bg-blue-600 h-3"></div>
  <div class="bg-red-600 h-3"></div> --}}
  <!-- Container for demo purpose -->
<div class="container my-24 px-6 mx-auto">

  <!-- Section: Design Block -->
  <section class="my-7 text-gray-800 text-center">
      <div class="grid lg:grid-cols-3 gap-2 xl:gap-x-8">
      @foreach($newsandupdates as $newsandupdate)
        <div class="mb-3 lg:mb-0 bg-gray-100 px-5 py-5 rounded-lg shadow-lg relative">
          <div>
            <div
              class="relative overflow-hidden bg-no-repeat bg-cover ripple shadow-lg rounded-lg mb-6"
              data-mdb-ripple="true" data-mdb-ripple-color="light">
              <img src="{{$newsandupdate->image ? asset('/storage/' . $newsandupdate->image) : asset('images/default.png')}}"
                class="w-full" alt="Article Image" />
              <a href="#!">
                <div class="absolute top-0 right-0 bottom-0 left-0 w-full h-full overflow-hidden bg-fixed opacity-0 hover:opacity-100 transition duration-300 ease-in-out"
                  style="background-color: rgba(251, 251, 251, 0.2)"></div>
              </a>
            </div>
            <div class="px-3 mb-20">
              <h5 class="text-lg font-bold mb-3">{{$newsandupdate->title}}</h5>
            <div class="mb-3  text-gray-900 font-medium text-xs flex items-center justify-center uppercase">
              <h5 class="bg-yellow-600 text-white px-3 py-1 rounded-2xl">{{$newsandupdate->category}}</h5>  
            </div>
            <p class="text-gray-500 mb-6">
              <small>Posted <u>{{$newsandupdate->created_at}}</u> by
                <span class="text-gray-900">{{$newsandupdate->user_name}}</span></small>
            </p>
            <h5 class="text-center font-medium mb-6">{{$newsandupdate->sub_title}}</h5>
            <x-news-body :bodyCsv="$newsandupdate->body"/>
            </div>
          </div>
      </div>
      @endforeach
    </div>
  </section>

  <section>
    <div class="mx-auto max-w-screen-xl py-8 px-4 lg:py-16 lg:px-6">
      <div class="mx-auto mb-8 max-w-screen-sm text-center lg:mb-16">
        <h2 class="mb-6 text-center text-6xl font-bold text-gray-800">Our Barangay Officials</h2>
        <p class="font-light text-gray-800 text-2xl lg:mb-16">“A genuine leader is not a searcher for consensus, but a molder of consensus.” -Martin Luther King Jr.</p>
      </div>
      <div class="grid gap-4 md:grid-cols-3">
        @foreach($officials as $official)
        <div class="p-4 shadow">
          <div class="mb-2 h-60 overflow-hidden rounded-lg shadow-lg md:h-80">
            <img src="{{$official->avatar ? asset('/storage/' . $official->avatar) : asset('images/default.png')}}" alt="Image" class="h-full w-full object-cover object-center" />
          </div>
    
          <div class="flex flex-col items-center justify-center">
            <div class="mt-3 text-3xl font-bold text-gray-700">{{$official->barangayofficial_name}}</div>
            <p class="text-1xl mb-3 text-gray-500 md:mb-4 md:text-base">{{$official->role}}</p>
          </div>
        </div>
        @endforeach
      </div>
  </section>
  <!----------------------------------------- ABOUT ------------------------------------->
<div class="mx-auto px-6">
  <section class="mb-32 text-gray-800">
    <h2 class="mb-12 text-center text-7xl font-bold">About our Barangay</h2>

    <div class="mb-12 flex flex-wrap">
      <div class="block mb-6 w-full shrink-0 grow-0 basis-auto lg:mb-0 lg:w-6/12 lg:pr-6">
        <div class="md:flex md:flex-row rounded-lg bg-cover bg-no-repeat shadow-lg " style="background-position: 50%">
          <img src="https://mdbootstrap.com/img/new/standard/city/028.jpg" class="w-96" alt="Louvre" />
          <div class="mt-7">
             <p class="text-3xl text-gray-700 pt-5 mt-5 ml-7">Our Barangay Hall</p>
             <p class="text-2xl text-gray-600 mt-3 ml-7">Our new and modernized Barangay Hall</p>
           </div>
        </div>
      </div>
     
      <div class="w-full shrink-0 grow-0 basis-auto lg:w-6/12 lg:pl-6">
        <h3 class="pt-7 mb-4 text-6xl font-bold">Mission</h3>
        <p class="mb-6 text-3xl text-gray-500">To Govern and Lead <br> with strong implementation of <br> peace and discipline.</p>
      </div>
    </div>

    <div class="mb-12 flex flex-wrap lg:flex-row-reverse">
      <div class="block mb-6 w-full shrink-0 grow-0 basis-auto lg:mb-0 lg:w-6/12 lg:pl-6">
        <div class="flex flex-wrap lg:flex-row-reverse rounded-lg bg-cover bg-no-repeat shadow-lg" style="background-position: 50%">
          <img src="https://mdbootstrap.com/img/new/standard/city/033.jpg" class="w-96" alt="Louvre" />
          <div class="mt-7">
            <p class="text-3xl text-gray-700 pt-5 mt-5 mr-9">SP404 Public Park</p>
            <p class="text-2xl text-gray-700 mt-3 mr-9">A place for socializing.</p>
          </div>
        </div>
      </div>

      <div class="w-full shrink-0 grow-0 basis-auto lg:w-6/12 lg:pr-6">
        <h3 class="pt-5 mb-4 text-6xl font-bold">Vision</h3>
        <p class="text-3xl text-gray-500">To cater all the needs<br>of the citizen physically and virtually</p></p>
    </div>
  </div>

  <div class="mb-12 flex flex-wrap">
    <div class="block mb-6 w-full shrink-0 grow-0 basis-auto lg:mb-0 lg:w-6/12 lg:pr-6">
      <div class="md:flex md:flex-row rounded-lg bg-cover bg-no-repeat shadow-lg" style="background-position: 50%">
        <img src="https://mdbootstrap.com/img/new/standard/city/028.jpg" class="w-96" alt="Louvre" />
        <div>
           <p class="text-2xl text-gray-700 mt-5 ml-5">SAMPLE SAMPLE SAMPLE</p>
         </div>
      </div>
    </div>
      <div class="w-full pt-5 shrink-0 grow-0 basis-auto lg:w-6/12 lg:pl-6">
        <h3 class="mt-8 text-6xl font-bold">Values</h3>
        <div class="mb-4 flex items-center text-sm font-medium text-yellow-600">
        <p class="text-gray-500 text-3xl">Godly, Knowledgable, And Pure.</p>
      </div>
    </div>
  </section>
</div>
</div>
  <!-- Jumbotron -->
  @include('partials._footer')
  
  

  </x-app>