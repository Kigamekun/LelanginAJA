@extends('layouts.base-admin')


@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
        integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
@endsection


@section('menu')
<li class="menu-item ">
    <a href="/admin" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
    </a>
</li>
<li class="menu-item active">
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


<li class="menu-item ">
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
                        <h4 class="card-header">Auction</h4>
                    </div>
                    <div>
                        {{-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createData">
                            Create Auction
                        </button> --}}
                    </div>
                </div>
                <div class="tabss table-responsive ">
                    <br>
                    <table id="productTable" class="table" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Position</th>
                                <th>User Bid (Name)</th>
                                <th>Product Bid (Name)</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody class="table-border-bottom-0">
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        @if (
                                            $item->id ==
                                                DB::table('auctions')->where('product_id', $item->product_id)->orderBy('auction_price', 'DESC')->first()->id)
                                            <img style="width: 30px" src="{{ url('assets/img/icons/medal.png') }}" alt="">

                                        @endif
                                    </td>
                                    <td>

                                        {{ DB::table('users')->where('id', $item->user_id)->pluck('name')->first() }}
                                    </td>
                                    <td>{{ DB::table('products')->where('id', $item->product_id)->pluck('name')->first() }}
                                    </td>
                                    <td>{{ 'Rp.' . number_format($item->auction_price, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($item->payment_status == 2)
                                            <span class="badge bg-label-success">Sudah Dibayar</span>
                                        @else
                                            <span class="badge bg-label-danger">Belum Dibayar</span>
                                        @endif
                                    </td>
                                    <td style="width: 20%">

                                        @if (
                                            ($item->id ==
                                                DB::table('auctions')->where('product_id', $item->product_id)->orderBy('auction_price', 'DESC')->first()->id) && ($item->payment_status == 2))
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#staticBackdrop" data-id="{{ $item->id }}"
                                            data-no_resi="{{ $item->no_resi }}" data-airplane="{{ $item->airplane }}"
                                            data-courier="{{ $item->courier }}"
                                            data-url="{{ route('admin.auction.ship', ['id' => $item->id]) }}">
                                            Shipping
                                        </button>
                                        @endif
                                        <a class="btn btn-danger"
                                            href="{{ route('admin.auction.delete', ['id' => $item->id]) }}">Delete</a>
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
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" id="updateDialog">
            <div id="modal-content" class="m"
            "
            "
            "odal-content">
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
                    <h5 class="modal-title" id="staticBackdropLabel">Create Auction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.auction.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title"
                                placeholder="Enter Name Auction" required>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location"
                                placeholder="Enter Name Auction" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" class="form-control" id="price" name="price"
                                placeholder="Enter Name Auction" required>
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
        $('#staticBackdrop').on('shown.bs.modal', function(e) {

            var html = `
<div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add Receipt</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="${$(e.relatedTarget).data('url')}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body" id="formResi${$(e.relatedTarget).data('id')}">

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Courier | On Selected (${$(e.relatedTarget).data('courier')})</label>

                            <select   name="courier" class="courier form-select" required>
                                <option value="${$(e.relatedTarget).data('courier')}" selected>Select Courier</option>
                                    <option value="DHL">DHL</option>
                                    <option value="UPS">UPS</option>
                                    <option value="KARGO">KARGO</option>
                            </select>
                        </div>


                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Airplane</label>
                            <input type="text"   name="airplane" value="${$(e.relatedTarget).data('airplane')}"  class="courier form-control">

                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Number Receipt</label>
                            <input type="text" name="no_resi" value="${$(e.relatedTarget).data('no_resi')}" class="form-control" id="exampleFormControlInput1"
                                placeholder="Examples: 1234567890 or JJD0099999999" required>
                        </div>




                        <input type="file" name="file_resi" id="file" class="dropify" required>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>

                </form>
`;


            $('#modal-content').html(html);
            $('.dropify').dropify();
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
