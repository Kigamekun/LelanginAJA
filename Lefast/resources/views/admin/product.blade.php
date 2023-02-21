@extends('layouts.base-admin')

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

    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: ".editor",
            height: 300,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons paste textcolor",
                "save code fullscreen autoresize codesample autosave responsivefilemanager"
            ],
            menubar: false,
            toolbar1: "undo redo restoredraft | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent table searchreplace",
            toolbar2: "| fontsizeselect | styleselect | link unlink anchor | image media emoticons | forecolor backcolor | code codesample fullscreen ",
            image_advtab: true,
            fontsize_formats: "8px 10px 12px 14px 18px 24px 36px",
            relative_urls: false,
            remove_script_host: false,
            filemanager_access_key: '@filemanager_get_key()',
            filemanager_sort_by: '',
            filemanager_descending: '',
            filemanager_subfolder: '',
            filemanager_crossdomain: '',
            external_filemanager_path: '@filemanager_get_resource(dialog . php)',
            filemanager_title: "File Manager",
            external_plugins: {
                "filemanager": "http://127.0.0.1:8000/js/filemanager.min.js"
            },
            filemanager_access_key: 'key',
        });
    </script>
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
                        <h4 class="card-header">Product</h4>
                    </div>
                    <div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createData">
                            Create Product
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
                                <th>Start From</th>
                                <th>End At</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td style="width: 20%;">
                                        <p>{{ $item->name }}</p>
                                    </td>
                                    <td>{{ 'Rp.' . number_format($item->start_from, 0, ',', '.') }}</td>
                                    <td>{{ $item->end_auction }}</td>
                                    <td>

                                        @if (date('Y-m-d H:i:s') < $item->end_auction)
                                            <span class="badge bg-label-success me-1">Opened</span>
                                        @else
                                            <span class="badge bg-label-danger me-1">Closed</span>
                                        @endif

                                    </td>

                                    <td style="width: 20%">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#updateData" data-id="{{ $item->id }}"
                                            data-thumb="{{ url('thumb/' . $item->thumb) }}"
                                            data-name="{{ $item->name }}" data-description='{!! htmlspecialchars($item->description) !!}'
                                            data-start_from="{{ $item->start_from }}"
                                            data-end_auction="{{ $item->end_auction }}"
                                            data-condition='{!! htmlspecialchars($item->condition) !!}'
                                            data-saleroom_notice='{!! htmlspecialchars($item->saleroom_notice) !!}'
                                            data-catalogue_note='{!! htmlspecialchars($item->catalogue_note) !!}'
                                            data-url="{{ route('admin.product.update', ['id' => $item->id]) }}">
                                            Update
                                        </button>
                                        <a class="btn btn-danger btn-delete"
                                            href="{{ route('admin.product.delete', ['id' => $item->id]) }}">Delete</a>
                                        <a class="btn btn-danger m-3 "
                                            href="{{ route('admin.product.stop', ['id' => $item->id]) }}">Stop Auction</a>
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
                    <h5 class="modal-title" id="staticBackdropLabel">Create Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter name product" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" cols="30" rows="10" class="form-control editor"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="start_from" class="form-label">Start From</label>
                            <input type="number" class="form-control" id="start_from" name="start_from"
                                placeholder="Enter start from product auction" required>
                        </div>
                        <div class="mb-3">
                            <label for="end_auction" class="form-label">End Auction</label>
                            <input type="datetime-local" class="form-control" id="end_auction" name="end_auction"
                                placeholder="Enter end auction" required>
                        </div>
                        <div class="mb-3">
                            <label for="condition" class="form-label">Condtion</label>
                            <textarea name="condition" id="condition" cols="30" rows="10" class="form-control editor"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="saleroom" class="form-label">Saleroom Notice</label>
                            <textarea name="saleroom" id="saleroom" cols="30" rows="10" class="form-control editor"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="catalogue" class="form-label">Catalogue Note</label>
                            <textarea name="catalogue" id="catalogue" cols="30" rows="10" class="form-control editor"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="thumb" class="form-label">thumb Product</label>
                            <input type="file" class="form-control dropify" id="thumb" name="thumb"
                                placeholder="isi thumb">
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

    <script src="https://cdn.tiny.cloud/1/{{ env('TINY_API_TOKEN') }}/tinymce/5/tinymce.min.js" referrerpolicy="origin">
    </script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
        var editor_config = {
            path_absolute: "/",
            selector: '.editor',
            relative_urls: false,
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table directionality",
                "emoticons template paste textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            file_picker_callback: function(callback, value, meta) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName(
                    'body')[0].clientWidth;
                var y = window.innerHeight || document.documentElement.clientHeight || document
                    .getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?editor=' + meta.fieldname;
                if (meta.filetype == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.openUrl({
                    url: cmsURL,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: "yes",
                    close_previous: "no",
                    onMessage: (api, message) => {
                        callback(message.content);
                    }
                });
            }
        };

        tinymce.init(editor_config);
    </script>

    <script>
        $(document).ready(function() {
            $('#productTable').DataTable({});
        });
    </script>

    <script>
        $('#updateData').on('shown.bs.modal', function(e) {
            var html = `
            <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Create Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="${$(e.relatedTarget).data('url')}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" value="${$(e.relatedTarget).data('name')}" id="name" name="name" placeholder="Enter Name Product"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" cols="30" rows="10" class="form-control editor" >${$(e.relatedTarget).data('description')}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="start_from" class="form-label">Start From</label>
                            <input type="number" class="form-control" id="start_from" name="start_from" placeholder="Enter start from value auction"
                            value="${$(e.relatedTarget).data('start_from')}"  required>
                        </div>
                        <div class="mb-3">
                            <label for="end_auction" class="form-label">End Auction : Current (${$(e.relatedTarget).data('end_auction')})</label>
                            <input type="datetime-local"  class="form-control" id="end_auction" name="end_auction" placeholder="enter end auction date"
                                >
                        </div>
                        <div class="mb-3">
                            <label for="condition" class="form-label">Condition</label>
                            <textarea name="condition" id="condition" cols="30" rows="10" class="form-control editor">${$(e.relatedTarget).data('condition')}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="saleroom" class="form-label">Saleroom Notice</label>
                            <textarea name="saleroom" id="saleroom" cols="30" rows="10" class="form-control editor">${$(e.relatedTarget).data('saleroom_notice')}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="catalogue" class="form-label">Catalogue Note</label>
                            <textarea name="catalogue" id="catalogue" cols="30" rows="10" class="form-control editor">${$(e.relatedTarget).data('catalogue_note')}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="thumb" class="form-label">Thumb Product</label>
                            <input type="file" class="form-control dropify" id="thumb" name="thumb" data-default-file="${$(e.relatedTarget).data('thumb')}"
                                placeholder="isi thumb">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            `;

            $('#modal-content').html(html);

            tinymce.remove('textarea');
            tinymce.init(editor_config);
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
                reverseButtons:true,
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
