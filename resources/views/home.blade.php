<x-app>
@include('partials._usernav')
<main class="sm:container mx-5 sm:mx-auto pt-28 mb-20">
    <div class="w-full sm:px-6">

        @include('partials._session')

        <section class="flex flex-col break-words bg-white border-1 rounded-md shadow-lg">

            <header class="font-semibold bg-sky-600 text-gray-50 py-5 px-6 sm:py-6 sm:px-8 rounded-t-md">
                Dashboard
            </header>

            <div class="w-full p-6">
                <p class="text-gray-700">
                    You are logged in as a User!
                </p>
            </div>
        </section>
        <section>
            <div class="w-full pt-6">
                <!--Table Card-->
                <div class="bg-white border-transparent rounded-lg shadow-xl">
                    <div class="bg-gradient-to-b from-gray-300 to-gray-100 uppercase text-gray-800 border-b-2 border-gray-300 rounded-tl-lg rounded-tr-lg p-2">
                        <h2 class="font-bold uppercase text-gray-600">Open Requests</h2>
                    </div>
                    @unless(count($transactions)==0)
                    <div class="max-w-6xl mx-auto py-5 px-2 sm:px-5">
                        <table class="w-full mx-auto py-5 sm:px-5 text-gray-700">
                            <thead>
                            <tr>
                                <th class="text-center text-blue-900">User Id</th>
                                <th class="text-center text-blue-900">Name</th>
                                <th class="text-center text-blue-900 hidden sm:table-cell">Age</th>
                                <th class="text-center text-blue-900 hidden sm:table-cell">Gender</th>
                                <th class="text-center text-blue-900">Request Type</th>
                                <th class="text-center text-blue-900">Processed by</th>
                                <th class="text-center text-blue-900">Status</th>
                            </tr>
                            </thead>
                            
                            <tbody>
                            
                            @foreach($transactions as $transaction)
                            <tr>
                                <td class="text-center">{{$transaction->requesting_id}}</td>
                                <td class="text-center">{{$transaction->name}}</td>
                                <td class="hidden sm:table-cell text-center">{{$transaction->age}}</td>
                                <td class="hidden sm:table-cell text-center">{{$transaction->gender}}</td>
                                <td class="text-center">{{$transaction->type}}</td>
                                <td class="text-center">{{$transaction->issuing_id}}</td>
                                <td class="text-center">@if (($transaction->is_granted)==0) {{__('Denied')}} @else {{__('Approved')}} @endif</td>
                                
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        
                    </div>
                    @else <p class="text-center text-gray-800 py-10">No requests found</p>
                        @endunless
                </div>
                <!--/table Card-->
            </div>
        </section>
        <section class="flex flex-col break-words bg-gray-50 border-1 rounded-md shadow-lg pb-10 mt-5 max-w-xl mx-auto">

            <header class="font-semibold bg-sky-600 text-gray-50 py-5 sm:py-6 px-8 rounded-t-md">
                {{ __('Request a Barangay Clearance') }}
            </header>

            <form class="w-full px-6 space-y-6 sm:px-10 sm:space-y-8 bg-gray-100 pb-10" method="POST"
                action="{{url('/transaction/open')}}">
                @csrf

                <div class="flex flex-wrap">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
                        {{ __('Name') }}:
                    </label>

                    <input id="name" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                        name="name" value="{{old('name')}}" required autocomplete="name" autofocus>

                    @error('name')
                    <p class="text-red-500 text-xs italic mt-4">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <div class="flex flex-wrap">
                    <label for="age" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
                        {{ __('Age') }}:
                    </label>

                    <input id="age" type="number"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" name="age"
                        value="{{ old('age') }}" required autocomplete="age">

                    @error('age')
                    <p class="text-red-500 text-xs italic mt-4">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <div>
                    <label for="gender" class="block mb-2 text-sm font-medium text-gray-900 ">Gender</label>
                    <select id="gender" name="gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                        <option value="" {{old('gender') == "" ? 'selected' : ''}}></option>
                        <option value="Male" {{old('gender') == "Male" ? 'selected' : 'Male'}}>Male</option>
                        <option value="Female" {{old('gender') == "Female" ? 'selected' : 'Female'}}>Female</option>
                    </select>
                      @error('gender')
                          <p class="text-red-500 text-xs mt-2">
                              {{$message}}
                          </p>
                      @enderror
                </div>

                <div>
                    <label for="type" class="block mb-2 text-sm font-medium text-gray-900 ">Type</label>
                    <select id="type" name="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" disabled>
                        {{-- <option value="" {{old('type') == "" ? 'selected' : ''}}></option> --}}
                        <option value="Barangay Clearance" {{old('type') == "Barangay Clearance" ? 'selected' : 'Barangay Clearance'}}>Barangay Clearance</option>
                        <option value="Business Clearance" {{old('type') == "Business Clearance" ? 'selected' : 'Business Clearance'}}>Business Clearance</option>
                        <option value="Indigency Certificate" {{old('type') == "Indigency Certificate" ? 'selected' : 'Indigency Certificate'}}>Indigency Certificate</option>
        
                    </select>
                      @error('type')
                          <p class="text-red-500 text-xs mt-2">
                              {{$message}}
                          </p>
                      @enderror
                </div>

                <div class="flex flex-wrap">
                    <button type="submit"
                        class="w-full select-none font-bold whitespace-no-wrap p-3 rounded-lg text-base leading-normal no-underline text-gray-100 bg-blue-500 hover:bg-blue-700 sm:py-4">
                        {{ __('Submit') }}
                    </button>
                </div>
            </form>

        </section>

    </div>
</x-app>

