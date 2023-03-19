@extends('layouts.base-admin')

@section('menu')
    <li class="menu-item ">
        <a href="/admin" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Analytics">Dashboard</div>
        </a>
    </li>
    <li class="menu-item ">
        <a href="{{ route('admin.product.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-box"></i>
            <div data-i18n="Analytics">Product</div>
        </a>
    </li>
    <li class="menu-item ">
        <a href="{{ route('admin.banner.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bxs-image"></i>
            <div data-i18n="Analytics">Banner</div>
        </a>
    </li>

    <li class="menu-item ">
        <a href="{{ route('admin.event.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-calendar-event"></i>
            <div data-i18n="Analytics">Events</div>
        </a>
    </li>
    <li class="menu-item active">
        <a href="{{ route('admin.category.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-calendar-event"></i>
            <div data-i18n="Analytics">Category</div>
        </a>
    </li>
    <li class="menu-item ">
        <a href="{{ route('admin.auction.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-flag"></i>
            <div data-i18n="Analytics">Auction</div>
        </a>
    </li>


    <li class="menu-item ">
        <a href="{{ route('admin.help-center.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-help-circle"></i>
            <div data-i18n="Analytics">Help Center</div>
        </a>
    </li>

    <li class="menu-item ">
        <a href="{{ route('admin.notifications.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-bell"></i>
            <div data-i18n="Analytics">Notification</div>
        </a>
    </li>

   @if(Auth::user()->role == 3)
    <li class="menu-item ">
        <a href="{{ route('admin.user.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-user"></i>
            <div data-i18n="Analytics">User</div>
        </a>
    </li>
     <li class="menu-item">
        <a href="{{ route('admin.appointment.index') }}" class="menu-link">

           <i class='menu-icon tf-icons bx bx-group'></i>
            <div data-i18n="Analytics">Appointment</div>
        </a>
    </li>
    @endif
@endsection


@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
        integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
        crossorigin="anonymous" referrerpolicy="no-referrer">

@endsection


@section('content')
    <style>
        .dropify-wrapper .dropify-message p {
            font-size: 14px;
        }

        .tabss {
            padding: 15px;
        }
    </style>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="card">
                <div class="d-flex" style="justify-content: space-between;align-items:center">
                    <div>
                        <h4 class="card-header">Category</h4>
                    </div>
                    <div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createData">
                            Create Category
                        </button>
                    </div>
                </div>
                <div class="tabss table-responsive ">
                    <br>

                    <table id="productTable" class="table" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>

                                <th>Name</th>

                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>

                                    <td>{{ $item->name }}</td>

                                    <td style="width: 20%">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#updateData" data-id="{{ $item->id }}"
                                            data-name="{{ $item->name }}"

                                            data-url="{{ route('admin.category.update', ['id' => $item->id]) }}">
                                             <i class='bx bx-edit'></i>
                                        </button>
                                        <a class="btn btn-danger btn-delete" href="{{ route('admin.category.delete', ['id' => $item->id]) }}"><i class='bx bx-trash' ></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>






    <!-- Modal -->
    <div class="modal fade" id="updateData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="updateDataLabel" aria-hidden="true">
        <div class="modal-dialog" id="updateDialog">
            <div id="modal-content" class="modal-content">
                <div class="modal-body">
                    Loading..
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="createData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="createDataLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div id="modal-content" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Create Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.category.store') }}" method="post" >
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter Name Category" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
        integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('.dropify').dropify();
    </script>

    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#productTable').DataTable({});
        });
    </script>

    <script>
        $('#updateData').on('shown.bs.modal', function(e) {
            var html = `
            <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Create Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="${$(e.relatedTarget).data('url')}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter Name Category" value="${$(e.relatedTarget).data('name')}" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            `;

            $('#modal-content').html(html);


        });
    </script>
       <script>
        $('.btn-delete').on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Do you want to delete this?',
                showDenyButton: true,
                reverseButtons:true,
                showCancelButton: false,
                denyButtonText: `Don't delete`,
                confirmButtonText: 'delete',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Swal.fire('Canceled !', '', 'success');
                    location.href = e.currentTarget.href;
                } else if (result.isDenied) {
                    Swal.fire("You're Data has been saved", '', 'info');
                }
            })
        });
    </script>
@endsection
