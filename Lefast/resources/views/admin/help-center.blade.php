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
<li class="menu-item ">
    <a href="{{ route('admin.auction.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-flag"></i>
        <div data-i18n="Analytics">Auction</div>
    </a>
</li>


<li class="menu-item active">
    <a href="{{ route('admin.help-center.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-help-circle"></i>
        <div data-i18n="Analytics">Help Center</div>
    </a>
</li>

<li class="menu-item ">
    <a href="{{ route('admin.user.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div data-i18n="Analytics">User</div>
    </a>
</li>
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
                        <h4 class="card-header">Help Center</h4>
                    </div>

                </div>
                <div class="tabss table-responsive ">
                    <br>

                    <table id="productTable" class="table" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Ticket ID</th>

                                <th>User</th>
                                <th>Title</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>

                                    <td>{{ $item->ticket_id }}</td>
                                    <td>{{ $item->title }}</td>

                                    <td style="width: 20%">

                                        <a class="btn btn-danger btn-warning" href="">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
    $('.btn-delete').on('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Do you want to delete this?',
            showDenyButton: true,
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
