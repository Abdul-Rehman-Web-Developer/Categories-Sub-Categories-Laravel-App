<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Categories/Sub Categories (Laravel App)</title>
        <!-- some necessary routes -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />

         <!-- Bootstrap core -->
        <link href="{{ URL::to('public/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <!-- sweetalert plugin  -->
        <link href="{{ URL::to('public/vendor/sweetalert/sweetalert.css') }}" rel="stylesheet"> 
        <!-- Custom styles -->
        <link href="{{ URL::to('public/assets/css/main.css') }}" rel="stylesheet">
          
    </head>
    <body >
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <h2>Categories/Sub Categories (Laravel App)</h2>
                    <hr>
                </div>
                <div class="col-md-8 offset-md-2">
                     <button class="btn btn-success btn-md mb-2" data-toggle="modal" data-target="#add-category-modal"> + Add Category</button>
                </div>
                <div class="col-md-8 offset-md-2 categories-container">
                    {!! $categories_html !!}
                   
                </div>
            </div>
        </div>



        <!-- Add Category Modal -->
        <div class="modal fade" id="add-category-modal" tabindex="-1" role="dialog"  aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" > + Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form id='add-category-form' method="POST" action="{{ route('add_category') }}" data-parsley-validate>
                    <div class="form-group">
                        <label class="form-label">Category Title</label>
                        <input class='form-control' type="text" name='title' placeholder="Enter title" required data-parsley-minlength="3" data-parsley-maxlength="200">
                        @csrf
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Add Category" class="btn btn-primary">
                    </div>                    
                </form>
              </div>              
            </div>
          </div>
        </div> <!-- END Add Category Modal -->

        <!-- Add Sub Category Modal -->
        <div class="modal fade" id="add-sub-category-modal" tabindex="-1" role="dialog"  aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" > + Add Sub Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form id='add-sub-category-form' method="POST" action="{{ route('add_sub_category') }}" data-parsley-validate>
                    <div class="form-group">
                        <label class="form-label">Category</label>
                        <input class='form-control' type="text" id='category-title-value' value="" disabled>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sub Category Title</label>
                        <input class='form-control' type="text" name='title' placeholder="Enter title" required data-parsley-minlength="3" data-parsley-maxlength="400">
                    </div>
                    <div class="form-group">
                        @csrf
                        <input type="hidden" name="category_id" value="">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Add Sub Category" class="btn btn-primary">
                    </div>                    
                </form>
              </div>              
            </div>
          </div>
        </div> <!-- END Add Sub Category Modal -->

        <!-- JQuery core -->
        <script src="{{ URL::to('public/vendor/jquery/jquery.min.js') }}"></script>
        <!-- Bootstrap core -->
        <script src="{{ URL::to('public/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- Loading Overlay plugin -->
        <script src="{{ URL::to('public/vendor/jquery.loadingoverlay/loadingoverlay.min.js') }}"></script>
        <script src="{{ URL::to('public/vendor/jquery.loadingoverlay/loadingoverlay_progress.min.js') }}"></script>
        <!-- sweetalert plugin -->
        <script src="{{ URL::to('public/vendor/sweetalert/sweetalert.min.js') }}"></script>
        <!-- Parsely form validation plugin -->
        <script src="{{ URL::to('public/assets/js/parsley.min.js') }}"></script>
        <!-- Custom scripts -->
        <script src="{{ URL::to('public/assets/js/main.js') }}"></script>

    </body>
</html>
