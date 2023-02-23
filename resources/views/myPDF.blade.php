<!DOCTYPE html>
<html>
  <head>
    <title>Barangay Clearance</title>
    <link
      rel="stylesheet"
      href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css"
    />
  </head>
  <body>
    <div class="mx-10">
    <div class="w-2/3 mb-5 pb-5 border-b-2" style="border-color: #6073af; border-width: 0 0 5px 0; ">
      <div>
        <img src="{{public_path('/images/logo.png')}}" alt="" class="float-left w-auto h-24 pt-3" />
      </div>
      <div class="ml-3 clear-right">
        <h3 class="text-center font-serif" style="color: #1a1a1a;">Republic of the Philippines</h3>
        <h3 class="text-center font-serif" style="color: #292929;">National Capital Region</h3>
        <h3 class="text-center font-serif" style="color: #292929;">Municipality of Kodego</h3>
        <h1 class="text-center text-3xl font-serif" style="color: #0526fb;">Barangay SP404</h1>
      </div>
      
    </div>

    <h1 class="font-semibold font-cinzel text-center pt-3 text-lg">OFFICE OF THE BARANGAY CAPTAIN</h1>
    <h1 class="font-semibold font-cinzel text-center pt-6 text-3xl">BARANGAY CLEARANCE</h1>
    <h2 class="pt-14 font-serif font-medium">TO WHOM IT MAY CONCERN:</h2>

    <p class="pt-14 font-serif text-justify">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; This is to certify that <span class="font-medium underline">&nbsp; &nbsp; {{$transaction->name}} &nbsp; &nbsp;</span>, <span class="font-medium underline">&nbsp; &nbsp; {{$transaction->age}} &nbsp; &nbsp;</span> years old, <span class="font-medium underline"> &nbsp; &nbsp; {{$transaction->gender}} &nbsp; &nbsp;</span> and a resident of Barangay SP404, Kodego, National Capital Region is a known to be of good moral character and law-abiding citizen in the community.</p>

    <p class="pt-7 font-serif text-justify">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; To certify further, that he has no derogatory and/or criminal records filed in this barangay.</p>

    <p class="pt-7 font-serif text-justify">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="font-medium">ISSUED</span> this <span class="font-medium underline">&nbsp; &nbsp; {{date('d')}} &nbsp; &nbsp;</span><sup>rd/th</sup> day of <span class="font-medium underline">&nbsp; &nbsp; {{date('m')}} &nbsp; &nbsp;</span>, <span class="font-medium">{{date('Y')}}</span> at Barangay SP404, Kodego, National Capital Region upon request of the interested party for whatever purposes it may serve.</p>
    
    <div class="float-right pt-24">
        <h3 class="uppercase text-left font-serif font-medium ">Juan dela Cruz</h3>
        <p class="font-serif text-left">Barangay Captain</p>
    </div>
    <div class="clear-right pt-20">
        <p>{{__('Transaction No:')}} {{$transaction->id}}</p>
        <p>{{__('Date Issued:')}} {{date('m-d-Y')}}</p>
        <p>{{__('Doc. Stamp: Paid')}}</p>
    </div>
</div>
  </body>
</html>
