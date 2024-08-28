<div class="card">
          @if (session()->has('message'))
            <span class="alert alert-success p-2 my-2">{{ session('message') }}</span>
          @endif
            <div class="card-body">
              <h5 class="card-title"> Bookmarked Posts</h5>
          
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Image</th>
                    <th scope="col">Title</th>
                    <th scope="col">Content</th>
                    <th scope="col">Posted At</th>
                    <th scope="col">Last Updated</th>
                    <th scope="col" colspan="1">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($posts as $item)
                      <tr wire:key="{{$item->id}}">
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$item->post_title}}</td>
                        <td><img height="40px" width="40px" src="{{ asset('storage/images/' .$item->photo) }}" alt="post image"></td>
                        <td>{{str($item->content)->words(10)}}</td>
                        <td>{{$item->created_at}}</td>
                        <td>{{$item->updated_at}}</td>
                        <td><button wire:click="unbookmarkPost({{$item->id}})" wire:confirm="Are you sure you want to unbookmark this?" class="btn btn-danger btn-sm">Unbookmark</button></td>
                      </tr>
                  @endforeach
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>
