<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"><meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Interview-Task</title>
   <link rel="stylesheet" href="{{ asset('asset/css/bootstrap.min.css') }}">
  </head>
  <body style="background-color: rgb(152, 224, 255)">
   
    <div class="container mt-3">
         
      <x-alertmessage type="success"/>
           <div class="d-flex gap-2">
               <button class="btn btn-primary btn-sm" id="showButton">Add UserInfo</button>
                <form action="{{ route('logout') }}" method="POST">
                @csrf
                <a class="btn btn-sm btn-danger" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Sign Out</span>
                </a>
            </form>
           
          </div>
           
              @if (isset($user_update))
              {{-- update form components --}}
              <div class="">
                <x-update :data="$user_update"/>
              </div>
              
              @else
              {{-- insert form components --}}
              <div  id="hiddenDiv" style="display: none;">
                  <x-insert/>
              </div>
            
              @endif    
           

         {{-- Table Start --}}
          
         
         <div class="mt-3 card mb-5">
           <div class="card-header d-flex " style="background-color: #ced2d6">
              <img src="{{ asset('asset/image/logo-dark.png') }}" alt="" style="height:45px;width:200px" class="col-sm-2">
               <h4 class="text-dark mr-2 pt-2 text-center">Assessment Test for Intern</h4>
           
            </div>
            <table class=" table table-bordered">
                <thead class="table-dark">
                  <th>Name</th>
                  <th>Email</th>
                  <th>Other Info</th>
                  <th>Gender</th>
                  <th>Skill</th>
                  <th>Image</th>
                  <th>Action</th>
                </thead>
                <tbody>
                  @foreach ($employees as $employee)
                  <tr>
                       <td>{{ $employee->name }}</td> 
                       <td>{{ $employee->email }}</td> 
                       <td>{{ $employee->other_info }}</td> 
                       <td>{{ $employee->gender }}</td> 
                       <td>
                    
                        
                        @php
                         $skills= json_decode($employee->skill)
                        @endphp
                    
                        @foreach ($skills as $skill)
                          
                          <span class="badge rounded-pill text-bg-info">{{ $skill }}</span>
                        @endforeach
                      
                        </td> 
                          <td align="center">
                            <img src="{{asset('/storage/employee_image/'.$employee->image)}}" alt="" style="width:60px;height:60px;margin:auto"></td>
                        </td>

                       <td class="d-flex gap-2"> 
                          <a href="{{ route('userinfos.edit',['userinfo'=>$employee->id]) }}" class="btn btn-success btn-sm mt-4" name="btn">Edit</a>
                         
                           <form action="{{ route('userinfos.destroy', ['userinfo' => $employee->id]) }}" method="POST">
                              @csrf
                              @method('DELETE')

                              <button type="submit" class="btn btn-danger btn-sm mt-4">Delete</button>
                           </form>

                        </td>
                       
                        
                  </tr>


                  @endforeach
                

                  
                </tbody>
              </table>
              {{ $employees->links() }}
         </div>
    </div>
<script>
  document.getElementById('showButton').addEventListener('click', function() {
    var hiddenDiv = document.getElementById('hiddenDiv');
    if (hiddenDiv.style.display === 'none') {
      hiddenDiv.style.display = 'block';
    } else {
      hiddenDiv.style.display = 'none';
    }
  });
</script>

 
 
   <script src="{{ asset('asset/js/bootstrap.bundle.min.js') }}"></script>

   <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
 
  </body>
</html>
