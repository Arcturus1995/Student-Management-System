@include('partials.header')
    <?php $array= array('title' => 'Student System')?>
    <x-nav :data="$array"/>


    <header class="max-w-lg mx-auto mt-5">
        <a href="#">
            <h1 class="text-4xl font-bold text-white text-center">Student List</h1>
        </a>
    </header>
    <section class="mt-10">
        <div class="overflow-x-auto relative">
            <table class="w-96 mx-auto text-sm text-left text-gray-500">
                <thead class="tex-xs text-gray-700 uppercase bg-gray-50 ">
                    <tr>
                        <td colspan="5" class="py-4 px-6">
                            <!-- Search Form -->
                            <form action="/students/search" method="GET" class="flex justify-center space-x-2">
                                <input type="text" name="search" placeholder="Search by name or ID" 
                                       class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <button type="submit" 
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                    Search
                                </button>
                            </form>
                            
                            @if($students->isEmpty())
                                <p class="text-center mt-4 text-red-500">No students found.</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="py-3 px-6 ">
                            Student Firstname
                        </th>

                        <th scope="col" class="py-3 px-6">
                            Student Lastname
                        </th>

                        <th scope="col" class="py-3 px-6">
                            Email
                        </th>

                        <th scope="col" class="py-3 px-6">
                            age
                        </th>
                        <th>
                            
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($students as $student)
                        <tr  class="bg-gray-800 border-b text-white">
                            <td class="py-4 px-6">{{$student->first_name}}</td>
                            <td class="py-4 px-6">{{$student->last_name}}</td>
                            <td class="py-4 px-6">{{$student->email}}</td>
                            <td class="py-4 px-6">{{$student->age}}</td>
                            <td class="py-4 px-6">
                                <a href="/student/{{$student->id}}" class="bg-sky-600 text-white px-4 py-2 rounded">view</a>
                            </td>
                        </tr>
                    @endforeach

                    
                </tbody>
            </table>
        </div>
    </section>


@include('partials.footer')

